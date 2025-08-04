<?php

namespace App\Domain\Model;

class AlmacenesLocalizaciones {
    public function __construct(
        public ?int $id_localizaciones_almacenes,
        public ?string $id_almacen ,
        public ?int $id_localizacion_localizaciones 
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            $data['id_localizaciones_almacenes'] ?? null,
            $data['id_almacen'] ?? null,
            $data['id_localizacion_localizaciones'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id_localizaciones_almacenes' => $this->id_localizaciones_almacenes,
            'id_almacen' => $this->id_almacen,
            'id_localizacion_localizaciones' => $this->id_localizacion_localizaciones
        ];
    }
}

?>