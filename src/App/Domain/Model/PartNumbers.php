<?php

namespace App\Domain\Model;

class PartNumbers{
    public function __construct(
        public ?int $id_partnumber = null,
        public ?string $partnumber,
        public ?string $descripcion_breve,
        public ?int $id_umb_partnumber  = null,
        public ?string $nombre_interno,
        public ?string $id_grupo_partnumber,
        public ?int $id_plataforma_partnumber
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            $data['id_partnumber'] ?? null,
            $data['partnumber'] ?? null,
            $data['descripcion_breve'] ?? null,
            $data['id_umb_partnumber'] ?? null,
            $data['nombre_interno'] ?? null,
            $data['id_grupo_partnumber'] ?? null,
            $data['id_plataforma_partnumber'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id_partnumber' => $this->id_partnumber,
            'partnumber' => $this->partnumber,
            'descripcion_breve' => $this->descripcion_breve,
            'id_umb_partnumber' => $this->id_umb_partnumber,
            'nombre_interno' => $this->nombre_interno,
            'id_grupo_partnumber' => $this->id_grupo_partnumber,
            'id_plataforma_partnumber' => $this->id_plataforma_partnumber
        ];
    }
}

?>