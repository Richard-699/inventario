<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\AlmacenesLocalizaciones;

interface IAlmacenesLocalizacionesRepository {
    public function onGet(): ?array;
    public function onGetAlmacenesLocalizaciones_By_Id_Almacen($id): ?array;
    public function delete(string $id);
    public function save(AlmacenesLocalizaciones $almacenLocalizacionModel): bool;
}

?>