<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\AlmacenesClasificacionesAlmacenes;

interface IAlmacenesClasificacionesAlmacenesRepository {
    public function save(AlmacenesClasificacionesAlmacenes $AlmacenesClasificacionesAlmacenes): bool;
    public function onGet_By__Id($id): ?array;
    public function delete(string $id): bool;
}

?>