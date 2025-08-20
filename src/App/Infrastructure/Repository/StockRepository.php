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
}
