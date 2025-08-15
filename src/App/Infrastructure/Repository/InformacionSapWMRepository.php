<?php

namespace App\Infrastructure\Repository;

<<<<<<<< HEAD:src/App/Infrastructure/Repository/InformacionSapWMRepository.php
use App\Domain\Model\InformacionSapWM;
use App\Application\Interface\Repository\IInformacionSapWMRepository;
use PDO;

class InformacionSapWMRepository implements IInformacionSapWMRepository
========
use App\Domain\Model\InformacionSapMB52;
use App\Application\Interface\Repository\IInformacionSapMB52Repository;
use PDO;

class InformacionSapMB52Repository implements IInformacionSapMB52Repository
>>>>>>>> 2aca43f478e5d4cf153b4ae063fd9ae609c59f04:src/App/Infrastructure/Repository/InformacionSapMb52Repository.php
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

<<<<<<<< HEAD:src/App/Infrastructure/Repository/InformacionSapWMRepository.php
    public function save(InformacionSapWM $informacion): bool
========

    public function save(InformacionSapMB52 $informacion): bool
>>>>>>>> 2aca43f478e5d4cf153b4ae063fd9ae609c59f04:src/App/Infrastructure/Repository/InformacionSapMb52Repository.php
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

<<<<<<<< HEAD:src/App/Infrastructure/Repository/InformacionSapWMRepository.php
    
========
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
>>>>>>>> 2aca43f478e5d4cf153b4ae063fd9ae609c59f04:src/App/Infrastructure/Repository/InformacionSapMb52Repository.php
}
