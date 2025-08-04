<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\AlmacenesLocalizaciones;
use App\Application\Interface\Repository\IAlmacenesLocalizacionesRepository;
use PDO;

class AlmacenesLocalizacionesRepository implements IAlmacenesLocalizacionesRepository
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function onGet(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_almacenes_localizaciones");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([AlmacenesLocalizaciones::class, 'fromArray'], $rows);
    }

    public function onGetAlmacenesLocalizaciones_By_id_almacen($id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_almacenes_localizaciones WHERE id_almacen = ?");
        $stmt->execute([$id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([AlmacenesLocalizaciones::class, 'fromArray'], $rows);
    }

    public function delete(string $id)
    {
        $stmt = $this->db->prepare("DELETE FROM inventario_hwi_almacenes_localizaciones WHERE id_almacen = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function save(AlmacenesLocalizaciones $almacenLocalizacionModel): bool
    {
        $data = $almacenLocalizacionModel->toArray();
        $columnas = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $query = "INSERT INTO inventario_hwi_almacenes_localizaciones ($columnas) VALUES ($placeholders)";
        $stmt = $this->db->prepare($query);
        foreach ($data as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }

        return $stmt->execute();
    }
}
