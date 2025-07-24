<?php

namespace App\Application\Service;

use App\Application\Interface\Service\IGruposService;
use App\Domain\DTO\GruposDTO;
use App\Domain\Model\Grupos;
use App\Infrastructure\Repository\GruposRepository;
use App\Infrastructure\Repository\PartNumbersRepository;
use Exception;
use App\Shared\Mapper\Mapper;
use App\Infrastructure\Database\Connection;

class GruposService implements IGruposService
{

    private $db;
    private $gruposRepository;
    private $partNumberRepository;

    public function __construct()
    {
        $this->db = (new Connection())->dbInventarioHwi;
        $this->gruposRepository = new GruposRepository($this->db);
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

    public function saveGrupo(GruposDTO $gruposDTO): bool
    {
        try {
            $grupoDescripcion = trim($gruposDTO->descripcion_grupo); // Limpiar espacios

            // 1. Validar si el grupo ya existe
            $existeGrupo = $this->onGetGrupo_By__Grupo($grupoDescripcion); // Usar la descripción limpia

            // Si existe un grupo lanzar excepción
            if ($existeGrupo !== null && !empty($existeGrupo->id_grupo)) {
                throw new Exception("El grupo '{$grupoDescripcion}' ya se encuentra registrado.");
            }

            // 2. Mapear DTO a Modelo
            $gruposModel = Mapper::GruposDTOToModel($gruposDTO);

            // 3. Guardar el grupo en el repositorio
            $guardarGrupoExitoso = $this->gruposRepository->save($gruposModel);

            if (!$guardarGrupoExitoso) {
                throw new Exception("Falló la operación de guardar el grupo en el repositorio.");
            }

            return true;
        } catch (\Throwable $e) {
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

    public function onGet_By__GrupoAndExcludeId(string $grupoNombre, int $idGrupoAExcluir): ?Grupos
    {
        $query = "SELECT id_grupo, descripcion_grupo FROM inventario_hwi_grupos
                  WHERE descripcion_grupo = :descripcion_grupo
                  AND id_grupo != :id_grupo_excluir LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':descripcion_grupo', $grupoNombre, \PDO::PARAM_STR);
        $stmt->bindParam(':id_grupo_excluir', $idGrupoAExcluir, \PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($data === false) {
            return null;
        }
        return new Grupos($data['id_grupo'], $data['descripcion_grupo']);
    }

    public function deleteGrupo(int $id): bool
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

    public function updateGrupoPartNumbers(GruposDTO $gruposDTO): bool
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


            $this->db->commit();

            return true;
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
