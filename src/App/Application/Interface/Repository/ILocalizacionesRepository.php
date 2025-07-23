<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\Localizaciones;

interface ILocalizacionesRepository {
    public function onGet(): array;
    public function onGet_By__Id($id): ?Localizaciones;
    public function save(Localizaciones $localizaciones): bool;
    public function update(Localizaciones $localizaciones): bool;
    public function delete($id): bool;
}

?>