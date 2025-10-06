<?php

namespace App\Domain\Model;

class HistoricoStock
{
    public function __construct(
        public ?int $id_historico_stock,
        public ?string $fecha_historico_stock,
        public ?string $cantidad_historico_stock,
        public ?string $id_almacen_historico_stock,
        public ?int $id_localizacion_historico_stock,
        public ?string $id_informacion_sap_mb52_historico_stock,
        public ?int $id_partnumber_historico_stock,
        public ?int $id_novedad_historico_stock,
        public ?string $observaciones_novedad_historico_stock,
        public ?string $id_grupo_historico_stock,
        public ?int $id_conteo_stock,
        public ?string $fecha_hora_stock,
        public ?string $id_administrador_stock
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id_historico_stock'] ?? null,
            $data['fecha_historico_stock'] ?? null,
            $data['cantidad_historico_stock'] ?? null,
            $data['id_almacen_historico_stock'] ?? null,
            $data['id_localizacion_historico_stock'] ?? null,
            $data['id_informacion_sap_mb52_historico_stock'] ?? null,
            $data['id_partnumber_historico_stock'] ?? null,
            $data['id_novedad_historico_stock'] ?? null,
            $data['observaciones_novedad_historico_stock'] ?? null,
            $data['id_grupo_historico_stock'] ?? null,
            $data['id_conteo_stock'] ?? null,
            $data['fecha_hora_stock'] ?? null,
            $data['id_administrador_stock'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id_historico_stock' => $this->id_historico_stock,
            'fecha_historico_stock' => $this->fecha_historico_stock,
            'cantidad_historico_stock' => $this->cantidad_historico_stock,
            'id_almacen_historico_stock' => $this->id_almacen_historico_stock,
            'id_localizacion_historico_stock' => $this->id_localizacion_historico_stock,
            'id_informacion_sap_mb52_historico_stock' => $this->id_informacion_sap_mb52_historico_stock,
            'id_partnumber_historico_stock' => $this->id_partnumber_historico_stock,
            'id_novedad_historico_stock' => $this->id_novedad_historico_stock,
            'observaciones_novedad_historico_stock' => $this->observaciones_novedad_historico_stock,
            'id_grupo_historico_stock' => $this->id_grupo_historico_stock,
            'id_conteo_stock' => $this->id_conteo_stock,
            'fecha_hora_stock' => $this->fecha_hora_stock,
            'id_administrador_stock' => $this->id_administrador_stock
        ];
    }
}
