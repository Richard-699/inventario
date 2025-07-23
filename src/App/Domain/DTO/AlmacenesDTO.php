<?php

namespace App\Domain\DTO;

class AlmacenesDTO
{
    /**
     * @param localizacionesAlmacenDTO[]|null
     */
    public function __construct(

        public ?int $id_almacen = null,
        public ?string $codigo_sap,
        public ?string $descripcion_almacen,
        public ?array $localizacionesAlmacenDTO = null
    ) {}
}
