<?php

namespace App\Domain\Model;

class Informacion_sap_mb52 {
    public function __construct(
        public ?string $id_informacion_sap_mb52 ,
        public ?string $fecha_registro_informacion_sap_mb52,
        public ?int $id_part_number_informacion_sap_mb52 ,
        public ?int $cantidad_informacion_sap_mb52,
        public ?string $id_almacen_informacion_sap_mb52,
        public ?string $id_grupo_informacion_sap_mb52 ,
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            $data['id_informacion_sap_mb52'] ?? null,
            $data['fecha_registro_informacion_sap_mb52'] ?? null,
            $data['id_part_number_informacion_sap_mb52'] ?? null,
            $data['cantidad_informacion_sap_mb52'] ?? null,
            $data['id_almacen_informacion_sap_mb52'] ?? null,
            $data['id_grupo_informacion_sap_mb52'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id_informacion_sap_mb52' => $this->id_informacion_sap_mb52,
            'fecha_registro_informacion_sap_mb52' => $this->fecha_registro_informacion_sap_mb52,
            'id_part_number_informacion_sap_mb52' => $this->id_part_number_informacion_sap_mb52,
            'cantidad_informacion_sap_mb52' => $this->cantidad_informacion_sap_mb52,
            'id_almacen_informacion_sap_mb52' => $this->id_almacen_informacion_sap_mb52,
            'id_grupo_informacion_sap_mb52' => $this->id_grupo_informacion_sap_mb52
        ];
    }
}

?>