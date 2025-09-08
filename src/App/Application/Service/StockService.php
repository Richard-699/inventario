<?php

namespace App\Application\Service;

use App\Application\Interface\Service\IStockService;
use App\Domain\DTO\StockDTO;
use Exception;
use App\Shared\Mapper\Mapper;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Repository\StockRepository;

class StockService implements IStockService
{

    private $db;
    private $stockRepository;

    public function __construct()
    {
        $this->db = (new Connection())->dbInventarioHwi;
        $this->stockRepository = new StockRepository($this->db);
    }

    public function onGetStock_By__Id_PartNumber_By_Id_Almacen($id_partnumber, $id_almacen): array
    {
        $stock = $this->stockRepository->onGet__By_Id_PartNumber_Id_Almacen($id_partnumber, $id_almacen);
        return $stock;
    }

    public function saveStock(StockDTO $stockDTO): bool
    {
        return true;
    }
}
