<?php

namespace App\Application\Service;

use App\Application\Interface\Service\IGruposService;
use App\Domain\DTO\CronogramaDTO;
use App\Domain\DTO\GruposDTO;
use App\Domain\Model\Cronograma;
use App\Domain\Model\Grupos;
use App\Infrastructure\Repository\GruposRepository;
use App\Infrastructure\Repository\PartNumbersRepository;
use Exception;
use App\Shared\Mapper\Mapper;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Repository\CronogramaRepository;

class GruposService implements IGruposService
{

    private $db;
    private $gruposRepository;
    private $cronogramaRepository;
    private $partNumberRepository;

    public function __construct()
    {
        $this->db = (new Connection())->dbInventarioHwi;
        $this->gruposRepository = new GruposRepository($this->db);
        $this->cronogramaRepository = new CronogramaRepository($this->db);
        $this->partNumberRepository = new PartNumbersRepository($this->db);
    }

    public function onGetGrupos(): array
    {
        $grupos = $this->gruposRepository->onGet();
        return $grupos;
    }

    public function onGetGrupo_By__Id($id): ?GruposDTO
    {
        $grupo = $this->gruposRepository->onGet_By__Id($id);
        $grupoDTO = Mapper::modelToGruposDTO($grupo);
        return $grupoDTO;
    }

    public function saveGrupo(GruposDTO $gruposDTO, CronogramaDTO $cronogramaDTO): bool
    {
        try {
            $this->db->beginTransaction();

            $grupoDescripcion = trim($gruposDTO->descripcion_grupo); // Limpiar espacios

            // 1. Validar si el grupo ya existe
            $existeGrupo = $this->onGetGrupo_By__Grupo($grupoDescripcion); // Usar la descripción limpia

            // Si existe un grupo lanzar excepción
            if ($existeGrupo !== null && !empty($existeGrupo->id_grupo)) {
                throw new \Exception("El grupo '{$grupoDescripcion}' ya se encuentra registrado.");
            }

            // 2. Mapear DTO a Modelo (Grupo)
            $gruposModel = Mapper::GruposDTOToModel($gruposDTO);

            // 3. Guardar el grupo en el repositorio
            $guardarGrupoExitoso = $this->gruposRepository->save($gruposModel);

            if (!$guardarGrupoExitoso) {
                throw new \Exception("Falló la operación de guardar el grupo en el repositorio.");
            }

            // 4. Mapear DTO a Modelo (Cronograma)
            $cronogramaModel = Mapper::CronogramaDTOToModel($cronogramaDTO);

            // 5. Guardar información del grupo en el cronograma
            $guardarGrupoCronograma = $this->cronogramaRepository->save($cronogramaModel);

            if (!$guardarGrupoCronograma) {
                throw new \Exception("Falló la operación de guardar la información del grupo en cronograma.");
            }
            $this->db->commit();

            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function onGetGrupo_By__Grupo($grupo): ?GruposDTO
    {
        $grupo = $this->gruposRepository->onGet_By__Grupo($grupo);
        if ($grupo === null) {
            return null;
        }

        return Mapper::modelToGruposDTO($grupo);
    }

    public function onGet_By__GrupoAndExcludeId(string $grupoNombre, string $idGrupoAExcluir): ?Grupos
    {
        $query = "SELECT id_grupo, descripcion_grupo, fecha_programacion_grupo FROM inventario_hwi_grupos
                  WHERE descripcion_grupo = :descripcion_grupo
                  AND id_grupo != :id_grupo_excluir LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':descripcion_grupo', $grupoNombre, \PDO::PARAM_STR);
        $stmt->bindParam(':id_grupo_excluir', $idGrupoAExcluir, \PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($data === false) {
            return null;
        }
        return new Grupos($data['id_grupo'], $data['descripcion_grupo'], $data['fecha_programacion_grupo'], $data['informacion_migrada_sap_grupo']);
    }

    public function deleteGrupo(string $id): bool
    {
        try {
            $this->db->beginTransaction();

            $desasociarPartNumbers = $this->partNumberRepository->update_By__id_grupo($id);
            if (!$desasociarPartNumbers) {
                throw new Exception("Error al desasociar partnumbers del grupo.");
            }

            $delete_grupo = $this->gruposRepository->delete($id);
            if ($delete_grupo === 0) {
                throw new Exception("No se encontró o no se pudo eliminar el grupo con ID: " . $id);
            }
            $this->db->commit();

            return true;
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function updateGrupoPartNumbersCronograma(GruposDTO $gruposDTO, CronogramaDTO $cronograma_dto): bool
    {
        try {
            $this->db->beginTransaction();
            $idGrupo = $gruposDTO->id_grupo;

            // 1. Validar si el grupo ya existe
            $grupoDescripcion = trim($gruposDTO->descripcion_grupo); // Limpiar espacios
            $existeGrupo = $this->onGet_By__GrupoAndExcludeId($grupoDescripcion, $idGrupo); // Usar la descripción limpia

            // Si existe un grupo lanzar excepción
            if ($existeGrupo !== null && !empty($existeGrupo->id_grupo)) {
                throw new Exception("El grupo '{$grupoDescripcion}' ya se encuentra registrado.");
            }

            // 2. Actualizar la información general del grupo
            $grupoModel = Mapper::GruposDTOToModel($gruposDTO);
            $this->gruposRepository->update($grupoModel);

            // 3. Desasociar TODOS los partnumbers que actualmente pertenecen a este grupo
            $this->partNumberRepository->update_By__id_grupo($idGrupo);

            // 4. Asociar los partnumbers de la NUEVA lista al grupo
            foreach ($gruposDTO->partnumberGruposDTO as $partNumberId) {
                // Asume un método como assignGroupToPartnumber en PartNumberRepository
                $this->partNumberRepository->assignGroupToPartnumber($partNumberId, $idGrupo);
            }

            // 5. consultar el id del cronograma con el id del grupo para hacer el update::
            $cronograma = $this->cronogramaRepository->onGet_by_Id_grupo($idGrupo);
            if (!$cronograma) {
                throw new Exception("No se encontró cronograma para el grupo");
            }
            $id_cronograma = $cronograma->id_cronograma;
            $id_estado_actual = $cronograma->id_estado_cronograma;

            //6. Hacer update de cronograma por ID CRONOGRAMA
            $cronogramaModel = Mapper::CronogramaDTOToModel($cronograma_dto);
            //Asignación del id_cronograma para el update y el id_estado actual ya que este no se actualiza acá
            $cronogramaModel->id_cronograma = $id_cronograma;
            $cronogramaModel->id_estado_cronograma = $id_estado_actual;
            $this->cronogramaRepository->update($cronogramaModel);

            $this->db->commit();

            return true;
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
