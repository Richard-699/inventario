<?php

namespace App\Domain\DTO;

class EstadosDTO
{   
    public function __construct(
        public ?int $id_estado = null,
        public ?string $tipo_estado = null
    ) {}
}
