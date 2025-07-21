<?php

namespace App\Domain\DTO;

class LocalizacionesDTO {

    public function __construct(
        public ?int $id_localizacion = null,
        public ?int $id_tipo_localizacion_localizaciones,
        public ?string $tipo_localizacion,
        public ?string $descripcion_localizacion
    ) {}
}


