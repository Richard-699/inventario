<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\Informacion_sap_mb52;

interface IInformacion_sap_mb52Repository
{
    public function save(Informacion_sap_mb52 $informacion): bool;
}
