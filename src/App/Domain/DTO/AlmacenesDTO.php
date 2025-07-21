<?php

namespace App\Domain\DTO;

class AlmacenesDTO {

    public function __construct(
        public ?int $id_almacen = null,
        public ?string $codigo_sap,
        public ?string $descripcion_almacen
    ) {}
}


