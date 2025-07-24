<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Application\Service\GruposService;
use App\Shared\Validation\Validator;
use App\Domain\DTO\AlmacenesDTO;
use App\Domain\DTO\GruposDTO;

function onGetGrupos()
{
    try {
        $gruposService = new GruposService();

        $grupos = $gruposService->onGetGrupos();

        if ($grupos) {
            return $grupos;
        } else {
            throw new Exception("No se encontraron grupos.");
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

function onPostSaveGrupo(array $data)
{
    try {
        $form = $data['form'] ?? [];
        // Normalizar valores a MAYÚSCULA (sin tildes ni cambios de idioma)
        $descripcion = isset($form['descripcion_grupo']) ? strtoupper($form['descripcion_grupo']) : null;

        $gruposDTO = new GruposDTO(
            id_grupo: null,
            descripcion_grupo: $descripcion ?? null
        );
        Validator::validateGruposDTO($gruposDTO);

        $gruposService = new GruposService();

        $guardarGrupo = $gruposService->saveGrupo($gruposDTO);

        if (!$guardarGrupo) {
            throw new Exception("No se pudo guardar el grupo");
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

function onPostDeleteGrupo(array $data)
{
    try {
        $id_grupo = $data['id'] ?? null;

        if ($id_grupo === null) {
            throw new Exception("Error al procesar el Id del grupo.");
        }

        $gruposService = new GruposService();

        $delete_grupos = $gruposService->deleteGrupo($id_grupo);

        if (!$delete_grupos) {
            throw new Exception("No se pudo eliminar el grupo.");
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
            case 'guardar_grupo':
                $response = onPostSaveGrupo($data);
                break;
            case 'delete_grupo':
                $response = onPostDeleteGrupo($data);
                break;
            default:
                throw new Exception("Acción no permitida.");
                break;
        }
    } elseif ($requestMethod === 'GET') {
        $action = $_GET['action'] ?? null;
        /* $id_almacen = $_GET['id_almacen'] ?? null; */

        switch ($action) {
            case 'onGet_grupos':
                $response = onGetGrupos();
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
