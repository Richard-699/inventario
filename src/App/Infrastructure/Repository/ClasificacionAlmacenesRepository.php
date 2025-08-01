<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\ClasificacionAlmacenes;
use App\Application\Interface\Repository\IClasificacionAlmacenesRepository;
use PDO;

class ClasificacionAlmacenesRepository implements IClasificacionAlmacenesRepository
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function onGet(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_clasificacion_almacenes");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([ClasificacionAlmacenes::class, 'fromArray'], $rows);
    }
}
