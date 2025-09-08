<?php

namespace App\Infrastructure\Repository;

use App\Application\Interface\Repository\IHistoricoStockRepository;
use App\Domain\Model\HistoricoStock;
use PDO;

class HistoricoStockRepository implements IHistoricoStockRepository
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(HistoricoStock $informacion): bool
    {
        $data = $informacion->toArray();

        $columnas = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO inventario_hwi_historico_stock ($columnas) VALUES ($placeholders)";
        $stmt = $this->db->prepare($query);

        foreach ($data as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }

        return $stmt->execute();
    }


}
