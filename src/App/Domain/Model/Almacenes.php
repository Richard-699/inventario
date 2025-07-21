<?php

namespace App\Domain\Model;

class Almacenes {
    public function __construct(
        public ?int $id_almacen,
        public ?string $codigo_sap,
        public ?string $descripcion_almacen
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            $data['id_almacen'] ?? null,
            $data['codigo_sap'] ?? null,
            $data['descripcion_almacen'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id_almacen' => $this->id_almacen,
            'codigo_sap' => $this->codigo_sap,
            'descripcion_almacen' => $this->descripcion_almacen
        ];
    }
}

?>