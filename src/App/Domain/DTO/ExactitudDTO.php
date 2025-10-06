<?php

namespace App\Domain\DTO;

class ExactitudDTO

{
    public function __construct(
        public ?int $id_exactitud = null,
        public ?string $partnumber_exactitud = null,
        public ?string $descripcion_partnumber_exactitud = null,
        public ?string $tipo_almacen_exactitud =  null,
        public ?string $area_almacenamiento_exactitud = null,
        public ?string $localizacion_exactitud = null,
        public ?string $coincide_exactitud = null,
        public ?string $novedad_exactitud = null,
        public ?string $descripcion_novedad_exactitud = null,
        public ?string $fecha_hora_migracion_exactitud = null,
        public ?string $id_administrador = null
    ) {}
}
