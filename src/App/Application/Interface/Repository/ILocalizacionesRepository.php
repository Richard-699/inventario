<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\Localizaciones;

interface ILocalizacionesRepository {
    public function onGet(): array;
}

?>