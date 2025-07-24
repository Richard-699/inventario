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

    public function save(Grupos $grupos): bool
    {
        $data = $grupos->toArray();
        $columnas = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO inventario_hwi_grupos ($columnas) VALUES ($placeholders)";
        $stmt = $this->db->prepare($query);
        foreach ($data as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }
        return $stmt->execute();
    }

    public function delete($id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM inventario_hwi_grupos WHERE id_grupo = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
