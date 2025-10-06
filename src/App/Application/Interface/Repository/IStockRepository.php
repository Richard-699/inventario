<?php

namespace App\Application\Interface\Repository;
use App\Domain\Model\Stock;
interface IStockRepository
{
    public function onGet__By_Id_PartNumber_Id_Almacen($id_partnumber, $id_almacen): array;
    public function onGet_by_Id_grupo($idGrupo): ?array;
    public function onGet_by_partNumber_localizacion($id_partnumber_stock, $id_localizacion_stock, $id_almacen_stock): ?array;
    public function onGet__By_Id_Grupo_Id_Conteo($id_grupo, $id_conteo): ?array;
    public function delete($id): int;
    public function deleteByPartNumberAndLocation(int $id_partNumber, int $id_localizacion, string $id_almacen_stock): int;
    public function save(Stock $stock): bool;
}
