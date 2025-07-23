<?php

namespace App\Domain\DTO;

class GruposDTO
{
    public function __construct(

        public ?int $id_grupo = null,
        public ?string $descripcion_grupo
    ) {}
}
