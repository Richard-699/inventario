<?php

namespace App\Application\Interface\Service;

use App\Domain\DTO\LocalizacionesDTO;

interface ILocalizacionesService {
    public function onGetLocalizaciones(): array;
}

?>