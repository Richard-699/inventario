<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Almacenes;
use App\Application\Interface\Repository\IAlmacenesRepository;
use PDO;

class AlmacenesRepository implements IAlmacenesRepository
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function onGet(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_almacenes");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([Almacenes::class, 'fromArray'], $rows);
    }

    public function onGet_By__Id($id): ?Almacenes
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_almacenes WHERE id_almacen = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) {
            return null;
        }
        return Almacenes::fromArray($row);
    }

    public function onGet_By__descripcion($descripcion): ?Almacenes
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_almacenes WHERE descripcion_almacen = ?");
        $stmt->execute([$descripcion]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }
        return Almacenes::fromArray($row);
    }

    public function save(Almacenes $almacenes): bool
    {
        $data = $almacenes->toArray();
        $columnas = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO inventario_hwi_almacenes ($columnas) VALUES ($placeholders)";
        $stmt = $this->db->prepare($query);
        foreach ($data as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }
        return $stmt->execute();
    }

    public function delete($id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM inventario_hwi_almacenes WHERE id_almacen = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function update(Almacenes $almacenModel): bool
    {
        $dataToUpdate = $almacenModel->toArray();
        $idAlmacen = $dataToUpdate['id_almacen'] ?? null;

        $setClauses = [];
        foreach ($dataToUpdate as $column => $value) {
            $setClauses[] = "$column = :$column";
        }
        $setSql = implode(', ', $setClauses);
        $query = "UPDATE inventario_hwi_almacenes
                  SET " . $setSql . "
                  WHERE id_almacen = :id_almacen";

        // 4. Preparar la sentencia
        $stmt = $this->db->prepare($query);

        // 5. Vincular los parámetros usando foreach y bindValue
        foreach ($dataToUpdate as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }
        // Vincular el parámetro para la cláusula WHERE
        $stmt->bindValue(':id_almacen', $idAlmacen);

        // 6. Ejecutar la sentencia
        return $stmt->execute();
    }
}
