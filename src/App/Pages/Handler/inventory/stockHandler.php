<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Application\Service\BasesDatosSapService;
use App\Application\Service\LocalizacionesService;
use App\Application\Service\StockService;

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
