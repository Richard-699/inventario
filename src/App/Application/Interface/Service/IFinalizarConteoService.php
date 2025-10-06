<?php

namespace App\Application\Interface\Service;

use App\Domain\DTO\CronogramaDTO;

interface IFinalizarConteoService {
    public function finalizarConteo(array $form): void;
}
?>