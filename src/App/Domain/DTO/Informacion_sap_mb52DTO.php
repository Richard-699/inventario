<?php

namespace App\Domain\DTO;

class Informacion_sap_mb52DTO
{   
    public function __construct(
        public ?string $id_informacion_sap_mb52  = null,
        public ?string $fecha_registro_informacion_sap_mb52,
        public ?int $id_part_number_informacion_sap_mb52 ,
        public ?int $cantidad_informacion_sap_mb52 = null,
        public ?string $id_almacen_informacion_sap_mb52  = null,
        public ?string $id_grupo_informacion_sap_mb52  = null
    ) {}
}
