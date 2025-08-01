<?php

namespace App\Domain\Model;

class Grupos {
    public function __construct(
        public ?string $id_grupo,
        public ?string $descripcion_grupo,
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            $data['id_grupo'] ?? null,
            $data['descripcion_grupo'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id_grupo' => $this->id_grupo,
            'descripcion_grupo' => $this->descripcion_grupo
        ];
    }
}

?>