<?php

namespace App\Application\Service;

use App\Application\Interface\Service\ILocalizacionesService;
use App\Infrastructure\Repository\LocalizacionesRepository;
use App\Infrastructure\Repository\TipoLocalizacionesRepository;
use Exception;
use App\Shared\Mapper\Mapper;
use App\Infrastructure\Database\Connection;

class LocalizacionesService implements ILocalizacionesService
{

    private $db;
    private $localizacionesRepository;
    private $tipoLocalizacionesRepository;

    public function __construct()
    {
        $this->db = (new Connection())->dbInventarioHwi;

        $this->localizacionesRepository = new LocalizacionesRepository($this->db);
        $this->tipoLocalizacionesRepository = new TipoLocalizacionesRepository($this->db);
    }

    public function onGetLocalizaciones(): array
    {
        $localizaciones = $this->localizacionesRepository->onGet();
        $tiposLocalizaciones = $this->tipoLocalizacionesRepository->onGet();

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
}