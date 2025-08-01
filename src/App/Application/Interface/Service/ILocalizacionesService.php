<?php

namespace App\Application\Interface\Service;

use App\Domain\DTO\LocalizacionesDTO;

interface ILocalizacionesService {
    public function onGetLocalizaciones(): array;
    public function onGetLocalizacion_By__Id($id): LocalizacionesDTO;
    public function onGetTipoLocalizaciones(): array;
    public function onGetTipoAlmacenamiento(): array;
    public function deleteLocalizacion($id): bool;
    public function saveLocalizacion(LocalizacionesDTO $localizacionesDTO): bool;
    public function updateLocalizacion(LocalizacionesDTO $localizacionesDTO): bool;
    public function onGetAlmacenesLocalizaciones(): array;
}

?>