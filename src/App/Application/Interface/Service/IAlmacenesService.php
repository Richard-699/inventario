<?php

namespace App\Application\Interface\Service;

use App\Domain\DTO\AlmacenesDTO;

interface IAlmacenesService {
    public function onGetAlmacenes(): array;
    public function onGetAlmacenes_By__Id($id): ?AlmacenesDTO;
    public function onGetAlmacenesLocalizaciones_By_id_almacen($id): ?array;
    public function saveAlmacen(AlmacenesDTO $almacenesDTO): bool;
    public function deleteAlmacen($id): bool;
    public function updateLocalizacionesAlmacen(AlmacenesDTO $almacenesDTO): bool;
}

?>