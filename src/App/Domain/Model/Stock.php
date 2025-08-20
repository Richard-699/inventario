<?php

namespace App\Domain\Model;

class Stock {
    public function __construct(
        public ?int $id_stock ,
        public ?int $id_partnumber_stock ,
        public ?string $id_almacen_stock ,
        public ?int $id_localizacion_stock ,
        public ?float $cantidad_stock,
        public ?int $presenta_novedad_stock,
        public ?float $diferencia_stock,
        public ?string $id_informacion_sap_mb52_stock 
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            $data['id_stock'] ?? null,
            $data['id_partnumber_stock'] ?? null,
            $data['id_almacen_stock'] ?? null,
            $data['id_localizacion_stock'] ?? null,
            $data['cantidad_stock'] ?? null,
            $data['presenta_novedad_stock'] ?? null,
            $data['diferencia_stock'] ?? null,
            $data['id_informacion_sap_mb52_stock'] ?? null
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
            'presenta_novedad_stock' => $this->presenta_novedad_stock,
            'diferencia_stock' => $this->diferencia_stock,
            'id_informacion_sap_mb52_stock' => $this->id_informacion_sap_mb52_stock
        ];
    }
}

?>