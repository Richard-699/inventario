<?php

namespace App\Domain\Model;

class HistoricoMB52
{
    public function __construct(
        public ?int $id_historico_mb52,
        public ?string $id_informacion_sap_mb52_historico_mb52,
        public ?string $fecha_historico_mb52,
        public ?string $cantidad_historico_mb52,
        public ?string $fechaRegistro_historico_mb52,
        public ?int $id_part_number_historico_mb52,
        public ?string $id_almacen_historico_mb52,
        public ?string $id_grupo_historico_mb52
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id_historico_mb52'] ?? null,
            $data['id_informacion_sap_mb52_historico_mb52'] ?? null,
            $data['fecha_historico_mb52'] ?? null,
            $data['cantidad_historico_mb52'] ?? null,
            $data['fechaRegistro_historico_mb52'] ?? null,
            $data['id_part_number_historico_mb52'] ?? null,
            $data['id_almacen_historico_mb52'] ?? null,
            $data['id_grupo_historico_mb52'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id_historico_mb52' => $this->id_historico_mb52,
            'id_informacion_sap_mb52_historico_mb52' => $this->id_informacion_sap_mb52_historico_mb52,
            'fecha_historico_mb52' => $this->fecha_historico_mb52,
            'cantidad_historico_mb52' => $this->cantidad_historico_mb52,
            'fechaRegistro_historico_mb52' => $this->fechaRegistro_historico_mb52,
            'id_part_number_historico_mb52' => $this->id_part_number_historico_mb52,
            'id_almacen_historico_mb52' => $this->id_almacen_historico_mb52,
            'id_grupo_historico_mb52' => $this->id_grupo_historico_mb52
        ];
    }
}
