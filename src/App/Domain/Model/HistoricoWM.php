<?php

namespace App\Domain\Model;

class HistoricoWM
{
    public function __construct(
        public ?int $id_historico_wm,
        public ?string $fecha_historico_wm,
        public ?string $stock_disponible_historico_wm,
        public ?string $stock_entrada_historico_wm,
        public ?string $stock_salida_historico_wm,
        public ?int $id_localizacion_historico_wm,
        public ?int $id_partnumber_historico_wm,
        public ?string $id_grupo_historico_wm,
        public ?string $id_informacion_sap_mb52_historico_wm
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id_historico_wm'] ?? null,
            $data['fecha_historico_wm'] ?? null,
            $data['stock_disponible_historico_wm'] ?? null,
            $data['stock_entrada_historico_wm'] ?? null,
            $data['stock_salida_historico_wm'] ?? null,
            $data['id_localizacion_historico_wm'] ?? null,
            $data['id_partnumber_historico_wm'] ?? null,
            $data['id_grupo_historico_wm'] ?? null,
            $data['id_informacion_sap_mb52_historico_wm'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id_historico_wm' => $this->id_historico_wm,
            'fecha_historico_wm' => $this->fecha_historico_wm,
            'stock_disponible_historico_wm' => $this->stock_disponible_historico_wm,
            'stock_entrada_historico_wm' => $this->stock_entrada_historico_wm,
            'stock_salida_historico_wm' => $this->stock_salida_historico_wm,
            'id_localizacion_historico_wm' => $this->id_localizacion_historico_wm,
            'id_partnumber_historico_wm' => $this->id_partnumber_historico_wm,
            'id_grupo_historico_wm' => $this->id_grupo_historico_wm,
            'id_informacion_sap_mb52_historico_wm' => $this->id_informacion_sap_mb52_historico_wm
        ];
    }
}
