<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\TipoAlmacenamiento;
use App\Application\Interface\Repository\ITipoAlmacenamientoRepository;
use PDO;

class TipoAlmacenamientoRepository implements ITipoAlmacenamientoRepository
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function onGet(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_tipo_almacenamientos");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([TipoAlmacenamiento::class, 'fromArray'], $rows);
    }
}
