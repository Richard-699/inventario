<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\Grupos;

interface IGruposRepository {
    public function onGet(): array;
    public function save(Grupos $grupos): bool;
    public function delete($id): bool;
}

?>