<?php

namespace App\Domain\Model;

class TipoAlmacenamiento {
    public function __construct(
        public ?int $id_tipo_almacenamiento,
        public ?string $descripcion_tipo_almacenamiento
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            $data['id_tipo_almacenamiento'] ?? null,
            $data['descripcion_tipo_almacenamiento'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id_tipo_almacenamiento' => $this->id_tipo_almacenamiento,
            'descripcion_tipo_almacenamiento' => $this->descripcion_tipo_almacenamiento
        ];
    }
}

?>