<?php

namespace App\Infrastructure\Repository;

use App\Application\Interface\Repository\IEstadosRepository;
use App\Domain\Model\Estados;
use PDO;

class EstadosRepository implements IEstadosRepository
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function onGet(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_estados");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([Estados::class, 'fromArray'], $rows);
    }
}
