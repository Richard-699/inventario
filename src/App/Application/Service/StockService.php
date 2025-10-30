<?php

namespace App\Application\Service;

use App\Application\Interface\Service\IStockService;
use App\Domain\DTO\StockDTO;
use App\Domain\DTO\HistoricoStockDTO;
use Exception;
use App\Shared\Mapper\Mapper;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Repository\StockRepository;
use App\Infrastructure\Repository\HistoricoStockRepository;
class StockService implements IStockService
{

    private $db;
    private $stockRepository;
    private $stockHistoricoRepository;

    public function __construct()
    {
        $this->db = (new Connection())->dbInventarioHwi;
        $this->stockRepository = new StockRepository($this->db);
        $this->stockHistoricoRepository = new HistoricoStockRepository($this->db);
    }

    public function onGetStock_By__Id_PartNumber_By_Id_Almacen($id_partnumber, $id_almacen): array
    {
        $stock = $this->stockRepository->onGet__By_Id_PartNumber_Id_Almacen($id_partnumber, $id_almacen);
        return $stock;
    }

    public function saveStock(StockDTO $stockDTO): bool
    {
        try {
            $this->db->beginTransaction();
    
            $stock = Mapper::StockDTOToModel($stockDTO);

             // 2. onGet de tablas Stock
            $OnGetStock = $this->stockRepository->onGet_by_partNumber_localizacion($stock->id_partnumber_stock, $stock->id_localizacion_stock, $stock->id_almacen_stock);
            // 2.1 Si se encontraron registros en la tabla stock, se guardan en el historico y luego se eliminan.
            if ($OnGetStock) {
                foreach ($OnGetStock as $stockModel) {
                    $HistoricoStockDTO = new HistoricoStockDTO(
                        id_historico_stock: null,
                        fecha_historico_stock: date('Y-m-d H:i:s'),
                        cantidad_historico_stock: $stockModel->cantidad_stock,
                        id_almacen_historico_stock: $stockModel->id_almacen_stock,
                        id_localizacion_historico_stock: $stockModel->id_localizacion_stock,
                        id_informacion_sap_mb52_historico_stock: $stockModel->id_informacion_sap_mb52_stock,
                        id_partnumber_historico_stock: $stockModel->id_partnumber_stock,
                        id_novedad_historico_stock: $stockModel->id_novedad_stock ?? NULL,
                        observaciones_novedad_historico_stock: $stockModel->observaciones_novedad_stock,
                        id_grupo_historico_stock: $stockModel->id_grupo_stock,
                        id_conteo_stock : $stockModel->id_conteo_stock,
                        fecha_hora_stock : $stockModel->fecha_hora_stock,
                        id_administrador_stock : $stockModel->id_administrador_stock
                    );

                    // Guardar DTO en la tabla stock_historico
                    $historicoStockModel = Mapper::HistoricoStockDTOToModel($HistoricoStockDTO);
                    $this->stockHistoricoRepository->save($historicoStockModel);
                }
                // Eliminar los registros de la tabla stock
                /* $this->stockRepository->delete($id_grupo); */
            } 

            // 2. Eliminar registros existentes para el id_partnumber e id_localizacion
            $this->stockRepository->deleteByPartNumberAndLocation(
                $stock->id_partnumber_stock,
                $stock->id_localizacion_stock,
                $stock->id_almacen_stock
            );

            // 3. Guardar la nueva información en la tabla Stock
            $guardarStock = $this->stockRepository->save($stock);
            if (!$guardarStock) {
                throw new Exception("No se pudo guardar la información del Stock");
            }
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Error al registrar la cantidad " . $e->getMessage());
        }
    }
}
