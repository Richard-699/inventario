<?php

namespace App\Application\Interface\Service;

use App\Domain\DTO\AlmacenesDTO;

interface IAlmacenesService {
    public function onGetAlmacenes(): array;
    public function saveAlmacen(AlmacenesDTO $almacenesDTO): bool;
    public function deleteAlmacen($id): bool;
}

?>