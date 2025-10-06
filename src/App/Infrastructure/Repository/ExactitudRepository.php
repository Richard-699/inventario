<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Exactitud;
use App\Application\Interface\Repository\IExactitudRepository;
use PDO;

class ExactitudRepository implements IExactitudRepository
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }


    public function onGet__Fecha(string $fecha): array
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_exactitud WHERE DATE(fecha_hora_migracion_exactitud) = :fecha");
        $stmt->bindValue(':fecha', $fecha, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([Exactitud::class, 'fromArray'], $rows);
    }

    public function save(Exactitud $exactitud): bool
    {
        $data = $exactitud->toArray();

        $columnas = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO inventario_hwi_exactitud ($columnas) VALUES ($placeholders)";
        $stmt = $this->db->prepare($query);

        foreach ($data as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }

        return $stmt->execute();
    }


    public function onDelete_By__fecha(string $fecha): bool
    {
        // La función DATE() de MySQL extrae solo la parte de la fecha (YYYY-MM-DD) de una columna DATETIME.
        $query = "DELETE FROM inventario_hwi_exactitud WHERE DATE(fecha_hora_migracion_exactitud) = :fecha";
        $statement = $this->db->prepare($query);

        $statement->bindValue(':fecha', $fecha, PDO::PARAM_STR);

        return $statement->execute();
    }
}
