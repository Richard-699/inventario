<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\AlmacenesClasificacionesAlmacenes;
use App\Application\Interface\Repository\IAlmacenesClasificacionesAlmacenesRepository;
use App\Domain\Model\ClasificacionAlmacenes;
use PDO;

class AlmacenesClasificacionesAlmacenesRepository implements IAlmacenesClasificacionesAlmacenesRepository
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(AlmacenesClasificacionesAlmacenes $AlmacenesClasificacionesAlmacenes): bool
    {
        $data = $AlmacenesClasificacionesAlmacenes->toArray();

        $columnas = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO inventario_hwi_almacenes_clasificaciones_almacenes ($columnas) VALUES ($placeholders)";
        $stmt = $this->db->prepare($query);

        foreach ($data as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }

        return $stmt->execute();
    }

    public function onGet_By__Id($id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_almacenes_clasificaciones_almacenes WHERE id_almacen_almacenes_clasificaciones_almacenes = ?");
        $stmt->execute([$id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$rows) {
            return null;
        }
        return array_map([AlmacenesClasificacionesAlmacenes::class, 'fromArray'], $rows);
    }

    public function delete(string $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM inventario_hwi_almacenes_clasificaciones_almacenes WHERE id_almacen_almacenes_clasificaciones_almacenes = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
