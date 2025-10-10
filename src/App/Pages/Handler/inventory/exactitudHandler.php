<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Application\Service\AprobacionService;
use App\Application\Service\BasesDatosSapService;
use App\Domain\DTO\ExactitudDTO;
use App\Shared\Validation\Validator;
use App\Domain\DTO\PartNumbersDTO;

function onGetExactitud()
{
    try {
        $id = null;
        $basesDatosSapService = new BasesDatosSapService();
        $exactitud = $basesDatosSapService->onGetExactitud();

        if ($exactitud) {
            return $exactitud;
        } else {
            throw new Exception("No se encontraron registros de exactitud.");
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

function onPostUpdateExactitud(array $data)
{
    try {
        $form = $data['form'] ?? [];

        $id_exactitud = ($form['id_exactitud'] ?? null);
        $coincide = ($form['coincide'] ?? null);
        $novedad = ($form['novedad'] ?? null);
        $observaciones = strtoupper($form['observaciones'] ?? null);

        // La instancia del servicio debe ser inyectada si es posible
        $bdSapService = new BasesDatosSapService();

        $datosActualesExactitud = $bdSapService->onGetExactitud_By_Id($id_exactitud);

        // Lanza una excepción si no se encuentra el registro.
        if (!$datosActualesExactitud) {
            throw new Exception("No se encontraron datos de exactitud para el ID: " . $id_exactitud);
        }

        // Asigna los valores a las variables
        $partnumber_exactitud = $datosActualesExactitud->partnumber_exactitud;
        $descripcion_partnumber_exactitud = $datosActualesExactitud->descripcion_partnumber_exactitud;
        $tipo_almacen_exactitud = $datosActualesExactitud->tipo_almacen_exactitud;
        $area_almacenamiento_exactitud = $datosActualesExactitud->area_almacenamiento_exactitud;
        $localizacion_exactitud = $datosActualesExactitud->localizacion_exactitud;
        $fecha_hora_migracion_exactitud = $datosActualesExactitud->fecha_hora_migracion_exactitud;
        $id_administrador = $datosActualesExactitud->id_administrador;

        $exactitudDTO = new ExactitudDTO(
            id_exactitud: $id_exactitud,
            partnumber_exactitud: $partnumber_exactitud,
            descripcion_partnumber_exactitud: $descripcion_partnumber_exactitud,
            tipo_almacen_exactitud: $tipo_almacen_exactitud,
            area_almacenamiento_exactitud: $area_almacenamiento_exactitud,
            localizacion_exactitud: $localizacion_exactitud,
            coincide_exactitud: $coincide,
            novedad_exactitud: $novedad,
            descripcion_novedad_exactitud: $observaciones ?? null,
            fecha_hora_migracion_exactitud: $fecha_hora_migracion_exactitud,
            id_administrador: $id_administrador
        );

        Validator::validateExactitudDTO($exactitudDTO);

        $editExactitud = $bdSapService->updateExactitud($exactitudDTO);

        if (!$editExactitud) {
            throw new Exception("No se pudo actualizar el registro de exactitud");
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
    if ($requestMethod === 'POST') {
        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            throw new Exception("Datos JSON inválidos o mal formados. Asegúrate de enviar un JSON válido.");
        }

        $action = $data['action'] ?? null;

        switch ($action) {
            case 'registrar_exactitud':
                $response = onPostUpdateExactitud($data);
                break;
            default:
                throw new Exception("Acción no permitida.");
                break;
        }
    } elseif ($requestMethod === 'GET') {
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'onGet_exactitud':
                $response = onGetExactitud();
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
