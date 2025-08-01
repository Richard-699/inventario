<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Application\Service\GruposService;
use App\Application\Service\CronogramaService;
use App\Application\Service\PartNumbersService;
use App\Domain\DTO\CronogramaDTO;
use App\Shared\Validation\Validator;
use App\Domain\DTO\GruposDTO;
use App\Domain\DTO\PartNumbersDTO;
use App\Shared\Util\Utilidades;

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

function onGetPartnumbers()
{
    try {
        $id = null;
        $partnumbersService = new PartNumbersService();
        $partnumbers = $partnumbersService->onGetPartNumbers($id);

        if ($partnumbers) {
            return $partnumbers;
        } else {
            throw new Exception("No se encontraron partNumbers.");
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

function onGetGrupo_By_Id($id)
{
    try {
        $gruposService = new GruposService();

        $grupo = $gruposService->onGetGrupo_By__Id($id);

        if ($grupo) {
            return $grupo;
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

function onPostSaveGrupo(array $data)
{
    try {
        $form = $data['form'] ?? [];
        $descripcion = isset($form['descripcion_grupo']) ? strtoupper($form['descripcion_grupo']) : null;
        $fecha_programacion_grupo = isset($form['fecha_programacion_grupo']) ? $form['fecha_programacion_grupo'] : null;
        $id_grupo = Utilidades::generarGUID();
        $gruposDTO = new GruposDTO(
            id_grupo: $id_grupo,
            descripcion_grupo: $descripcion ?? null,
            fecha_programacion_grupo: $fecha_programacion_grupo
        );
        Validator::validateGruposDTO($gruposDTO);

        $estado_cronograma = 1;
        $cronogramaDTO = new CronogramaDTO(
            fecha_cronograma: $fecha_programacion_grupo,
            id_grupo_cronograma: $id_grupo,
            id_estado_cronograma: $estado_cronograma
        );

        $gruposService = new GruposService();

        $guardarGrupo = $gruposService->saveGrupo($gruposDTO, $cronogramaDTO);

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

function onPostUpdateGrupo(array $data)
{
    try {
        $form = $data['form'] ?? [];
        $idGrupo = isset($form['id_grupo']) ? (string)$form['id_grupo'] : null;
        $part_numbers_select = $form['part_numbers_select'] ?? [];

        if (!is_array($part_numbers_select)) {
            $part_numbers_select = [$part_numbers_select];
        }

        $selectedPartNumberIds = [];
        foreach ($part_numbers_select as $part_number_id) {
            $selectedPartNumberIds[] = (int)$part_number_id;
        }
        $gruposService = new GruposService();

        $nombreGrupo = isset($form['descripcion_grupo']) ? strtoupper($form['descripcion_grupo']) : null;
        $fecha_programacion_grupo = isset($form['fecha_programacion_grupo']) ? $form['fecha_programacion_grupo'] : null;

        $gruposDTO = new GruposDTO(
            id_grupo: $idGrupo,
            descripcion_grupo: $nombreGrupo,
            fecha_programacion_grupo: $fecha_programacion_grupo,
            partnumberGruposDTO: $selectedPartNumberIds,
        );

        Validator::validateGruposDTO($gruposDTO);

        $cronogramaDTO = new CronogramaDTO(
            fecha_cronograma: $fecha_programacion_grupo,
            id_grupo_cronograma: $idGrupo,
        );

        $update_grupo = $gruposService->updateGrupoPartNumbersCronograma($gruposDTO, $cronogramaDTO);

        if (!$update_grupo) {
            throw new Exception("No se pudo actualizar el grupo.");
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
            case 'updateGrupo':
                $response = onPostUpdateGrupo($data);
                break;
            default:
                throw new Exception("Acción no permitida.");
                break;
        }
    } elseif ($requestMethod === 'GET') {
        $action = $_GET['action'] ?? null;
        $id_grupo = $_GET['id_grupo'] ?? null;

        switch ($action) {
            case 'onGet_grupos':
                $response = onGetGrupos();
                break;
            case 'onGet_partnumbers':
                $response = onGetPartnumbers();
                break;
            case 'onGet_grupo_By_id':
                $response = onGetGrupo_By_Id($id_grupo);
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
