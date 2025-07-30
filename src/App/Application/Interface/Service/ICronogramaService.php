<?php

namespace App\Application\Interface\Service;

use App\Domain\DTO\CronogramaDTO;

interface ICronogramaService {
    public function onGetCronograma($mes_inicial, $mes_final): array;
}
?>