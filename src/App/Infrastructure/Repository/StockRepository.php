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

    
    public function delete($id): int
    {
        $stmt = $this->db->prepare("DELETE FROM inventario_hwi_stock WHERE id_grupo_stock  = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
