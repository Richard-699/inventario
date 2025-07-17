<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\PermisosAdministradores;
use App\Application\Interface\Repository\IPermisosAdministradoresRepository;
use App\Infrastructure\Database\Connection;
use PDO;

class PermisosAdministradoresRepository implements IPermisosAdministradoresRepository{
    private $db;

    public function __construct() {
        $this->db = (new Connection())->dbInventarioHwi;
    }

    public function onGet_By__Id_Administrador(string $id_administrador): ?array {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_permisos_administradores WHERE id_administrador_permisos = ?");
        $stmt->execute([$id_administrador]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) {
            return null;
        }

        return array_map([PermisosAdministradores::class, 'fromArray'], $rows);
    }
}

?>