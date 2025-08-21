<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\InformacionSapMB52;

interface IInformacionSapMB52Repository
{
    public function onGet_By__Id_Partnumber($id_partnumber): ?array;
    public function save(InformacionSapMB52 $informacion): bool;
    public function onGet_By__AlmacenAndPartNumber(string $idAlmacen, string $idPartNumber): ?InformacionSapMB52;
    public function onDelete_By__IdGrupo(string $idGrupo): void;
}
