<?php

namespace App\Application\Interface\Service;

interface ILocalizacionesService {
    public function onGetLocalizaciones(): array;
    public function onGetAlmacenesLocalizaciones(): array;
}

?>