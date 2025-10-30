<?php

namespace App\Infrastructure\Repository;

use App\Application\Interface\Repository\IStockRepository;
use App\Domain\Model\Stock;
use PDO;

class StockRepository implements IStockRepository
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function onGet__By_Id_PartNumber_Id_Almacen($id_partnumber, $id_almacen): array
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_stock WHERE id_partnumber_stock = ? AND id_almacen_stock = ?");
        $stmt->execute([
            $id_partnumber,
            $id_almacen
        ]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([Stock::class, 'fromArray'], $rows);
    }

    public function onGet_by_Id_grupo($idGrupo): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_stock WHERE id_grupo_stock = :id_grupo");
        $stmt->bindParam(':id_grupo', $idGrupo);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) {
            return null;
        }

        $stocks = [];
        foreach ($rows as $row) {
            $stocks[] = Stock::fromArray($row);
        }

        return $stocks;
    }

    public function onGet_by_partNumber_localizacion($id_partnumber_stock, $id_localizacion_stock, $id_almacen_stock): ?array
    {
        $query = "SELECT * 
              FROM inventario_hwi_stock 
              WHERE id_partnumber_stock = :id_partnumber_stock 
                AND id_localizacion_stock = :id_localizacion_stock
                AND id_almacen_stock = :id_almacen_stock";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_partnumber_stock', $id_partnumber_stock);
        $stmt->bindParam(':id_localizacion_stock', $id_localizacion_stock);
        $stmt->bindParam(':id_almacen_stock', $id_almacen_stock);

        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) {
            return null;
        }

        $stocks = [];
        foreach ($rows as $row) {
            $stocks[] = Stock::fromArray($row);
        }

        return $stocks;
    }

    public function onGet__By_Id_Grupo_Id_Conteo($id_grupo, $id_conteo): ?array
    {
        $query = "SELECT * 
              FROM inventario_hwi_stock 
              WHERE id_grupo_stock = :id_grupo_stock 
                AND id_conteo_stock = :id_conteo_stock";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_grupo_stock', $id_grupo);
        $stmt->bindParam(':id_conteo_stock', $id_conteo);

        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) {
            return null;
        }

        $stocks = [];
        foreach ($rows as $row) {
            $stocks[] = Stock::fromArray($row);
        }

        return $stocks;
    }

    public function delete($id): int
    {
        $stmt = $this->db->prepare("DELETE FROM inventario_hwi_stock WHERE id_grupo_stock  = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function deleteByPartNumberAndLocation(int $id_partNumber, int $id_localizacion, string $id_almacen_stock): int
    {
        $stmt = $this->db->prepare("DELETE FROM inventario_hwi_stock WHERE id_partnumber_stock = :id_partNumber AND id_localizacion_stock = :id_localizacion AND id_almacen_stock = :id_almacen_stock");
        $stmt->bindParam(':id_partNumber', $id_partNumber, PDO::PARAM_INT);
        $stmt->bindParam(':id_localizacion', $id_localizacion, PDO::PARAM_INT);
        $stmt->bindParam(':id_almacen_stock', $id_almacen_stock, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function save(Stock $stock): bool
    {
        $data = $stock->toArray();
        $columnas = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO inventario_hwi_stock ($columnas) VALUES ($placeholders)";
        $stmt = $this->db->prepare($query);
        foreach ($data as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }
        return $stmt->execute();
    }
}
