<?php

namespace App\Application\Service;

use App\Application\Interface\Service\IAlmacenesService;
use App\Domain\DTO\AlmacenesClasificacionesAlmacenesDTO;
use App\Domain\DTO\AlmacenesDTO;
use App\Domain\DTO\AlmacenesLocalizacionesDTO;
use App\Domain\Model\Almacenes;
use App\Domain\Model\ClasificacionAlmacenes;
use App\Domain\Model\AlmacenesClasificacionesAlmacenes;
use App\Infrastructure\Repository\ClasificacionAlmacenesRepository;
use App\Infrastructure\Repository\AlmacenesRepository;
use App\Infrastructure\Repository\AlmacenesLocalizacionesRepository;
use App\Infrastructure\Repository\AlmacenesClasificacionesAlmacenesRepository;
use Exception;
use App\Shared\Mapper\Mapper;
use App\Infrastructure\Database\Connection;

class AlmacenesService implements IAlmacenesService
{

    private $db;
    private $almacenesRepository;
    private $AlmacenesLocalizacionesRepository;
    private $clasificacionesRepository;
    private $AlmacenesClasificacionesAlmacenesRepository;
    public function __construct()
    {
        $this->db = (new Connection())->dbInventarioHwi;

        $this->almacenesRepository = new AlmacenesRepository($this->db);
        $this->AlmacenesLocalizacionesRepository = new AlmacenesLocalizacionesRepository($this->db);
        $this->clasificacionesRepository = new ClasificacionAlmacenesRepository($this->db);
        $this->AlmacenesClasificacionesAlmacenesRepository = new AlmacenesClasificacionesAlmacenesRepository($this->db);
    }

    public function onGetAlmacenes(): array
    {
        $almacenes = $this->almacenesRepository->onGet();
        return $almacenes;
    }

    public function onGetClasificacionesAlmacenes(): array
    {
        $clasificaciones = $this->clasificacionesRepository->onGet();
        return $clasificaciones;
    }

    public function onGetAlmacenes_By__Id($id): ?AlmacenesDTO
    {
        $almacenes = $this->almacenesRepository->onGet_By__Id($id);
        $almacenesDTO = Mapper::modelToAlmacenesDTO($almacenes);
        return $almacenesDTO;
    }

    public function onGetClasificacionesAlmacenes_By_id_almacen($id): ?array
    {
        $clasificaciones = $this->AlmacenesClasificacionesAlmacenesRepository->onGet_By__Id($id);
        return $clasificaciones;
    }

    public function onGetAlmacenesLocalizaciones_By_id_almacen($id): ?array
    {
        $localizacionesSelected = $this->AlmacenesLocalizacionesRepository->onGetAlmacenesLocalizaciones_By_id_almacen($id);
        return $localizacionesSelected;
    }

    public function saveAlmacen(AlmacenesDTO $almacenesDTO): bool
    {
        try {
            $this->db->beginTransaction(); // Inicia la transacción

            // 1. Convertir DTO a modelo
            $almacenes = Mapper::AlmacenesDTOToModel($almacenesDTO);

            // 2. Guardar el almacén
            $guardarAlmacen = $this->almacenesRepository->save($almacenes);
            if (!$guardarAlmacen) {
                throw new Exception("No se pudo guardar el almacén");
            }

            // 3. Obtener el ID del almacén
            $idAlmacen = $almacenesDTO->id_almacen;

            // 4. Asociar clasificaciones al almacén
            foreach ($almacenesDTO->clasificacionesAlmacenesDTO as $idClasificacion) {
                // Crear el modelo esperado por el método save()
                $AlmacenesClasificacionesAlmacenesModel = new AlmacenesClasificacionesAlmacenes(
                    id_almacenes_clasificaciones_almacenes: null,
                    id_almacen_almacenes_clasificaciones_almacenes: (string)$idAlmacen,
                    id_clasificacion_almacenes_almacenes_clasificaciones_almacenes: (int)$idClasificacion
                );
                $guardarRelacion = $this->AlmacenesClasificacionesAlmacenesRepository->save($AlmacenesClasificacionesAlmacenesModel);

                if (!$guardarRelacion) {
                    throw new Exception("No se pudo asociar clasificación al almacén");
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            error_log('Error al guardar almacén con clasificaciones: ' . $e->getMessage());
            return false;
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

            // 1. Actualizar datos generales del almacén
            $almacenModel = Mapper::almacenesDTOToModel($almacenesDTO);
            $this->almacenesRepository->update($almacenModel);

            $idAlmacen = $almacenesDTO->id_almacen;

            // 2. Actualizar LOCALIZACIONES

            // 2.1 Eliminar localizaciones actuales
            $this->AlmacenesLocalizacionesRepository->delete($idAlmacen);

            // 2.2 Insertar nuevas localizaciones
            foreach ($almacenesDTO->localizacionesAlmacenDTO as $localizacionAlmacenDTO) {
                $almacenLocalizacionModel = Mapper::almacenesLocalizacionesDTOToModel($localizacionAlmacenDTO);
                $this->AlmacenesLocalizacionesRepository->save($almacenLocalizacionModel);
            }

            // 3. Actualizar CLASIFICACIONES
            if (property_exists($almacenesDTO, 'clasificacionesAlmacenesDTO')) {
                // 3.1 Eliminar clasificaciones actuales
                $respondeEliminar = $this->AlmacenesClasificacionesAlmacenesRepository->delete($idAlmacen);
                if ($respondeEliminar) {
                    // 3.2 Insertar nuevas clasificaciones
                    foreach ($almacenesDTO->clasificacionesAlmacenesDTO as $clasificacionDTO) {
                        $clasificacionModel = Mapper::ClasificacionesAlmacenesDTOToModel($clasificacionDTO);
                        $this->AlmacenesClasificacionesAlmacenesRepository->save($clasificacionModel);
                    }
                }
            }

            // 4. Confirmar cambios
            $this->db->commit();
            return true;
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
