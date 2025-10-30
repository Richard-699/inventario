<?php

namespace App\Domain\DTO;

class GruposDTO
{   
    /**
     * @param partnumberGruposDTO[]|null
     */
    public function __construct(
        public ?string $id_grupo = null,
        public ?string $descripcion_grupo = null,
        public ?string $fecha_programacion_grupo = null,
        public ?int $informacion_migrada_sap_grupo = null,
        public ?array $partnumberGruposDTO = null
    ) {}
}
