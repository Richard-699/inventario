<?php

namespace App\Domain\Model;

class Estados
{   
    public function __construct(
        public ?int $id_estado = null,
        public ?string $tipo_estado = null
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            $data['id_estado'] ?? null,
            $data['tipo_estado'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id_estado' => $this->id_estado,
            'tipo_estado' => $this->tipo_estado
        ];
    }
}
