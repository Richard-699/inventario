<?php

namespace App\Domain\DTO;

class PermisosAdministradoresDTO {
    public function __construct(
        public ?int $id_permisos_administradores  = null,
        public ?int $id_permiso_permisos  = null,
        public ?string $id_administrador_permisos = null
    ) {}
}
