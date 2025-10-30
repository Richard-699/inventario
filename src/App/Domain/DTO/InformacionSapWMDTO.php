<?php

namespace App\Domain\DTO;

class InformacionSapWMDTO
{   
    public function __construct(
        public ?int $id_informacion_sap_wm  = null,
        public ?int $id_part_number_informacion_sap_wm,
        public ?int $id_localizacion_informacion_sap_wm = null,
        public ?string $id_grupo_informacion_sap_wm  = null,
        public ?string $id_informacion_sap_mb52_informacion_sap_wm  = null,
        public ?string $stock_disponible_sap_informacion_sap_wm = null,
        public ?string $stock_entrada_sap_informacion_sap_wm = null,
        public ?string $stock_salida_sap_informacion_sap_wm = null
    ) {}
}
