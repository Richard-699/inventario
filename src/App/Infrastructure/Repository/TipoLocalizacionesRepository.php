<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\TipoLocalizaciones;
use App\Application\Interface\Repository\ITipoLocalizacionesRepository;
use PDO;

class TipoLocalizacionesRepository implements ITipoLocalizacionesRepository
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function onGet(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario_hwi_tipo_localizaciones");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([TipoLocalizaciones::class, 'fromArray'], $rows);
    }
}
