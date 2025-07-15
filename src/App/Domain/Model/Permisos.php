<?php

namespace App\Domain\Model;

class Permisos {
    public function __construct(
        public ?int $id_permiso = null,
        public ?string $tipo_permiso = null
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            $data['id_permiso'] ?? null,
            $data['tipo_permiso'] ?? null
        );
    }
}