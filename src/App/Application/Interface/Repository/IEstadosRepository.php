<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\Estados;

interface IEstadosRepository {
    public function onGet(): array;
}

?>