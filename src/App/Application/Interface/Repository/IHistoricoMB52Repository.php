<?php

namespace App\Application\Interface\Repository;
use App\Domain\Model\HistoricoMB52;

interface IHistoricoMB52Repository {
    public function save(HistoricoMB52 $HistoricoWM): bool;
}

?>