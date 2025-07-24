<?php

namespace App\Domain\DTO;

class PartNumbersDTO
{
    public function __construct(

        public ?int $id_partnumber = null,
        public ?string $partnumber = null,
        public ?string $descripcion_breve = null,
        public ?int $id_umb_partnumber  = null,
        public ?string $umb = null,
        public ?string $nombre_interno = null,
        public ?int $id_grupo_partnumber = null,
        public ?string $grupo = null,
        public ?int $id_plataforma_partnumber = null,
        public ?string $plataforma = null,
    ) {}
}
