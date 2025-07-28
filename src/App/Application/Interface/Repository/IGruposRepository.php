<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\Grupos;

interface IGruposRepository {
    public function onGet(): array;
    public function onGet_By__Id($id): ?Grupos;
    public function onGet_By__Grupo($grupo): ?Grupos;
    public function save(Grupos $grupos): bool;
    public function delete($id): int;
    public function update(Grupos $grupos): bool;
}

?>