<?php

namespace App\Application\Contract\Repository;

use App\Domain\Model\Administradores;

interface IAdministradoresRepository {
    public function onGet_Login(string $correo_hwi_administrador): ?Administradores;
}

?>