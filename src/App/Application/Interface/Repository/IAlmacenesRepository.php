<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\Almacenes;

interface IAlmacenesRepository {
    public function onGet(): array;
    public function onGet_By__Id($id): ?Almacenes;
    public function save(Almacenes $almacenes): bool;
    public function delete($id): bool;
}

?>