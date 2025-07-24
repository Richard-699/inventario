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


    public function saveGrupo(gruposDTO $gruposDTO): bool
    {
        $grupos = Mapper::GruposDTOToModel($gruposDTO);
        $guardarGrupo = $this->gruposRepository->save($grupos);

        if (!$guardarGrupo) {
            return false;
        } else {
            return true;
        }
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

    public function updateGrupoPartNumbers(GruposDTO $GruposDTO): bool
    {
        try {
            $this->db->beginTransaction();

            // 1. Actualizar la información general del grupo
            $grupoModel = Mapper::GruposDTOToModel($GruposDTO);
            $this->gruposRepository->update($grupoModel);

            // 3. actualizar los partnumbers asociados
/*             foreach ($GruposDTO->partnumberGruposDTO as $partnumberGrupoDTO) {
                $grupoPartNumberModel = Mapper::almacenesLocalizacionesDTOToModel($localizacionAlmacenDTO);
                $this->AlmacenesLocalizacionesRepository->save($almacenLocalizacionModel);
            } */

            $this->db->commit();

            return true;
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
