<?php

namespace App\Application\Interface\Repository;
use App\Domain\Model\Plataforma;

interface IPlataformaRepository {
    public function onGet(): array;
}

?>