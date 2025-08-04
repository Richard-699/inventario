<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Application\Service\AlmacenesService;
use App\Application\Service\LocalizacionesService;
use App\Shared\Validation\Validator;
use App\Domain\DTO\AlmacenesDTO;
use App\Domain\DTO\AlmacenesLocalizacionesDTO;
use App\Domain\DTO\AlmacenesClasificacionesAlmacenesDTO;
use App\Domain\DTO\LocalizacionesDTO;
use App\Domain\Model\ClasificacionAlmacenes;
use App\Shared\Util\Utilidades;

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

function onGetAlmacenes_By_Id($id)
{
    try {
        $almacenesService = new AlmacenesService();

        $almacenes = $almacenesService->onGetAlmacenes_By__Id($id);

        if ($almacenes) {
            return $almacenes;
        } else {
            throw new Exception("No se encontró el almacén.");
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

function onGetLocalizacionesSelected($id)
{
    try {
        /* $id_almacen = $data['id_almacen'] ?? null; */
        $almacenesService = new AlmacenesService();

        $localizacionesSelected = $almacenesService->onGetAlmacenesLocalizaciones_By_id_almacen($id);

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

function onGetClasificacionesSelected($id)
{
    try {
        $almacenesService = new AlmacenesService();

        $localizacionesSelected = $almacenesService->onGetClasificacionesAlmacenes_By_id_almacen($id);

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

function onGetClasificacionesAlmacenes()
{
    try {
        $almacenesService = new AlmacenesService();

        $clasificaciones = $almacenesService->onGetClasificacionesAlmacenes();

        if ($clasificaciones) {
            return $clasificaciones;
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

function onGetAlmacenesLocalizaciones()
{
    try {
        $localizacionesService = new LocalizacionesService();

        $Almaceneslocalizaciones = $localizacionesService->onGetAlmacenesLocalizaciones();

        if ($Almaceneslocalizaciones) {
            return $Almaceneslocalizaciones;
        } else {
            throw new Exception("No se encontraron resultados entre localizaciones y almacenes.");
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
        $clasificaciones_selected = $form['clasificacion_almacen_select'] ?? [];

        if (!is_array($clasificaciones_selected)) {
            $clasificaciones_selected = [$clasificaciones_selected];
        }

        $clasificaciones_selectedIds = [];
        foreach ($clasificaciones_selected as $clasificaciones_selected_id) {
            $clasificaciones_selectedIds[] = (int)$clasificaciones_selected_id;
        }

        $id_almacen = Utilidades::generarGUID();

        $almacenesDTO = new AlmacenesDTO(
            id_almacen: $id_almacen,
            codigo_sap: $codigo_sap ?? null,
            descripcion_almacen: $descripcion ?? null,
            clasificacionesAlmacenesDTO: $clasificaciones_selectedIds,
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


function onPostUpdateAlmacen(array $data)
{
    try {
        // 1. Preparación de datos del formulario
        $form = $data['form'] ?? [];
        $idsLocalizaciones = $form['localizaciones'] ?? [];
        $idsClasificaciones = $form['clasificaciones_select'] ?? [];
        $idAlmacen = $form['id_almacen'] ?? null;

        // Normalizar a array si vienen como string
        if (!is_array($idsLocalizaciones)) {
            $idsLocalizaciones = [$idsLocalizaciones];
        }
        if (!is_array($idsClasificaciones)) {
            $idsClasificaciones = [$idsClasificaciones];
        }

        // 2. Crear lista de Localizaciones DTO
        $listaLocalizacionesDTO = [];
        foreach ($idsLocalizaciones as $idLocalizacion) {
            $dto = new AlmacenesLocalizacionesDTO(
                null,
                (string)$idAlmacen,
                (int)$idLocalizacion
            );
            $listaLocalizacionesDTO[] = $dto;
        }

        // 3. Crear lista de Clasificaciones DTO
        $listaClasificacionesDTO = [];
        foreach ($idsClasificaciones as $idClasificacion) {
            $dto = new AlmacenesClasificacionesAlmacenesDTO(
                null,
                (string)$idAlmacen,
                (int)$idClasificacion
            );
            $listaClasificacionesDTO[] = $dto;
        }

        // 4. Crear DTO principal del almacén
        $codigo_sap = isset($form['codigo_sap']) ? strtoupper($form['codigo_sap']) : null;
        $descripcion = isset($form['descripcion_almacen']) ? strtoupper($form['descripcion_almacen']) : null;

        $almacenesDTO = new AlmacenesDTO(
            id_almacen: $idAlmacen,
            codigo_sap: $codigo_sap,
            descripcion_almacen: $descripcion,
            localizacionesAlmacenDTO: $listaLocalizacionesDTO,
            clasificacionesAlmacenesDTO: $listaClasificacionesDTO
        );

        // 5. Validar y actualizar
        Validator::validateAlmacenesDTO($almacenesDTO);

        $almacenesService = new AlmacenesService();
        $updateLocalizacionesAlmacen = $almacenesService->updateLocalizacionesAlmacen($almacenesDTO);

        if (!$updateLocalizacionesAlmacen) {
            throw new Exception("No se pudo actualizar el almacén.");
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
            case 'updateAlmacen':
                $response = onPostUpdateAlmacen($data);
                break;
            default:
                throw new Exception("Acción no permitida.");
                break;
        }
    } elseif ($requestMethod === 'GET') {
        $action = $_GET['action'] ?? null;
        $id_almacen = $_GET['id_almacen'] ?? null;

        switch ($action) {
            case 'onGet_almacenes':
                $response = onGetAlmacenes();
                break;
            case 'onGet_almacenes_By_Id':
                $response = onGetAlmacenes_By_Id($id_almacen);
                break;
            case 'onGet_localizaciones':
                $response = onGetLocalizaciones();
                break;
            case 'onGet_clasificacionesAlmacenes':
                $response = onGetClasificacionesAlmacenes();
                break;
            case 'onGet_AlmacenesLocalizaciones':
                $response = onGetAlmacenesLocalizaciones();
                break;
            case 'onGet_clasificacionesSelected':
                $response = onGetClasificacionesSelected($id_almacen);
                break;
            case 'onGet_localizacionesSelected':
                $response = onGetLocalizacionesSelected($id_almacen);
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
