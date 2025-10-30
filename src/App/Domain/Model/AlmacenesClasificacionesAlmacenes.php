<?php

namespace App\Domain\Model;

class AlmacenesClasificacionesAlmacenes {
    public function __construct(
        public ?int $id_almacenes_clasificaciones_almacenes,
        public ?string $id_almacen_almacenes_clasificaciones_almacenes,
        public ?int $id_clasificacion_almacenes_almacenes_clasificaciones_almacenes 
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            $data['id_almacenes_clasificaciones_almacenes'] ?? null,
            $data['id_almacen_almacenes_clasificaciones_almacenes'] ?? null,
            $data['id_clasificacion_almacenes_almacenes_clasificaciones_almacenes'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id_almacenes_clasificaciones_almacenes' => $this->id_almacenes_clasificaciones_almacenes,
            'id_almacen_almacenes_clasificaciones_almacenes' => $this->id_almacen_almacenes_clasificaciones_almacenes,
            'id_clasificacion_almacenes_almacenes_clasificaciones_almacenes' => $this->id_clasificacion_almacenes_almacenes_clasificaciones_almacenes
        ];
    }
}

?>