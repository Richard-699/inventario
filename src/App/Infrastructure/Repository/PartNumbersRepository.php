<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\PartNumbers;
use App\Application\Interface\Repository\IPartNumbersRepository;
use PDO;

class PartNumbersRepository implements IPartNumbersRepository
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function onGet(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_partnumbers");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([PartNumbers::class, 'fromArray'], $rows);
    }
}
