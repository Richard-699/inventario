<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\Cronograma;

interface ICronogramaRepository {
    public function onGet(): array;
    public function onGet_By__Fecha($mes_inicial, $mes_final): array;
    public function onGet_by_Id_grupo($idGrupo): ?Cronograma;
    public function save(Cronograma $cronograma): bool;
    public function update(Cronograma $cronograma): bool;
}

?>