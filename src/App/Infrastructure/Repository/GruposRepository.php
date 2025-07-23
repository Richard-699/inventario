<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Grupos;
use App\Application\Interface\Repository\IGruposRepository;
use PDO;

class GruposRepository implements IGruposRepository
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function onGet(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_grupos");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([Grupos::class, 'fromArray'], $rows);
    }
}
