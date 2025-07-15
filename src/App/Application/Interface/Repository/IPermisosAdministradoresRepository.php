<?php

namespace App\Application\Interface\Repository;

use App\Domain\Model\PermisosAdministradores;

interface IPermisosAdministradoresRepository {
    public function onGet_By__Id_Administrador(string $id_administrador): ?PermisosAdministradores;
}

?>