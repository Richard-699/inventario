<?php

namespace App\Domain\Model;

class InformacionSapWM {
    public function __construct(
        public ?int $id_informacion_sap_wm,
        public ?int $id_part_number_informacion_sap_wm,
        public ?int $id_localizacion_informacion_sap_wm,
        public ?string $id_grupo_informacion_sap_wm,
        public ?string $id_informacion_sap_mb52_informacion_sap_wm,
        public ?string $stock_disponible_sap_informacion_sap_wm,
        public ?string $stock_entrada_sap_informacion_sap_wm,
        public ?string $stock_salida_sap_informacion_sap_wm
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            $data['id_informacion_sap_wm'] ?? null,
            $data['id_part_number_informacion_sap_wm'] ?? null,
            $data['id_localizacion_informacion_sap_wm'] ?? null,
            $data['id_grupo_informacion_sap_wm'] ?? null,
            $data['id_informacion_sap_mb52_informacion_sap_wm'] ?? null,
            $data['stock_disponible_sap_informacion_sap_wm'] ?? null,
            $data['stock_entrada_sap_informacion_sap_wm'] ?? null,
            $data['stock_salida_sap_informacion_sap_wm'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id_informacion_sap_wm' => $this->id_informacion_sap_wm,
            'id_part_number_informacion_sap_wm' => $this->id_part_number_informacion_sap_wm,
            'id_localizacion_informacion_sap_wm' => $this->id_localizacion_informacion_sap_wm,
            'id_grupo_informacion_sap_wm' => $this->id_grupo_informacion_sap_wm,
            'id_informacion_sap_mb52_informacion_sap_wm' => $this->id_informacion_sap_mb52_informacion_sap_wm,
            'stock_disponible_sap_informacion_sap_wm' => $this->stock_disponible_sap_informacion_sap_wm,
            'stock_entrada_sap_informacion_sap_wm' => $this->stock_entrada_sap_informacion_sap_wm,
            'stock_salida_sap_informacion_sap_wm' => $this->stock_salida_sap_informacion_sap_wm
        ];
    }
}

?>