<?php

namespace App\Domain\Model;

class Stock
{
    public function __construct(
        public ?int $id_stock,
        public ?int $id_partnumber_stock,
        public ?string $id_almacen_stock,
        public ?int $id_localizacion_stock,
        public ?string $cantidad_stock,
        public ?string $id_informacion_sap_mb52_stock,
        public ?int $id_novedad_stock,
        public ?string $observaciones_novedad_stock,
        public ?string $id_grupo_stock,
        public ?int $id_conteo_stock,
        public ?string $fecha_hora_stock,
        public ?string $id_administrador_stock
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id_stock'] ?? null,
            $data['id_partnumber_stock'] ?? null,
            $data['id_almacen_stock'] ?? null,
            $data['id_localizacion_stock'] ?? null,
            $data['cantidad_stock'] ?? null,
            $data['id_informacion_sap_mb52_stock'] ?? null,
            $data['id_novedad_stock'] ?? null,
            $data['observaciones_novedad_stock'] ?? null,
            $data['id_grupo_stock'] ?? null,
            $data['id_conteo_stock'] ?? null,
            $data['fecha_hora_stock'] ?? null,
            $data['id_administrador_stock'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id_stock' => $this->id_stock,
            'id_partnumber_stock' => $this->id_partnumber_stock,
            'id_almacen_stock' => $this->id_almacen_stock,
            'id_localizacion_stock' => $this->id_localizacion_stock,
            'cantidad_stock' => $this->cantidad_stock,
            'id_informacion_sap_mb52_stock' => $this->id_informacion_sap_mb52_stock,
            'id_novedad_stock' => $this->id_novedad_stock,
            'observaciones_novedad_stock' => $this->observaciones_novedad_stock,
            'id_grupo_stock' => $this->id_grupo_stock,
            'id_conteo_stock' => $this->id_conteo_stock,
            'fecha_hora_stock' => $this->fecha_hora_stock,
            'id_administrador_stock' => $this->id_administrador_stock
        ];
    }
}
