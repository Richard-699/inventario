<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\InformacionSapMB52;

interface IInformacionSapMB52Repository
{
    public function save(InformacionSapMB52 $informacion): bool;
}
