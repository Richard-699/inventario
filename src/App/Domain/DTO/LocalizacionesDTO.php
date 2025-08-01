<?php

namespace App\Domain\DTO;

class LocalizacionesDTO {

    public function __construct(
        public ?int $id_localizacion,
        public ?int $id_tipo_localizacion_localizaciones,
        public ?string $descripcion_localizacion,
        public ?int $id_tipo_almacenamientos_localizaciones,
        public ?string $tipo_localizacion = null
    ) {}
}


