<?php

namespace App\Domain\Model;

class Grupos {
    public function __construct(
        public ?string $id_grupo,
        public ?string $descripcion_grupo,
        public ?string $fecha_programacion_grupo,
        public ?int $informacion_migrada_sap_grupo
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            $data['id_grupo'] ?? null,
            $data['descripcion_grupo'] ?? null,
            $data['fecha_programacion_grupo'] ?? null,
            $data['informacion_migrada_sap_grupo'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id_grupo' => $this->id_grupo,
            'descripcion_grupo' => $this->descripcion_grupo,
            'fecha_programacion_grupo' => $this->fecha_programacion_grupo,
            'informacion_migrada_sap_grupo' => $this->informacion_migrada_sap_grupo
        ];
    }
}

?>