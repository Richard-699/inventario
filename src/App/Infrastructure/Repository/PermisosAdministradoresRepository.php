<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\PermisosAdministradores;
use App\Application\Interface\Repository\IPermisosAdministradoresRepository;
use App\Infrastructure\Database\Connection;

class PermisosAdministradoresRepository implements IPermisosAdministradoresRepository{
    private $db;

    public function __construct() {
        $this->db = (new Connection())->dbInventarioHwi;
    }

    public function onGet_By__Id_Administrador(string $id_administrador): ?PermisosAdministradores {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_permisos_administradores WHERE id_administrador_permisos = ?");
        $stmt->execute([$id_administrador]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }
        return PermisosAdministradores::fromArray($row);
    }
}

?>