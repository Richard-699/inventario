<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Application\Service\CronogramaService;
use App\Shared\Validation\Validator;

function onGetCronograma(array $data)
{
    try {
        $mes_inicial = $data['rangoInicio'];
        $mes_final = $data['rangoFin'];
        $cronogramaService = new CronogramaService();
        $cronograma = $cronogramaService->onGetCronograma($mes_inicial, $mes_final);

        if ($cronograma) {
            return $cronograma;
        } else {
            throw new Exception("No se encontraron datos en el cronograma.");
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
            /* case 'guardar_grupo':
                $response = onPostSaveGrupo($data);
                break;
            case 'delete_grupo':
                $response = onPostDeleteGrupo($data);
                break;
            case 'updateGrupo':
                $response = onPostUpdateGrupo($data);
                break;
            default:
                throw new Exception("Acción no permitida.");
                break; */
        }
    } elseif ($requestMethod === 'GET') {
        $action = $_GET['action'] ?? null;
        $id_grupo = $_GET['id_grupo'] ?? null;

        switch ($action) {
            case 'onGet_cronograma':
                $response = onGetCronograma($_GET);
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
