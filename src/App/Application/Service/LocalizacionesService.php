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
    private $AlmacenesLocalizacionesRepository;

    public function __construct()
    {
        $this->db = (new Connection())->dbInventarioHwi;

        $this->localizacionesRepository = new LocalizacionesRepository($this->db);
        $this->tipoLocalizacionesRepository = new TipoLocalizacionesRepository($this->db);
        $this->tipoAlmacenamientoRepository = new TipoAlmacenamientoRepository($this->db);
        $this->AlmacenesLocalizacionesRepository = new AlmacenesLocalizacionesRepository($this->db);
    }

    public function onGetLocalizaciones(): array
    {
        $localizaciones = $this->localizacionesRepository->onGet();
        $tiposLocalizaciones = $this->onGetTipoLocalizaciones();

        // Agregar los tipos a cada localización
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
        $AlmacenesLocalizaciones = $this->AlmacenesLocalizacionesRepository->onGet();
        return $AlmacenesLocalizaciones;
    }
}
