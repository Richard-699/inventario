<?php

namespace App\Infrastructure\Repository;

use App\Application\Interface\Repository\IConteoRepository;
use App\Domain\Model\Conteo;
use PDO;

class ConteoRepository implements IConteoRepository
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function onGet(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_conteos");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([Conteo::class, 'fromArray'], $rows);
    }

    public function save(Conteo $conteo): bool
    {
        $data = $conteo->toArray();
        $columnas = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO inventario_hwi_conteos ($columnas) VALUES ($placeholders)";
        $stmt = $this->db->prepare($query);
        foreach ($data as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }
        return $stmt->execute();
    }


    public function onGetConteo_By__Fecha_Reciente_Grupo($idGrupo): ?Conteo
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_conteos WHERE id_grupo_conteo = :id_grupo ORDER BY fecha_hora_inicio_conteo DESC LIMIT 1");
        $stmt->bindParam(':id_grupo', $idGrupo);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? Conteo::fromArray($row) : null;
    }

    public function update(Conteo $conteo): bool
    {
        $dataToUpdate = $conteo->toArray();
        $id_conteo = $dataToUpdate['id_conteo'] ?? null;

        if ($id_conteo === null) {
            // No tenemos id para el WHERE -> no hay update posible
            return false;
        }

        // Filtrar solo los campos que vienen con valor !== null y excluir id_conteo
        $fieldsToSet = [];
        foreach ($dataToUpdate as $column => $value) {
            if ($column === 'id_conteo') {
                continue;
            }
            // Solo considerar los campos que explícitamente NO son null.
            // NOTA: esto permite actualizar valores como 0, '', false.
            if ($value !== null) {
                $fieldsToSet[$column] = $value;
            }
        }

        // Si no hay campos para actualizar, no hacemos nada
        if (empty($fieldsToSet)) {
            return false;
        }

        $setClauses = [];
        foreach (array_keys($fieldsToSet) as $column) {
            $setClauses[] = "`$column` = :$column";
        }
        $setSql = implode(', ', $setClauses);

        $query = "UPDATE inventario_hwi_conteos
              SET {$setSql}
              WHERE id_conteo = :id_conteo";

        $stmt = $this->db->prepare($query);

        // Vincular solo los parámetros que vamos a actualizar
        foreach ($fieldsToSet as $campo => $valor) {
            // Si necesitas forzar tipos específicos, usa el tercer parámetro de bindValue.
            $stmt->bindValue(":$campo", $valor);
        }

        // Vincular id_conteo para el WHERE
        $stmt->bindValue(':id_conteo', $id_conteo);

        return $stmt->execute();
    }
}
