<?php

namespace App\Domain\DTO;

class AlmacenesDTO
{
    /**
     * @param localizacionesAlmacenDTO[]|null
     * @param clasificacionesALmacenesDTO[]|null
     */
    public function __construct(

        public ?string $id_almacen = null,
        public ?string $codigo_sap,
        public ?string $descripcion_almacen,
        public ?array $localizacionesAlmacenDTO = null,
        public ?array $clasificacionesAlmacenesDTO = null
    ) {}
}
