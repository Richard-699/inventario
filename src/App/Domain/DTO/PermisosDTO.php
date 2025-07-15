<?php

namespace App\Domain\DTO;

class PermisosDTO {
    public function __construct(
        public ?int $id_permiso = null,
        public ?string $tipo_permiso = null
    ) {}
}
