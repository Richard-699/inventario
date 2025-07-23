<?php

namespace App\Domain\DTO;

class PlataformaDTO
{
    public function __construct(
        public ?int $id_plataforma = null,
        public ?string $descripcion_plataforma
    ) {}
}
