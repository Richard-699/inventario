<?php

namespace App\Infrastructure\Repository;

use App\Application\Interface\Repository\ICronogramaRepository;
use App\Domain\Model\Cronograma;
use PDO;

class CronogramaRepository implements ICronogramaRepository
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function onGet(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_cronograma");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([Cronograma::class, 'fromArray'], $rows);
    }

    public function onGet_By__Fecha($mes_inicial, $mes_final): array
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_cronograma WHERE fecha_cronograma BETWEEN :mes_inicial AND :mes_final");
        $stmt->bindParam(':mes_inicial', $mes_inicial);
        $stmt->bindParam(':mes_final', $mes_final);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([Cronograma::class, 'fromArray'], $rows);
    }

    public function save(Cronograma $cronograma): bool
    {
        $data = $cronograma->toArray();
        $columnas = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO inventario_hwi_cronograma ($columnas) VALUES ($placeholders)";
        $stmt = $this->db->prepare($query);
        foreach ($data as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }
        return $stmt->execute();
    }
}
