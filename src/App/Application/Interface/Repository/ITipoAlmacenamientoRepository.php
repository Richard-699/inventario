<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\TipoAlmacenamiento;

interface ITipoAlmacenamientoRepository {
    public function onGet(): array;
}

?>