<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\PermisosAdministradores;
use App\Application\Interface\Repository\IPermisosAdministradoresRepository;
use App\Infrastructure\Database\Connection;
use PDO;

class PermisosAdministradoresRepository implements IPermisosAdministradoresRepository{
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function onGet_By__Id_Administrador(string $id_administrador): ?array {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_permisos_administradores WHERE id_administrador_permisos = ?");
        $stmt->execute([$id_administrador]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) {
            return null;
        }

        return array_map([PermisosAdministradores::class, 'fromArray'], $rows);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM inventario_hwi_permisos_administradores WHERE id_administrador_permisos = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function save(PermisosAdministradores $permisosAdministradores): bool
    {
        $data = $permisosAdministradores->toArray();
        $columnas = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO inventario_hwi_permisos_administradores ($columnas) VALUES ($placeholders)";
        $stmt = $this->db->prepare($query);
        foreach ($data as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }
        return $stmt->execute();
    }
}

?>