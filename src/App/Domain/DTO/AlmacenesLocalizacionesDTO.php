<?php

namespace App\Domain\DTO;

class AlmacenesLocalizacionesDTO {

    public function __construct(
        public ?int $id_localizaciones_almacenes  = null,
        public ?int $id_almacen,
        public ?int $id_localizacion_localizaciones
    ) {}
}


