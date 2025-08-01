<?php

namespace App\Domain\DTO;

class AlmacenesClasificacionesAlmacenesDTO
{
    public function __construct(

        public ?int $id_almacenes_clasificaciones_almacenes  = null,
        public ?int $id_almacen_almacenes_clasificaciones_almacenes ,
        public ?int $id_clasificacion_almacenes_almacenes_clasificaciones_almacenes,
    ) {}
}
