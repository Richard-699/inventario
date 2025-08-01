<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\ClasificacionAlmacenes;

interface IClasificacionAlmacenesRepository {
    public function onGet(): array;
}

?>