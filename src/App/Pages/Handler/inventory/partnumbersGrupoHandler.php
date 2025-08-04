<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Application\Service\BasesDatosSapService;
use App\Application\Service\PartNumbersService;
use App\Shared\Validation\Validator;
use App\Domain\DTO\PartNumbersDTO;

function onGetPartNumbers($data)
{
    try {
        $id_grupo = $data['id_grupo'];
        $partNumbersService = new PartNumbersService();
        $partNumbers = $partNumbersService->onGetPartNumbers($id_grupo);

        if ($partNumbers) {
            return $partNumbers;
        } else {
            throw new Exception("No se encontraron PartNumbers.");
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

function onGetMB52($data)
{
    try {
        $id_partnumber = $data['id_partnumber'];
        $basesDatosSapService = new BasesDatosSapService();
        $mb52 = $basesDatosSapService->onGetMB52($id_partnumber);

        if ($mb52) {
            return $mb52;
        } else {
            throw new Exception("No se encontraron datos en mb52.");
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
            case 'guardar_partnumber':
                $response = onPostSavePartnumbers($data);
                break;
            case 'edit_partnumber':
                $response = onPostEditPartnumbers($data);
                break;
            case 'delete_partnumber':
                $response = onPostDeletePartnumbers($data);
                break;
            default:
                throw new Exception("Acción no permitida.");
                break;
        }
    } elseif ($requestMethod === 'GET') {
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'onGet_partnumbers':
                $response = onGetPartNumbers($_GET);
                break;
            case 'onGet_MB52':
                $response = onGetMB52($_GET);
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
