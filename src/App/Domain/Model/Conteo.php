<?php

namespace App\Domain\Model;

class Conteo
{
    public function __construct(
        public ?int $id_conteo,
        public ?string $id_grupo_conteo,
        public ?string $id_encargado_conteo,
        public ?string $fecha_hora_inicio_conteo,
        public ?string $fecha_hora_final_conteo,
        public ?string $observaciones_conteo,
        public ?string $estado_conteo,
        public ?string $observacion_final_conteo,
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            $data['id_conteo'] ?? null,
            $data['id_grupo_conteo'] ?? null,
            $data['id_encargado_conteo'] ?? null,
            $data['fecha_hora_inicio_conteo'] ?? null,
            $data['fecha_hora_final_conteo'] ?? null,
            $data['observaciones_conteo'] ?? null,
            $data['estado_conteo'] ?? null,
            $data['observacion_final_conteo'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id_conteo' => $this->id_conteo,
            'id_grupo_conteo' => $this->id_grupo_conteo,
            'id_encargado_conteo' => $this->id_encargado_conteo,
            'fecha_hora_inicio_conteo' => $this->fecha_hora_inicio_conteo,
            'fecha_hora_final_conteo' => $this->fecha_hora_final_conteo,
            'observaciones_conteo' => $this->observaciones_conteo,
            'estado_conteo' => $this->estado_conteo,
            'observacion_final_conteo' => $this->observacion_final_conteo
        ];
    }
}
