<?php

namespace App\Domain\Model;

class Exactitud
{
    public function __construct(
        public ?int $id_exactitud,
        public ?string $partnumber_exactitud,
        public ?string $descripcion_partnumber_exactitud,
        public ?string $tipo_almacen_exactitud,
        public ?string $area_almacenamiento_exactitud,
        public ?string $localizacion_exactitud,
        public ?string $coincide_exactitud,
        public ?string $novedad_exactitud,
        public ?string $descripcion_novedad_exactitud,
        public ?string $fecha_hora_migracion_exactitud,
        public ?string $id_administrador
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id_exactitud'] ?? null,
            $data['partnumber_exactitud'] ?? null,
            $data['descripcion_partnumber_exactitud'] ?? null,
            $data['tipo_almacen_exactitud'] ?? null,
            $data['area_almacenamiento_exactitud'] ?? null,
            $data['localizacion_exactitud'] ?? null,
            $data['coincide_exactitud'] ?? null,
            $data['novedad_exactitud'] ?? null,
            $data['descripcion_novedad_exactitud'] ?? null,
            $data['fecha_hora_migracion_exactitud'] ?? null,
            $data['id_administrador'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id_exactitud' => $this->id_exactitud,
            'partnumber_exactitud' => $this->partnumber_exactitud,
            'descripcion_partnumber_exactitud' => $this->descripcion_partnumber_exactitud,
            'tipo_almacen_exactitud' => $this->tipo_almacen_exactitud,
            'area_almacenamiento_exactitud' => $this->area_almacenamiento_exactitud,
            'localizacion_exactitud' => $this->localizacion_exactitud,
            'coincide_exactitud' => $this->coincide_exactitud,
            'novedad_exactitud' => $this->novedad_exactitud,
            'descripcion_novedad_exactitud' => $this->descripcion_novedad_exactitud,
            'fecha_hora_migracion_exactitud' => $this->fecha_hora_migracion_exactitud,
            'id_administrador' => $this->id_administrador
        ];
    }
}
