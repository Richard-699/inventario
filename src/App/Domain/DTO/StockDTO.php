<?php

namespace App\Domain\DTO;
class StockDTO {

    public function __construct(
        public ?int $id_stock = null,
        public ?int $id_partnumber_stock = null,
        public ?string $id_almacen_stock = null,
        public ?int $id_localizacion_stock = null,
        public ?string $cantidad_stock = null,
        public ?string $id_informacion_sap_mb52_stock  = null,
        public ?int $id_novedad_stock  = null,
        public ?string $observaciones_novedad_stock = null ,
        public ?string $id_grupo_stock  = null,
        public ?int $id_conteo_stock  = null,
        public ?string $fecha_hora_stock  = null,
        public ?string $id_administrador_stock = null
    ) {}
}
