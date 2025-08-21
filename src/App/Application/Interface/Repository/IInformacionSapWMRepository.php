<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\InformacionSapWM;

interface IInformacionSapWMRepository
{
    public function save(InformacionSapWM $informacion): bool;
    public function onGet_By__Id_Mb52($id_mb52): ?array;
    public function onDelete_By__IdGrupo(string $idGrupo): void;
}
