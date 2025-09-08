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

    public function onGet_by_Id_grupo($idGrupo): ?Cronograma
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_cronograma WHERE id_grupo_cronograma = :id_grupo LIMIT 1");
        $stmt->bindParam(':id_grupo', $idGrupo);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? Cronograma::fromArray($row) : null;
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

    public function update(Cronograma $cronograma): bool
    {
        $dataToUpdate = $cronograma->toArray();
        $id_cronograma = $dataToUpdate['id_cronograma'] ?? null;

        $setClauses = [];
        foreach ($dataToUpdate as $column => $value) {
            $setClauses[] = "$column = :$column";
        }
        $setSql = implode(', ', $setClauses);
        $query = "UPDATE inventario_hwi_cronograma
                  SET " . $setSql . "
                  WHERE id_cronograma = :id_cronograma";

        // 4. Preparar la sentencia
        $stmt = $this->db->prepare($query);

        // 5. Vincular los parámetros usando foreach y bindValue
        foreach ($dataToUpdate as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }
        // Vincular el parámetro para la cláusula WHERE
        $stmt->bindValue(':id_cronograma', $id_cronograma);

        // 6. Ejecutar la sentencia
        return $stmt->execute();
    }

    public function UpdateEstado_Asignado_By_IdGrupo(string $idGrupo, int $id_estado_cronograma,string $id_administrador): void
    {
        $query = "UPDATE inventario_hwi_cronograma SET id_estado_cronograma = :estado, id_administrador_cronograma = :asignado_a WHERE id_grupo_cronograma = :id_grupo_cronograma";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':estado', $id_estado_cronograma, PDO::PARAM_INT);
        $statement->bindValue(':asignado_a', $id_administrador, PDO::PARAM_STR);
        $statement->bindValue(':id_grupo_cronograma', $idGrupo, PDO::PARAM_STR);
        $statement->execute();
    }
}
