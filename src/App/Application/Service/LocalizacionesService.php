<?php

namespace App\Application\Service;

use App\Application\Interface\Service\ILocalizacionesService;
use App\Domain\DTO\LocalizacionesDTO;
use App\Infrastructure\Repository\LocalizacionesRepository;
use App\Infrastructure\Repository\AlmacenesLocalizacionesRepository;
use App\Infrastructure\Repository\TipoLocalizacionesRepository;
use App\Infrastructure\Repository\TipoAlmacenamientoRepository;
use Exception;
use App\Shared\Mapper\Mapper;
use App\Infrastructure\Database\Connection;

class LocalizacionesService implements ILocalizacionesService
{

    private $db;
    private $localizacionesRepository;
    private $tipoLocalizacionesRepository;
    private $tipoAlmacenamientoRepository;
    private $almacenesLocalizacionesRepository;

    public function __construct()
    {
        $this->db = (new Connection())->dbInventarioHwi;

        $this->localizacionesRepository = new LocalizacionesRepository($this->db);
        $this->tipoLocalizacionesRepository = new TipoLocalizacionesRepository($this->db);
        $this->tipoAlmacenamientoRepository = new TipoAlmacenamientoRepository($this->db);
        $this->almacenesLocalizacionesRepository = new AlmacenesLocalizacionesRepository($this->db);
    }

    public function onGetLocalizaciones(): array
    {
        $localizaciones = $this->localizacionesRepository->onGet();
        $tiposLocalizaciones = $this->onGetTipoLocalizaciones();
        $tiposAlmacenamientos = $this->onGetTipoAlmacenamiento();

        // Agregar los tipos de loc a cada localización
        foreach ($localizaciones as $localizacion) {
            $id = $localizacion->id_tipo_localizacion_localizaciones ?? null;
            foreach ($tiposLocalizaciones as $tipo) {
                if ($id == $tipo->id_tipo_localizacion) {
                    $localizacion->tipo_localizacion = $tipo->descripcion_tipo_localizacion;
                }
            }
        }

        // Agregar los tipos de almacenamiento a cada localización
        foreach ($localizaciones as $localizacion) {
            $id = $localizacion->id_tipo_almacenamientos_localizaciones ?? null;
            foreach ($tiposAlmacenamientos as $tipo) {
                if ($id == $tipo->id_tipo_almacenamiento) {
                    $localizacion->tipo_almacenamiento = $tipo->descripcion_tipo_almacenamiento;
                }
            }
        }

        return $localizaciones;
    }

    public function onGetLocalizaciones_By__Id_Almacen($id_almacen): array
    {
        $almacenes_localizaciones = $this->almacenesLocalizacionesRepository->onGetAlmacenesLocalizaciones_By_Id_Almacen($id_almacen);
        $localizaciones = [];

        foreach ($almacenes_localizaciones as $almacen_localizacion){
            $id_localizacion = $almacen_localizacion->id_localizacion_localizaciones;
            $localizacion = $this->localizacionesRepository->onGet_By__Id($id_localizacion);
            $localizacionDTO = Mapper::modelToLocalizacionesDTO($localizacion);
            $localizaciones[] = $localizacionDTO;
        }

        $tiposLocalizaciones = $this->onGetTipoLocalizaciones();

        foreach ($localizaciones as $localizacion) {
            $id = $localizacion->id_tipo_localizacion_localizaciones ?? null;
            foreach ($tiposLocalizaciones as $tipo) {
                if ($id == $tipo->id_tipo_localizacion) {
                    $localizacion->tipo_localizacion = $tipo->descripcion_tipo_localizacion;
                }
            }
        }

        return $localizaciones;
    }

    public function onGetTipoLocalizaciones(): array
    {
        $tiposLocalizaciones = $this->tipoLocalizacionesRepository->onGet();
        return $tiposLocalizaciones;
    }

    public function onGetTipoAlmacenamiento(): array
    {
        $tiposAlmacenamiento = $this->tipoAlmacenamientoRepository->onGet();
        return $tiposAlmacenamiento;
    }

    public function onGetLocalizacion_By__Id($id): LocalizacionesDTO
    {
        $localizacion = $this->localizacionesRepository->onGet_By__Id($id);
        $localizacionDTO = Mapper::modelToLocalizacionesDTO($localizacion);

        $tiposLocalizaciones = $this->onGetTipoLocalizaciones();
        $tiposAlmacenamientos = $this->onGetTipoAlmacenamiento();

        $idTipoLoc = $localizacionDTO->id_tipo_localizacion_localizaciones ?? null;
        foreach ($tiposLocalizaciones as $tipo) {
            if ($idTipoLoc == $tipo->id_tipo_localizacion) {
                $localizacionDTO->tipo_localizacion = $tipo->descripcion_tipo_localizacion;
            }
        }

        $idTipoAlm = $localizacionDTO->id_tipo_almacenamientos_localizaciones ?? null;
        foreach ($tiposAlmacenamientos as $tipo) {
            if ($idTipoAlm == $tipo->id_tipo_almacenamiento) {
                $localizacionDTO->tipo_almacenamiento = $tipo->descripcion_tipo_almacenamiento;
            }
        }

        return $localizacionDTO;
    }

    public function deleteLocalizacion($id): bool
    {
        $delete_localizacion = $this->localizacionesRepository->delete($id);
        if ($delete_localizacion === 0) {
            return false;
        } else {
            return true;
        }
        return true;
    }

    public function saveLocalizacion(LocalizacionesDTO $localizacionesDTO): bool
    {
        $localizaciones = Mapper::LocalizacionesDTOToModel($localizacionesDTO);
        $guardarLocalizacion = $this->localizacionesRepository->save($localizaciones);

        if (!$guardarLocalizacion) {
            return false;
        } else {
            return true;
        }
    }

    public function updateLocalizacion(LocalizacionesDTO $localizacionesDTO): bool
    {
        $localizaciones = Mapper::LocalizacionesDTOToModel($localizacionesDTO);
        $guardarLocalizacion = $this->localizacionesRepository->update($localizaciones);

        if (!$guardarLocalizacion) {
            return false;
        } else {
            return true;
        }
    }

    public function onGetAlmacenesLocalizaciones(): array
    {
        $AlmacenesLocalizaciones = $this->almacenesLocalizacionesRepository->onGet();
        return $AlmacenesLocalizaciones;
    }
}
