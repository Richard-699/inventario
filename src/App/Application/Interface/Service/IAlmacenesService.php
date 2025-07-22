<?php

namespace App\Application\Interface\Service;

use App\Domain\DTO\AlmacenesDTO;
use App\Domain\Model\Almacenes;

interface IAlmacenesService {
    public function onGetAlmacenes(): array;
    public function onGetAlmacenes_By__Id($id): ?AlmacenesDTO;
    public function saveAlmacen(AlmacenesDTO $almacenesDTO): bool;
    public function deleteAlmacen($id): bool;
}

?>