<?php

namespace App\Domain\Model;

class Plataforma{
    public function __construct(
        public ?int $id_plataforma = null,
        public ?string $descripcion_plataforma
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            $data['id_plataforma'] ?? null,
            $data['descripcion_plataforma'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id_plataforma' => $this->id_plataforma,
            'descripcion_plataforma' => $this->descripcion_plataforma
        ];
    }
}

?>