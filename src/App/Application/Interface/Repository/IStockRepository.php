<?php

namespace App\Application\Interface\Repository;

interface IStockRepository {
    public function onGet__By_Id_PartNumber_Id_Almacen($id_partnumber, $id_almacen): array;
}

?>