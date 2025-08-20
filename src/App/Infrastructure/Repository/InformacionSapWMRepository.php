<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\InformacionSapWM;
use App\Application\Interface\Repository\IInformacionSapWMRepository;
use PDO;

class InformacionSapWMRepository implements IInformacionSapWMRepository
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(InformacionSapWM $informacion): bool
    {
        $data = $informacion->toArray();

        $columnas = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO inventario_hwi_informacion_sap_wm ($columnas) VALUES ($placeholders)";
        $stmt = $this->db->prepare($query);

        foreach ($data as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }

        return $stmt->execute();
    }
    
    public function onGet_By__Id_Mb52($id_mb52): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_informacion_sap_wm WHERE id_informacion_sap_mb52_informacion_sap_wm = ?");
        $stmt->execute([$id_mb52]);
       
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([InformacionSapWM::class, 'fromArray'], $rows);
    }
    
}
