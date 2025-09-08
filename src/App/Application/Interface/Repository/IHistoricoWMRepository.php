<?php

namespace App\Application\Interface\Repository;
use App\Domain\Model\HistoricoWM;

interface IHistoricoWMRepository {
    public function save(HistoricoWM $HistoricoWM): bool;
}

?>