<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\AlmacenesLocalizaciones;

interface IAlmacenesLocalizacionesRepository {
    public function onGet(): ?array;
    public function onGetAlmacenesLocalizaciones_By_id_almacen($id): ?array;
    public function delete(int $id);
    public function save(AlmacenesLocalizaciones $almacenLocalizacionModel): bool;
}

?>