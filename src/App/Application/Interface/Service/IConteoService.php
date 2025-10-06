<?php

namespace App\Application\Interface\Service;

use App\Domain\DTO\ConteoDTO;
use App\Domain\Model\Conteo;

interface IConteoService {
    public function onGetConteo_By__Fecha_Reciente_Grupo($id_grupo): ConteoDTO;
}
?>