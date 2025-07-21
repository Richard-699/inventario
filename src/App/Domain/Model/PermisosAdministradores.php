<?php

namespace App\Domain\Model;

class PermisosAdministradores {
    public function __construct(
        public ?int $id_permisos_administradores,
        public ?int $id_permiso_permisos,
        public ?string $id_administrador_permisos
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            $data['id_permisos_administradores'] ?? null,
            $data['id_permiso_permisos'] ?? null,
            $data['id_administrador_permisos'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id_permisos_administradores' => $this->id_permisos_administradores,
            'id_permiso_permisos' => $this->id_permiso_permisos,
            'id_administrador_permisos' => $this->id_administrador_permisos
        ];
    }
}
