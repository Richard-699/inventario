<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Application\Service\BasesDatosSapService;
use App\Application\Service\LocalizacionesService;
use App\Application\Service\StockService;
use App\Domain\DTO\StockDTO;
use App\Shared\Validation\Validator;

function onGetInfoStock($data)
{
    try {
        $id_almacen = $data['id_almacen'];
        $id_partnumber = $data['id_partnumber'];

        $localizacionesService = new LocalizacionesService();
        $basesDatosSapService = new BasesDatosSapService();
        $stockService = new StockService();

        $informacionSAP = $basesDatosSapService->onGetInformacionSAP($id_partnumber, $id_almacen);

        if($informacionSAP[0]->almacen === "WM01"){
            $localizaciones = $informacionSAP[0]->localizacionesWM;
        }else{
            $localizaciones = $localizacionesService->onGetLocalizaciones_By__Id_Almacen($id_almacen);
        }

        $stock = $stockService->onGetStock_By__Id_PartNumber_By_Id_Almacen($id_partnumber, $id_almacen);

        if ($localizaciones) {
            return [
                'localizaciones' => $localizaciones,
                'informacionSAP' => $informacionSAP,
                'stock' => $stock
            ];
        } else {
            throw new Exception("No se encontraron datos para este almacén.");
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

function onPostSaveStock(array $data){
    try {
        $form = $data['form'] ?? [];

        $stockDTO = new StockDTO(
            id_partnumber_stock: $form['id_partnumber_stock'],
            id_almacen_stock: $form['id_almacen_stock'] ?? null,
            id_localizacion_stock: $form['id_localizacion_stock'] ?? null,
            cantidad_stock: $form['cantidad_stock'],
            id_informacion_sap_mb52_stock: $form['id_informacion_sap_mb52_stock'] ?? null,
            id_novedad_stock: null,
            observaciones_novedad_stock: null,
            id_grupo_stock: $form['id_grupo_stock']
        );

        Validator::validateStockDTO($stockDTO);

        $stockService = new StockService();

        $guardarGrupo = $stockService->saveStock($stockDTO);

        if (!$guardarGrupo) {
            throw new Exception("No se pudo guardar el grupo");
        }

        return [
            'success' => true
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

$requestMethod = $_SERVER['REQUEST_METHOD'];

try {
    session_start();
    
    if ($requestMethod === 'GET') {
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'onGet_InfoStock':
                $response = onGetInfoStock($_GET);
                break;
            default:
                throw new Exception("Acción GET no permitida.");
                break;
        }
    }elseif ($requestMethod === 'POST'){
        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            throw new Exception("Datos JSON inválidos o mal formados. Asegúrate de enviar un JSON válido.");
        }

        $action = $data['action'] ?? null;

        switch ($action) {
            case 'guardar_stock':
                $response = onPostSaveStock($data);
                break;
            default:
                throw new Exception("Acción no permitida.");
                break;
        }
    } else {
        throw new Exception("Método no permitido.");
    }
} catch (Exception $e) {
    $response = [
        'success' => false,
        'message' => "Un error interno ocurrió: " . $e->getMessage()
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
