<?php

namespace App\Domain\DTO;

class HistoricoWMDTO
{
    public function __construct(
        public ?int $id_historico_wm,
        public ?string $fecha_historico_wm,
        public ?string $stock_disponible_historico_wm,
        public ?string $stock_entrada_historico_wm,
        public ?string $stock_salida_historico_wm,
        public ?int $id_localizacion_historico_wm,
        public ?int $id_partnumber_historico_wm,
        public ?string $id_grupo_historico_wm,
        public ?string $id_informacion_sap_mb52_historico_wm
    ) {}
}
