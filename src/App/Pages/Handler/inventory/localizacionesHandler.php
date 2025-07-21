<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Application\Service\LocalizacionesService;
use App\Shared\Validation\Validator;
use App\Domain\DTO\AlmacenesDTO;

function onGetLocalizaciones()
{
    try {
        $localizacionesService = new LocalizacionesService();

        $localizaciones = $localizacionesService->onGetLocalizaciones();

        if ($localizaciones) {
            return $localizaciones;
        } else {
            throw new Exception("No se encontraron localizaciones.");
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
    if ($requestMethod === 'POST') {
        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            throw new Exception("Datos JSON inválidos o mal formados. Asegúrate de enviar un JSON válido.");
        }

        $action = $data['action'] ?? null;

        switch ($action) {
            case 'guardar_almacen':
                $response = onPostSaveAlmacenes($data);
                break;
            case 'delete_almacenes':
                $response = onPostDeleteAlmacen($data);
                break;
            default:
                throw new Exception("Acción no permitida.");
                break;
        }
    } elseif ($requestMethod === 'GET') {
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'onGet_almacenes':
                $response = onGetAlmacenes();
                break;
            case 'onGet_localizaciones':
                $response = onGetLocalizaciones();
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
