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

    public function update_By__id_grupo($id): bool
    {
        $stmt = $this->db->prepare("UPDATE inventario_hwi_partnumbers SET id_grupo_partnumber = NULL WHERE id_grupo_partnumber = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}