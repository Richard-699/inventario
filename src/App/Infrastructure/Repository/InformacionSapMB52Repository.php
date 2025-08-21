<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\InformacionSapMB52;
use App\Application\Interface\Repository\IInformacionSapMB52Repository;
use PDO;

class InformacionSapMB52Repository implements IInformacionSapMB52Repository
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }


    public function save(InformacionSapMB52 $informacion): bool
    {
        $data = $informacion->toArray();

        $columnas = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO inventario_hwi_informacion_sap_mb52 ($columnas) VALUES ($placeholders)";
        $stmt = $this->db->prepare($query);

        foreach ($data as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }

        return $stmt->execute();
    }

    public function onGet_By__Id_Partnumber__Id_Almacen($id_partnumber, $id_almacen): ?array
    {
        if($id_almacen == null){
            $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_informacion_sap_mb52 WHERE id_part_number_informacion_sap_mb52 = ?");
            $stmt->execute([$id_partnumber]);
        }else{
            $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_informacion_sap_mb52 WHERE id_part_number_informacion_sap_mb52 = ? AND id_almacen_informacion_sap_mb52 = ?");
            $stmt->execute([
                $id_partnumber,
                $id_almacen
            ]);
        }
       
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([InformacionSapMB52::class, 'fromArray'], $rows);
    }

    public function onGet_By__AlmacenAndPartNumber(string $idAlmacen, string $idPartNumber): ?InformacionSapMB52
    {
        $sql = "SELECT * FROM inventario_hwi_informacion_sap_mb52 
                    WHERE id_almacen_informacion_sap_mb52 = :id_almacen
                    AND id_part_number_informacion_sap_mb52 = :id_part_number
                    LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_almacen', $idAlmacen);
        $stmt->bindValue(':id_part_number', $idPartNumber);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }
        return InformacionSapMB52::fromArray($row);
    }

    public function onDelete_By__IdGrupo(string $idGrupo): void
    {
        $query = "DELETE FROM inventario_hwi_informacion_sap_mb52 WHERE id_grupo_informacion_sap_mb52 = :id_grupo";
        // En tu caso, la tabla WM sería: "DELETE FROM informacion_sap_wm WHERE id_grupo_informacion_sap_wm = :id_grupo"
        $statement = $this->db->prepare($query);
        $statement->bindValue(':id_grupo', $idGrupo, PDO::PARAM_STR);
        $statement->execute();
    }
}
