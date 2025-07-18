<?php

namespace App\Application\Interface\Service;

use App\Domain\DTO\AdministradoresDTO;

interface IAdministradoresService {
    public function onGetAdministradores(): array;
    public function deleteAdministrador($id): bool;
    public function onGetPermisos(): array;
}

?>