<?php

namespace App\Application\Interface\Service;

use App\Domain\DTO\GruposDTO;
use App\Domain\Model\Grupos;

interface IGruposService {
    public function onGetGrupos(): array;
}

?>