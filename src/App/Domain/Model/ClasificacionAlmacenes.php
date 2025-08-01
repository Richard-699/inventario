<?php

namespace App\Domain\Model;

class ClasificacionAlmacenes {
    public function __construct(
        public ?int $id_clasificacion_almacenes,
        public ?string $descripcion_clasificacion_almacenes
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            $data['id_clasificacion_almacenes'] ?? null,
            $data['descripcion_clasificacion_almacenes'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id_clasificacion_almacenes' => $this->id_clasificacion_almacenes,
            'descripcion_clasificacion_almacenes' => $this->descripcion_clasificacion_almacenes
        ];
    }
}

?>