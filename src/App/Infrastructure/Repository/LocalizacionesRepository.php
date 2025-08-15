<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Localizaciones;
use App\Application\Interface\Repository\ILocalizacionesRepository;
use PDO;

class LocalizacionesRepository implements ILocalizacionesRepository
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function onGet(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_localizaciones");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([Localizaciones::class, 'fromArray'], $rows);
    }

    public function onGet_By__Id($id): ?Localizaciones
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_localizaciones WHERE id_localizacion = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }
        return Localizaciones::fromArray($row);
    }

    public function onGet_By__descripcion($descripcion): ?Localizaciones
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_localizaciones WHERE descripcion_localizacion = ?");
        $stmt->execute([$descripcion]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }
        return Localizaciones::fromArray($row);
    }

    public function save(Localizaciones $localizaciones): bool
    {
        $data = $localizaciones->toArray();
        $columnas = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO inventario_hwi_localizaciones ($columnas) VALUES ($placeholders)";
        $stmt = $this->db->prepare($query);
        foreach ($data as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }
        return $stmt->execute();
    }

    public function update(Localizaciones $localizaciones): bool
    {
        $data = $localizaciones->toArray();
        $id = $data['id_localizacion'];
        $set = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($data)));

        $query = "UPDATE inventario_hwi_localizaciones SET $set WHERE id_localizacion = :id_localizacion";

        $stmt = $this->db->prepare($query);
        foreach ($data as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }

        $stmt->bindValue(':id_localizacion', $id, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function delete($id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM inventario_hwi_localizaciones WHERE id_localizacion = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
