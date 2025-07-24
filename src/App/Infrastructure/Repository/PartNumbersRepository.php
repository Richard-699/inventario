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

    public function onGet_By__Id($id): ?PartNumbers {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_partnumbers WHERE id_partnumber = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }
        return PartNumbers::fromArray($row);
    }

    public function onGet_By__Codigo($codigo): ?PartNumbers {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_partnumbers WHERE partnumber = ?");
        $stmt->execute([$codigo]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }
        return PartNumbers::fromArray($row);
    }

    public function save(PartNumbers $partnumbers): bool
    {
        $data = $partnumbers->toArray();
        $columnas = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO inventario_hwi_partnumbers ($columnas) VALUES ($placeholders)";
        $stmt = $this->db->prepare($query);
        foreach ($data as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }
        return $stmt->execute();
    }

    public function update(PartNumbers $partnumbers): bool
    {
        $data = $partnumbers->toArray();
        $id = $data['id_partnumber'];
        $set = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($data)));

        $query = "UPDATE inventario_hwi_partnumbers SET $set WHERE id_partnumber = :id_partnumber";
        
        $stmt = $this->db->prepare($query);
            foreach ($data as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }

        $stmt->bindValue(':id_partnumber', $id, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function delete($id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM inventario_hwi_partnumbers WHERE id_partnumber = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}

    public function update_By__id_grupo($id): bool
    {
        $stmt = $this->db->prepare("UPDATE inventario_hwi_partnumbers SET id_grupo_partnumber = NULL WHERE id_grupo_partnumber = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

