<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\InformacionSapMB52;

interface IInformacionSapMB52Repository
{
    public function onGet_By__Id_Partnumber__Id_Almacen($id_partnumber, $id_almacen): ?array;
    public function save(InformacionSapMB52 $informacion): bool;
    public function onGet_By__AlmacenAndPartNumber(string $idAlmacen, string $idPartNumber): ?InformacionSapMB52;
    public function onDelete_By__IdGrupo(string $idGrupo): void;
}
