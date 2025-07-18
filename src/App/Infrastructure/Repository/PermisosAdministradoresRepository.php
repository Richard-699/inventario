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
        // TEMPORAL: forzar datos manuales válidos
        $id_permiso = '1';
        $id_admin = '20bf894a-0497-426c-9166-401210bb39eb';

        $query = "INSERT INTO inventario_hwi_permisos_administradores (id_permiso_permisos, id_administrador_permisos) VALUES (:id_permiso_permisos, :id_administrador_permisos)";
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(":id_permiso_permisos", $id_permiso, PDO::PARAM_STR);
        $stmt->bindValue(":id_administrador_permisos", $id_admin, PDO::PARAM_STR);    

        if (!$stmt->execute()) {
            var_dump($stmt->errorInfo());
            return false;
        }

        return true;
    }

}

?>