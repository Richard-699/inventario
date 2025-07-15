<?php

namespace App\Application\Interface\Repository;

use App\Domain\DTO\AdministradoresDTO;
use App\Domain\Model\Administradores;

interface IAdministradoresRepository {
    public function onGet_By__Email(string $correo_hwi_administrador): ?Administradores;
    public function save(Administradores $administradores): bool;
    public function update_Password(Administradores $administradores): bool;
}

?>