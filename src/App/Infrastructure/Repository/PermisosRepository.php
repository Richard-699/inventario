<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Permisos;
use App\Application\Interface\Repository\IPermisosRepository;
use App\Infrastructure\Database\Connection;
use PDO;

class PermisosRepository implements IPermisosRepository{
    private $db;

    public function __construct() {
        $this->db = (new Connection())->dbInventarioHwi;
    }

    public function onGet(): array {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_permisos");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([Permisos::class, 'fromArray'], $rows);
    }
}

?>