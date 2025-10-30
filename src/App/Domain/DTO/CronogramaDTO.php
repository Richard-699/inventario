<?php

namespace App\Domain\DTO;

class CronogramaDTO
{   
    /**
     * @param partnumberGruposDTO[]|null
     */
    public function __construct(

        public ?int $id_cronograma = null,
        public ?string $fecha_cronograma = null,
        public ?string $id_grupo_cronograma = null,
        public ?string $grupo = null,
        public ?int $id_estado_cronograma = null,
        public ?string $estado = null,
        public ?string $id_administrador_cronograma = null,
        public ?string $administrador = null
    ) {}
}
