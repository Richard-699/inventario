<?php

namespace App\Domain\DTO;

class ConteoDTO
/**
 * @param infoMB52[]|null
 * @param infoWM[]|null
 * @param infoStock[]|null
 * @param infoPartNumbers[]|null
 * @param infoAlmacenes[]|null
 * @param infoLocalizaciones[]|null
 * @param infoInventarioHwiUmb[]|null
 * @param infoLocalizacionesAlmacenes[]|null
 */
{
    public function __construct(
        public ?int $id_conteo = null,
        public ?string $id_grupo_conteo = null,
        public ?string $id_encargado_conteo =  null,
        public ?string $fecha_hora_inicio_conteo = null,
        public ?string $fecha_hora_final_conteo = null,
        public ?string $observaciones_conteo = null,
        public ?int $estado_conteo = null,
        public ?array $infoStock = null,
        public ?array $infoMB52 = null,
        public ?array $infoWM = null,
        public ?array $infoPartNumbers = null,
        public ?array $infoAlmacenes = null,
        public ?array $infoLocalizaciones = null,
        public ?array $infoInventarioHwiUmb = null,
        public ?array $infoLocalizacionesAlmacenes = null
    ) {}
}
