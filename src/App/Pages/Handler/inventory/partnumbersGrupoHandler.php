<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Application\Service\BasesDatosSapService;
use App\Application\Service\CronogramaService;
use App\Application\Service\PartNumbersService;
use App\Application\Service\GruposService;

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

function onGetInfoGrupo($data)
{
    try {
        $id = $data['id_grupo'] ?? null;

        if ($id === null) {
            throw new Exception("Error al procesar el Id Grupo.");
        }

        $GrupoService = new GruposService();
        $Grupo = $GrupoService->onGetGrupo_By__Id($id);

        if ($Grupo) {
            return $Grupo;
        } else {
            throw new Exception("No se encontró el grupo.");
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

function onGetInfoCronograma($data)
{
    try {
        $id = $data['id_grupo'] ?? null;

        if ($id === null) {
            throw new Exception("Error al procesar el Id Grupo.");
        }

        $CronogramaService = new CronogramaService();
        $Cronograma = $CronogramaService->onGetCronograma_By__Id_Grupo($id);

        if ($Cronograma) {
            return $Cronograma;
        } else {
            throw new Exception("No se encontró el cronograma.");
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}


function onGetInformacionSAP($data)
{
    try {
        $id_partnumber = $data['id_partnumber'];
        $id_almacen = null;
        $basesDatosSapService = new BasesDatosSapService();
        $informacionSAP = $basesDatosSapService->onGetInformacionSAP($id_partnumber, $id_almacen);

        if ($informacionSAP) {
            return $informacionSAP;
        } else {
            throw new Exception("No se encontraron datos de informacion sap.");
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

    // soporte GET y POST: unificamos la fuente de datos
    if ($requestMethod === 'GET' || $requestMethod === 'POST') {
        $input = $requestMethod === 'GET' ? $_GET : $_POST;
        $action = $input['action'] ?? null;

        switch ($action) {
            case 'onGet_partnumbers':
                $response = onGetPartNumbers($input);
                break;
            case 'onGet_InformacionSAP':
                $response = onGetInformacionSAP($input);
                break;
            case 'onGet_info_grupo':
                $response = onGetInfoGrupo($input);
                break;
            case 'onGet_info_cronograma':
                $response = onGetInfoCronograma($input);
                break;
            case 'onPostSeleccionAlmacen':
                // implementar lógica para procesar la selección (POST)
                // ejemplo: $response = onPostSeleccionAlmacen($input);
                // break;
            default:
                throw new Exception("Acción no permitida.");
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
