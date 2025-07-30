<?php

namespace App\Domain\Model;

class Cronograma
{
    public function __construct(
        public ?int $id_cronograma,
        public ?string $fecha_cronograma,
        public ?int $id_grupo_cronograma,
        public ?int $id_estado_cronograma,
        public ?string $id_administrador_cronograma
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            $data['id_cronograma'] ?? null,
            $data['fecha_cronograma'] ?? null,
            $data['id_grupo_cronograma'] ?? null,
            $data['id_estado_cronograma'] ?? null,
            $data['id_administrador_cronograma'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id_cronograma' => $this->id_cronograma,
            'fecha_cronograma' => $this->fecha_cronograma,
            'id_grupo_cronograma' => $this->id_grupo_cronograma,
            'id_estado_cronograma' => $this->id_estado_cronograma,
            'id_administrador_cronograma' => $this->id_administrador_cronograma,
        ];
    }
}
