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

    
}
