<?php

namespace App\Domain\DTO;

class PartNumbersDTO
{
    /**
     * @param localizacionesAlmacenDTO[]|null
     */
    public function __construct(

        public ?int $id_partnumber = null,
        public ?string $partnumber,
        public ?string $descripcion_breve,
        public ?int $id_umb_partnumber  = null,
        public ?string $umb,
        public ?string $nombre_interno,
        public ?int $id_grupo_partnumber,
        public ?string $grupo,
        public ?int $id_plataforma_partnumber,
        public ?string $plataforma,
    ) {}
}
