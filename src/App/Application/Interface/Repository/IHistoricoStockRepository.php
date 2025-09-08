<?php

namespace App\Application\Interface\Repository;
use App\Domain\Model\HistoricoStock;

interface IHistoricoStockRepository {
    public function save(HistoricoStock $HistoricoStock): bool;
}

?>