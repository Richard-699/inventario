<?php

namespace App\Domain\Model;

class TipoLocalizaciones {
    public function __construct(
        public ?int $id_tipo_localizacion,
        public ?string $descripcion_tipo_localizacion
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            $data['id_tipo_localizacion'] ?? null,
            $data['descripcion_tipo_localizacion'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id_tipo_localizacion' => $this->id_tipo_localizacion,
            'descripcion_tipo_localizacion' => $this->descripcion_tipo_localizacion
        ];
    }
}

?>