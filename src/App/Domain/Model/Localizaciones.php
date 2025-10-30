<?php

namespace App\Domain\Model;

class Localizaciones {
    public function __construct(
        public ?int $id_localizacion,
        public ?string $id_tipo_localizacion_localizaciones,
        public ?string $descripcion_localizacion,
        public ?int $id_tipo_almacenamientos_localizaciones
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            $data['id_localizacion'] ?? null,
            $data['id_tipo_localizacion_localizaciones'] ?? null,
            $data['descripcion_localizacion'] ?? null,
            $data['id_tipo_almacenamientos_localizaciones'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id_localizacion' => $this->id_localizacion,
            'id_tipo_localizacion_localizaciones' => $this->id_tipo_localizacion_localizaciones,
            'descripcion_localizacion' => $this->descripcion_localizacion,
            'id_tipo_almacenamientos_localizaciones' => $this->id_tipo_almacenamientos_localizaciones,
        ];
    }
}

?>