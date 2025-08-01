<?php

namespace App\Domain\DTO;

class GruposDTO
{   
    /**
     * @param partnumberGruposDTO[]|null
     */
    public function __construct(

        public ?string $id_grupo = null,
        public ?string $descripcion_grupo,
        public ?array $partnumberGruposDTO = null
    ) {}
}
