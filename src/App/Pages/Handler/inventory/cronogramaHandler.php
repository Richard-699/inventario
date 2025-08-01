<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Application\Service\CronogramaService;

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
    if ($requestMethod === 'GET') {
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
