<?php

namespace App\Application\Interface\Service;

interface IStockService {
    public function onGetStock_By__Id_PartNumber_By_Id_Almacen($id_partnumber, $id_almacen): array;
}
?>