<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\Cronograma;

interface ICronogramaRepository {
    public function onGet(): array;
    public function onGet_By__Fecha($mes_inicial, $mes_final): array;
    public function save(Cronograma $cronograma): bool;
}

?>