<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Application\Service\PartNumbersService;
use App\Shared\Validation\Validator;
use App\Domain\DTO\PartNumbersDTO;

function onGetPartNumbers()
{
    try {
        $partNumbersService = new PartNumbersService();
        $partNumbers = $partNumbersService->onGetPartNumbers();

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

function onGetUMBS()
{
    try {
        $partNumbersService = new PartNumbersService();
        $umbs = $partNumbersService->onGetUMBS();

        if ($umbs) {
            return $umbs;
        } else {
            throw new Exception("No se encontraron UMBS.");
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

function onGetPlataformas()
{
    try {
        $partNumbersService = new PartNumbersService();
        $plataformas = $partNumbersService->onGetPlataformas();

        if ($plataformas) {
            return $plataformas;
        } else {
            throw new Exception("No se encontraron plataformas.");
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

function onGetPartnumberSelected($data)
{
    try {
        $id = $data['id'] ?? null;

        if ($id === null) {
            throw new Exception("Error al procesar el Id del partnumber.");
        }

        $partnumbersService = new PartNumbersService();
        $partnumber = $partnumbersService->onGetPartNumber_By__Id($id);

        if ($partnumber) {
            return $partnumber;
        } else {
            throw new Exception("No se encontraron partnumbers.");
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

function onPostSavePartnumbers(array $data){
    try {
        $form = $data['form'] ?? [];
        $listaDTO = [];

        $total_list = count($form['partnumber'] ?? []);

        for ($i = 0; $i < $total_list; $i++) {
            $id_umb = isset($form['id_umb_partnumber'][$i]) && $form['id_umb_partnumber'][$i] !== '' ? (int) $form['id_umb_partnumber'][$i] : null;
            $id_plataforma = isset($form['id_plataforma_partnumber'][$i]) && $form['id_plataforma_partnumber'][$i] !== '' ? (int) $form['id_plataforma_partnumber'][$i] : null;
            $descripcion_breve = isset($form['descripcion_breve'][$i]) ? strtoupper($form['descripcion_breve'][$i]) : null;
            $nombre_interno = isset($form['nombre_interno'][$i]) ? strtoupper($form['nombre_interno'][$i]) : null;

            $dto = new PartnumbersDTO(
                id_partnumber: null,
                partnumber: $form['partnumber'][$i] ?? null,
                descripcion_breve: $descripcion_breve,
                id_umb_partnumber: $id_umb,
                nombre_interno: $nombre_interno,
                id_grupo_partnumber: null,
                id_plataforma_partnumber: $id_plataforma,
            );

            Validator::validateDTO($dto);
            $listaDTO[] = $dto;
        }

        $partnumbersService = new PartNumbersService();
        $guardarPartnumbers = $partnumbersService->savePartNumbers($listaDTO);

        if (!$guardarPartnumbers) {
            throw new Exception("No se pudo guardar los partnumbers");
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

function onPostEditPartnumbers(array $data)
{
    try {
        $form = $data['form'] ?? [];
        $id_umb = isset($form['id_umb_partnumber']) && $form['id_umb_partnumber'] !== '' ? (int) $form['id_umb_partnumber'] : null;
        $id_grupo = isset($form['id_grupo_partnumber']) && $form['id_grupo_partnumber'] !== '' ? (int) $form['id_grupo_partnumber'] : null;
        $id_plataforma = isset($form['id_plataforma_partnumber']) && $form['id_plataforma_partnumber'] !== '' ? (int) $form['id_plataforma_partnumber'] : null;
        $descripcion_breve = isset($form['descripcion_breve']) && is_string($form['descripcion_breve'])
            ? strtoupper($form['descripcion_breve'])
            : null;

        $nombre_interno = isset($form['nombre_interno']) && is_string($form['nombre_interno'])
            ? strtoupper($form['nombre_interno'])
            : null;

        $id_partnumber = isset($form['id_partnumber']) && $form['id_partnumber'] !== '' 
            ? (int) $form['id_partnumber'] 
            : null;

        $partnumbersDTO = new PartNumbersDTO(
            id_partnumber: $id_partnumber,
            partnumber: $form['partnumber'] ?? null,
            descripcion_breve: $descripcion_breve,
            id_umb_partnumber: $id_umb,
            nombre_interno: $nombre_interno,
            id_grupo_partnumber: $id_grupo,
            id_plataforma_partnumber: $id_plataforma,
        );

        Validator::validateDTO($partnumbersDTO);

        $partNumbersService = new PartNumbersService();

        $editLocalizacion = $partNumbersService->updatePartNumber($partnumbersDTO);

        if (!$editLocalizacion) {
            throw new Exception("No se pudo editar el partnumber");
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

function onPostDeletePartnumbers(array $data)
{
    try {
        $id = $data['id'] ?? null;

        if ($id === null) {
            throw new Exception("Error al procesar el Id del partnumber.");
        }

        $partnumbersService = new PartNumbersService();
        $delete_localizacion = $partnumbersService->deletePartNumbers($id);

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
                $response = onGetPartNumbers();
                break;
            case 'onGet_UMBS':
                $response = onGetUMBS();
                break;
            case 'onGet_Plataformas':
                $response = onGetPlataformas();
                break;
            case 'onGet_partnumberSelected':
                $response = onGetPartnumberSelected($_GET);
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
