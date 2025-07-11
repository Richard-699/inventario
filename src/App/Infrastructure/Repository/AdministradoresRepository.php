<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Administradores;
use App\Infrastructure\Database\Connection;

class AdministradoresRepository {
    private $db;

    public function __construct() {
        $this->db = (new Connection())->dbInventarioHwi;
    }

    public function onGet_Login(string $correo_hwi_administrador): ?Administradores {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_administradores WHERE correo_hwi_administrador = ?");
        $stmt->execute([$correo_hwi_administrador]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }
        return Administradores::fromArray($row);
    }
}

?>