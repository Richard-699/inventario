<?php

namespace App\Application\Service;

use App\Application\Interface\Service\IAlmacenesService;
use App\Domain\DTO\AlmacenesDTO;
use App\Domain\DTO\AlmacenesLocalizacionesDTO;
use App\Domain\Model\Almacenes;
use App\Infrastructure\Repository\AlmacenesRepository;
use App\Infrastructure\Repository\AlmacenesLocalizacionesRepository;
use Exception;
use App\Shared\Mapper\Mapper;
use App\Infrastructure\Database\Connection;

class AlmacenesService implements IAlmacenesService
{

    private $db;
    private $almacenesRepository;
    private $AlmacenesLocalizacionesRepository;

    public function __construct()
    {
        $this->db = (new Connection())->dbInventarioHwi;

        $this->almacenesRepository = new AlmacenesRepository($this->db);
        $this->AlmacenesLocalizacionesRepository = new AlmacenesLocalizacionesRepository($this->db);
    }

    public function onGetAlmacenes(): array
    {
        $almacenes = $this->almacenesRepository->onGet();
        return $almacenes;
    }

    public function onGetAlmacenes_By__Id($id): ?AlmacenesDTO
    {
        $almacenes = $this->almacenesRepository->onGet_By__Id($id);
        $almacenesDTO = Mapper::modelToAlmacenesDTO($almacenes);
        return $almacenesDTO;
    }

    public function onGetAlmacenesLocalizaciones_By_id_almacen($id): ?array
    {
        $localizacionesSelected = $this->AlmacenesLocalizacionesRepository->onGetAlmacenesLocalizaciones_By_id_almacen($id);
        return $localizacionesSelected;
    }


    public function saveAlmacen(AlmacenesDTO $almacenesDTO): bool
    {
        $almacenes = Mapper::AlmacenesDTOToModel($almacenesDTO);
        $guardarAlmacen = $this->almacenesRepository->save($almacenes);

        if (!$guardarAlmacen) {
            return false;
        } else {
            return true;
        }
    }

    public function deleteAlmacen($id): bool
    {
        $delete_almacen = $this->almacenesRepository->delete($id);
        if ($delete_almacen === 0) {
            return false;
        } else {
            return true;
        }
    }

    public function updateLocalizacionesAlmacen(AlmacenesDTO $almacenesDTO): bool
    {
        try {
            $this->db->beginTransaction();

            // 1. Actualizar la información general del almacén (codigo_sap y descripcion_almacen)
            $almacenModel = Mapper::almacenesDTOToModel($almacenesDTO);
            $this->almacenesRepository->update($almacenModel);

            // 2. Borrar las localizaciones asociadas al almacén
            $idAlmacen = $almacenesDTO->id_almacen;
            $this->AlmacenesLocalizacionesRepository->delete($idAlmacen);

            // 3. Registrar las nuevas localizaciones asociadas
            foreach ($almacenesDTO->localizacionesAlmacenDTO as $localizacionAlmacenDTO) {
                $almacenLocalizacionModel = Mapper::almacenesLocalizacionesDTOToModel($localizacionAlmacenDTO);
                $this->AlmacenesLocalizacionesRepository->save($almacenLocalizacionModel);
            }

            $this->db->commit();

            return true;
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
