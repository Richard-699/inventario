<?php

namespace App\Domain\Model;

class PermisosAdministradores {
    public function __construct(
        public ?int $id_permisos_administradores  = null,
        public ?int $id_permiso_permisos  = null,
        public ?string $id_administrador_permisos   = null
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            $data['id_permisos_administradores'] ?? null,
            $data['id_permiso_permisos'] ?? null,
            $data['id_administrador_permisos'] ?? null
        );
    }
}
