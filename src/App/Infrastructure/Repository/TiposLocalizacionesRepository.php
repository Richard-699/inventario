<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\TipoLocalizaciones;
use App\Application\Interface\Repository\ITipoLocalizacionesRepository;
use PDO;

class TipoLocalizacionesRepository implements ITipoLocalizacionesRepository
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function onGet(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_tipo_localizaciones");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([TipoLocalizaciones::class, 'fromArray'], $rows);
    }

/*     public function save(Almacenes $almacenes): bool
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
    } */

/*     public function delete($id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM inventario_hwi_almacenes WHERE id_almacen = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    } */
}
