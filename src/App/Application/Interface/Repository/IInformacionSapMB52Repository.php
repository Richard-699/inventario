<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\InformacionSapMb52;

interface IInformacionSapMb52Repository
{
    public function save(InformacionSapMb52 $informacion): bool;
    
}
