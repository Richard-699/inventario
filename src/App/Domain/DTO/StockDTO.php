<?php

namespace App\Domain\DTO;


class StockDTO {

    public function __construct(
        public ?int $id_stock = null,
        public ?int $id_partnumber_stock = null,
        public ?string $id_almacen_stock = null,
        public ?int $id_localizacion_stock = null,
        public ?float $cantidad_stock = null,
        public ?int $presenta_novedad_stock = null,
        public ?float $diferencia_stock = null,
        public ?string $id_informacion_sap_mb52_stock = null 
    ) {}
}
