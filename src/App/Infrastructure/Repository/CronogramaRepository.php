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

        // Buscamos el id de grupo que usaremos para el WHERE
        $id_grupo = $dataToUpdate['id_grupo_cronograma'] ?? null;
        if ($id_grupo === null) {
            // No tenemos id de grupo -> no podemos saber qué fila actualizar
            return false;
        }

        // Excluir claves que no queremos actualizar
        $exclude = ['id_cronograma', 'id_grupo_cronograma'];

        // Construir solo los campos que el DTO incluyó (aunque su valor sea null)
        $fieldsToSet = [];
        foreach ($dataToUpdate as $column => $value) {
            if (in_array($column, $exclude, true)) {
                continue;
            }
            
            // actualizar explícitamente los nulls que aparezcan.
            if (array_key_exists($column, $dataToUpdate)) {
                $fieldsToSet[$column] = $value;
            }
        }

        if (empty($fieldsToSet)) {
            // Nada que actualizar
            return false;
        }

        $setClauses = [];
        foreach (array_keys($fieldsToSet) as $column) {
            $setClauses[] = "`$column` = :$column";
        }
        $setSql = implode(', ', $setClauses);

        $query = "UPDATE inventario_hwi_cronograma
              SET {$setSql}
              WHERE id_grupo_cronograma = :id_grupo_cronograma";

        $stmt = $this->db->prepare($query);

        // Vincular parámetros a actualizar (respetando NULL explícitos)
        foreach ($fieldsToSet as $campo => $valor) {
            if ($valor === null) {
                $stmt->bindValue(":$campo", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":$campo", $valor);
            }
        }

        // Vincular id_grupo para el WHERE (ajusta el tipo si es INT)
        $stmt->bindValue(':id_grupo_cronograma', $id_grupo);

        return $stmt->execute();
    }

    public function UpdateEstado_Asignado_By_IdGrupo(string $idGrupo, int $id_estado_cronograma, string $id_administrador): void
    {
        $query = "UPDATE inventario_hwi_cronograma SET id_estado_cronograma = :estado, id_administrador_cronograma = :asignado_a WHERE id_grupo_cronograma = :id_grupo_cronograma";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':estado', $id_estado_cronograma, PDO::PARAM_INT);
        $statement->bindValue(':asignado_a', $id_administrador, PDO::PARAM_STR);
        $statement->bindValue(':id_grupo_cronograma', $idGrupo, PDO::PARAM_STR);
        $statement->execute();
    }
}
