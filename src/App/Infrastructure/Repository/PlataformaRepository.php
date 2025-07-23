<?php

namespace App\Infrastructure\Repository;

use App\Application\Interface\Repository\IPlataformaRepository;
use App\Domain\Model\Plataforma;
use PDO;

class PlataformaRepository implements IPlataformaRepository
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function onGet(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_plataforma");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([Plataforma::class, 'fromArray'], $rows);
    }
}
