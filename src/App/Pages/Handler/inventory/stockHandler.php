<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Application\Service\AlmacenesService;
use App\Application\Service\ConteoService;
use App\Application\Service\LocalizacionesService;

function onGetInfoStock($data)
{
    try {
        $id_almacen = $data['id_almacen'];

        $localizacionesService = new LocalizacionesService();
        $localizaciones = $localizacionesService->onGetLocalizaciones_By__Id_Almacen($id_almacen);

        if ($localizaciones) {
            $mb52 = $_SESSION['mb52'] ?? [];

            return [
                'localizaciones' => $localizaciones,
                'mb52' => $mb52
            ];
        } else {
            throw new Exception("No se encontraron Localizaciones para este almacén.");
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
