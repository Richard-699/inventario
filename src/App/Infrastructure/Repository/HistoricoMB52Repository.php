<?php

namespace App\Infrastructure\Repository;

use App\Application\Interface\Repository\IHistoricoMB52Repository;
use App\Domain\Model\HistoricoMB52;
use PDO;

class HistoricoMB52Repository implements IHistoricoMB52Repository
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(HistoricoMB52 $informacion): bool
    {
        $data = $informacion->toArray();

        $columnas = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO inventario_hwi_historico_mb52 ($columnas) VALUES ($placeholders)";
        $stmt = $this->db->prepare($query);

        foreach ($data as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }

        return $stmt->execute();
    }


}
