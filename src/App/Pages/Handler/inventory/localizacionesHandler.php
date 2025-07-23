<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Application\Service\LocalizacionesService;
use App\Shared\Validation\Validator;
use App\Domain\DTO\LocalizacionesDTO;

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

function onGetLocalizacionSelected($data)
{
    try {
        $id = $data['id'] ?? null;

        if ($id === null) {
            throw new Exception("Error al procesar el Id de la localización.");
        }

        $localizacionesService = new LocalizacionesService();
        $localizacion = $localizacionesService->onGetLocalizacion_By__Id($id);

        if ($localizacion) {
            return $localizacion;
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

function onGetTipoLocalizaciones()
{
    try {
        $localizacionesService = new LocalizacionesService();
        $tipoLocalizaciones = $localizacionesService->onGetTipoLocalizaciones();

        if ($tipoLocalizaciones) {
            return $tipoLocalizaciones;
        } else {
            throw new Exception("No se encontraron tipos de localizaciones.");
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

function onPostSaveLocalizaciones(array $data)
{
    try {
        $form = $data['form'] ?? [];
        $descripcion = isset($form['descripcion_localizacion']) ? strtoupper($form['descripcion_localizacion']) : null;
        $idTipoLocalizacionRaw = $form['id_tipo_localizacion_localizaciones'] ?? null;
        $idTipoLocalizacion = null;
        if ($idTipoLocalizacionRaw !== null && $idTipoLocalizacionRaw !== '') {
            $idTipoLocalizacion = (int)$idTipoLocalizacionRaw;
        }

        $localizacionesDTO = new LocalizacionesDTO(
            id_localizacion: null,
            id_tipo_localizacion_localizaciones: $idTipoLocalizacion,
            tipo_localizacion: null,
            descripcion_localizacion: $descripcion ?? null
        );
        Validator::validateLocalizacionesDTO($localizacionesDTO);

        $localizacionesService = new LocalizacionesService();

        $guardarLocalizacion = $localizacionesService->saveLocalizacion($localizacionesDTO);

        if (!$guardarLocalizacion) {
            throw new Exception("No se pudo guardar la localización");
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

function onPostEditLocalizaciones(array $data)
{
    try {
        $form = $data['form'] ?? [];
        $descripcion = isset($form['descripcion_localizacion']) ? strtoupper($form['descripcion_localizacion']) : null;
        $idTipoLocalizacionRaw = $form['id_tipo_localizacion_localizaciones'] ?? null;
        $idTipoLocalizacion = null;
        if ($idTipoLocalizacionRaw !== null && $idTipoLocalizacionRaw !== '') {
            $idTipoLocalizacion = (int)$idTipoLocalizacionRaw;
        }

        $localizacionesDTO = new LocalizacionesDTO(
            id_localizacion: $form['id_localizacion'],
            id_tipo_localizacion_localizaciones: $idTipoLocalizacion,
            tipo_localizacion: null,
            descripcion_localizacion: $descripcion ?? null
        );
        Validator::validateLocalizacionesDTO($localizacionesDTO);

        $localizacionesService = new LocalizacionesService();

        $editLocalizacion = $localizacionesService->updateLocalizacion($localizacionesDTO);

        if (!$editLocalizacion) {
            throw new Exception("No se pudo editar la localización");
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

function onPostDeleteLocalizacion(array $data)
{
    try {
        $id = $data['id'] ?? null;

        if ($id === null) {
            throw new Exception("Error al procesar el Id de la localización.");
        }

        $localizacionesService = new LocalizacionesService();
        $delete_localizacion = $localizacionesService->deleteLocalizacion($id);

        if (!$delete_localizacion) {
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
            case 'guardar_localizacion':
                $response = onPostSaveLocalizaciones($data);
                break;
            case 'delete_localizacion':
                $response = onPostDeleteLocalizacion($data);
                break;
            case 'edit_localizacion':
                $response = onPostEditLocalizaciones($data);
                break;
            default:
                throw new Exception("Acción no permitida.");
                break;
        }
    } elseif ($requestMethod === 'GET') {
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'onGet_localizaciones':
                $response = onGetLocalizaciones();
                break;
            case 'onGet_tipoLocalizaciones':
                $response = onGetTipoLocalizaciones();
                break;
            case 'onGet_localizacionSelected':
                $response = onGetLocalizacionSelected($_GET);
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
