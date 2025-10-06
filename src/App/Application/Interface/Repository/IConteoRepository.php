<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\Conteo;

interface IConteoRepository {
   public function save(Conteo $conteo): bool;
}

?>