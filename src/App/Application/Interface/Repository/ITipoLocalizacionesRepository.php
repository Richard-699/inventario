<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\TipoLocalizaciones;

interface ITipoLocalizacionesRepository {
    public function onGet(): array;
}

?>