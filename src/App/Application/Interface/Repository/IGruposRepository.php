<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\Grupos;

interface IGruposRepository {
    public function onGet(): array;
    public function onGet_By__Id($id): ?Grupos;
    public function save(Grupos $grupos): bool;
    public function delete($id): int;
}

?>