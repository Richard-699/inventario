<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Application\Service\AlmacenesService;
use App\Application\Service\LocalizacionesService;
use App\Shared\Validation\Validator;
use App\Domain\DTO\AlmacenesDTO;

function onGetAlmacenes()
{
    try {
        $almacenesService = new AlmacenesService();

        $almacenes = $almacenesService->onGetAlmacenes();

        if ($almacenes) {
            return $almacenes;
        } else {
            throw new Exception("No se encontraron almacenes.");
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

function onGetAlmacen_Id($id)
{
    try {
        $almacenesService = new AlmacenesService();

        $almacenes = $almacenesService->onGetAlmacenes_By__Id($id);

        if ($almacenes) {
            return $almacenes;
        } else {
            throw new Exception("No se encontraron almacenes.");
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

function onGetLocalizacionesSelected(array $data)
{
    try {
        $id_almacen = $data['id_almacen'] ?? null;
        $almacenesService = new AlmacenesService();

        $localizacionesSelected = $almacenesService->onGetAlmacenesLocalizaciones_By_id_almacen($id_almacen);

        if ($localizacionesSelected) {
            return $localizacionesSelected;
        } else {
            throw new Exception("No se encontraron localizaciones seleccionadas.");
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

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

function onPostDeleteAlmacen(array $data)
{
    try {
        $id_almacen = $data['id'] ?? null;

        if ($id_almacen === null) {
            throw new Exception("Error al procesar el Id del almacén.");
        }

        $almacenesService = new AlmacenesService();

        $delete_almacenes = $almacenesService->deleteAlmacen($id_almacen);

        if (!$delete_almacenes) {
            throw new Exception("No se pudo eliminar el almacén.");
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

function onPostSaveAlmacenes(array $data)
{
    try {
        $form = $data['form'] ?? [];
        // Normalizar valores a MAYÚSCULA (sin tildes ni cambios de idioma)
        $codigo_sap = isset($form['codigo_sap']) ? strtoupper($form['codigo_sap']) : null;
        $descripcion = isset($form['descripcion_almacen']) ? strtoupper($form['descripcion_almacen']) : null;

        $almacenesDTO = new AlmacenesDTO(
            id_almacen: null,
            codigo_sap: $codigo_sap ?? null,
            descripcion_almacen: $descripcion ?? null
        );
        Validator::validateAlmacenesDTO($almacenesDTO);

        $almacenesService = new AlmacenesService();

        $guardarAlmacen = $almacenesService->saveAlmacen($almacenesDTO);

        if (!$guardarAlmacen) {
            throw new Exception("No se pudo guardar el almacen");
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
            case 'onGet_localizacionesSelected':
                $response = onGetLocalizacionesSelected($data);
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
