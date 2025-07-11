<?php

namespace App\Domain\Model;

class Administradores {
    public function __construct(
        public ?string $id_administrador,
        public ?int $cedula_administrador,
        public ?string $nombre_administrador,
        public ?string $apellidos_administrador,
        public ?string $correo_hwi_administrador,
        public ?string $password_administrador,
        public ?int $password_is_temporal,
        public ?string $estado_administrador
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            $data['id_administrador'] ?? null,
            $data['cedula_administrador'] ?? null,
            $data['nombre_administrador'] ?? null,
            $data['apellidos_administrador'] ?? null,
            $data['correo_hwi_administrador'] ?? null,
            $data['password_administrador'] ?? null,
            $data['password_is_temporal'] ?? null,
            $data['estado_administrador'] ?? null
        );
    }

}

?>