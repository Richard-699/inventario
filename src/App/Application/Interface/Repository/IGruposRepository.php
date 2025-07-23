<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\Grupos;

interface IGruposRepository {
    public function onGet(): array;
}

?>