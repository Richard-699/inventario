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

    public function onGet_By__Id($id): ?Grupos
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_grupos WHERE id_grupo = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) {
            return null;
        }
        return Grupos::fromArray($row);
    }

    public function onGet_By__Grupo($grupo): ?Grupos
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_grupos WHERE descripcion_grupo = ?");
        $stmt->execute([$grupo]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }
        return Grupos::fromArray($row);
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

    public function delete($id): int
    {
        $stmt = $this->db->prepare("DELETE FROM inventario_hwi_grupos WHERE id_grupo = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function update(Grupos $grupos): bool
    {
        $dataToUpdate = $grupos->toArray();
        $id_grupo = $dataToUpdate['id_grupo'] ?? null;

        $setClauses = [];
        foreach ($dataToUpdate as $column => $value) {
            $setClauses[] = "$column = :$column";
        }
        $setSql = implode(', ', $setClauses);
        $query = "UPDATE inventario_hwi_grupos
                  SET " . $setSql . "
                  WHERE id_grupo = :id_grupo";

        // 4. Preparar la sentencia
        $stmt = $this->db->prepare($query);

        // 5. Vincular los parámetros usando foreach y bindValue
        foreach ($dataToUpdate as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }
        // Vincular el parámetro para la cláusula WHERE
        $stmt->bindValue(':id_grupo', $id_grupo);

        // 6. Ejecutar la sentencia
        return $stmt->execute();
    }
}
