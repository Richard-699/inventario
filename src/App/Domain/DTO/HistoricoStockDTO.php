<?php

namespace App\Domain\DTO;

class HistoricoStockDTO
{
    public function __construct(
        public ?int $id_historico_stock = null,
        public ?string $fecha_historico_stock,
        public ?string $cantidad_historico_stock,
        public ?string $id_almacen_historico_stock,
        public ?int $id_localizacion_historico_stock ,
        public ?string $id_informacion_sap_mb52_historico_stock,
        public ?int $id_partnumber_historico_stock ,
        public ?string $id_novedad_historico_stock ,
        public ?string $observaciones_novedad_historico_stock,
        public ?string $id_grupo_historico_stock
    ) {}
}
