<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Application\Service\BasesDatosSapService;
use App\Application\Service\LocalizacionesService;
use App\Application\Service\StockService;
use App\Application\Service\ConteoService;
use App\Application\Service\CronogramaService;
use App\Application\Service\FinalizarConteoService;
use App\Application\Service\GruposService;
use App\Domain\DTO\ConteoDTO;
use App\Domain\DTO\CronogramaDTO;
use App\Domain\DTO\GruposDTO;
use App\Domain\DTO\StockDTO;
use App\Shared\Validation\Validator;


function onGetInfoStock(array $data): array
{
    try {
        $id_almacen = $data['id_almacen'] ?? null;
        $id_partnumber = $data['id_partnumber'] ?? null;

        if (is_null($id_almacen) || is_null($id_partnumber)) {
            throw new Exception("Parámetros 'id_almacen' y 'id_partnumber' son requeridos.");
        }

        $localizacionesService = new LocalizacionesService();
        $basesDatosSapService = new BasesDatosSapService();
        $stockService = new StockService();

        $informacionSAP = $basesDatosSapService->onGetInformacionSAP($id_partnumber, $id_almacen);

        if (empty($informacionSAP)) {
            throw new Exception("No se encontró información SAP para el PartNumber: {$id_partnumber} en el Almacén: {$id_almacen}.");
        }

        $localizaciones = [];
        // Verifica si el almacén es WM01, que es el que sí tiene localizaciones
        if ($informacionSAP[0]->almacen === "WM01") {
            $localizaciones = $informacionSAP[0]->localizacionesWM;
        } else {
            // Para otros almacenes, obtiene las localizaciones si existen, si no, devuelve un array vacío
            $localizaciones = $localizacionesService->onGetLocalizaciones_By__Id_Almacen($id_almacen) ?? [];
        }

        $stock = $stockService->onGetStock_By__Id_PartNumber_By_Id_Almacen($id_partnumber, $id_almacen);

        // Ahora, en lugar de lanzar una excepción, simplemente devolvemos los datos
        // La lógica en el frontend se encargará de mostrar la tabla vacía si no hay localizaciones
        return [
            'success' => true,
            'localizaciones' => $localizaciones,
            'informacionSAP' => $informacionSAP,
            'stock' => $stock
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Error en la consulta. Detalles: ' . $e->getMessage()
        ];
    }
}

function onGetInfoCronograma(array $data): array
{
    try {
        $id_grupo = $data['id_grupo'];

        $cronogramaService = new CronogramaService();
        $infoCronograma = $cronogramaService->onGetCronograma_By__Id_Grupo($id_grupo);

        if ($infoCronograma) {
            return [
                'success' => true,
                'id_cronograma' => $infoCronograma->id_cronograma,
                'fecha_cronograma' => $infoCronograma->fecha_cronograma,
                'id_grupo_cronograma' => $infoCronograma->id_grupo_cronograma,
                'id_estado_cronograma' => $infoCronograma->id_estado_cronograma,
                'id_administrador_cronograma' => $infoCronograma->id_administrador_cronograma
            ];
        } else {
            throw new Exception("No se encontraron datos para este grupo en el cronograma.");
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

function onGetInfoConteoResumen(array $data): array
{
    try {
        $id_grupo = $data['id_grupo'];

        $conteoService = new ConteoService();
        $infoConteo = $conteoService->onGetInfo_Conteo_By_Grupo($id_grupo);

        if ($infoConteo) {
            // convertir el DTO en array (ajusta según las propiedades reales de ConteoDTO)
            $result = [
                'infoStock' => $infoConteo->infoStock ?? [],
                'infoMB52'  => $infoConteo->infoMB52 ?? [],
                'infoWM'    => $infoConteo->infoWM ?? [],
                'infoPartNumbers'    => $infoConteo->infoPartNumbers ?? [],
                'infoAlmacenes'    => $infoConteo->infoAlmacenes ?? [],
                'infoLocalizaciones'    => $infoConteo->infoLocalizaciones ?? [],
                'infoInventarioHwiUmb'    => $infoConteo->infoInventarioHwiUmb ?? [],
                'infoLocalizacionesAlmacenes'    => $infoConteo->infoLocalizacionesAlmacenes ?? [],
            ];

            return [
                'success' => true,
                'data'    => $result
            ];
        } else {
            throw new Exception("No se encontraron datos para este grupo.");
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

function onPostSaveStock(array $data): array
{
    try {
        $form = $data['form'] ?? [];
        date_default_timezone_set('America/Bogota');

        $conteoService = new ConteoService();
        $conteoData = $conteoService->onGetConteo_By__Fecha_Reciente_Grupo($form['id_grupo_stock']);

        if (empty($conteoData)) {
            throw new Exception("No se pudo consultar el id del conteo.");
        }

        $idConteo = $conteoData->id_conteo;

        $stockDTO = new StockDTO(
            id_partnumber_stock: $form['id_partnumber_stock'],
            id_almacen_stock: $form['id_almacen_stock'] ?? null,
            id_localizacion_stock: $form['id_localizacion_stock'] ?? null,
            cantidad_stock: $form['cantidad_stock'],
            id_informacion_sap_mb52_stock: $form['id_informacion_sap_mb52_stock'] ?? null,
            id_novedad_stock: null,
            observaciones_novedad_stock: $form['observaciones'] ?? null,
            id_grupo_stock: $form['id_grupo_stock'],
            id_conteo_stock: $idConteo,
            fecha_hora_stock: date('Y-m-d H:i:s'),
            id_administrador_stock: $form['id_administrador']
        );

        Validator::validateStockDTO($stockDTO);

        $stockService = new StockService();
        $guardarStock = $stockService->saveStock($stockDTO);

        if (!$guardarStock) {
            throw new Exception("No se pudo guardar el stock.");
        }

        return ['success' => true];
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

function onPost_FinalizarConteo(array $data): array
{
    try {
        $finalizarConteoService = new FinalizarConteoService();
        $finalizarConteoService->finalizarConteo($data['form'] ?? []);

        return ['success' => true];
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

// ----------------------------------------------------
// Lógica principal para manejar las peticiones HTTP
// ----------------------------------------------------

$requestMethod = $_SERVER['REQUEST_METHOD'];
$response = [];

try {
    session_start();

    if ($requestMethod === 'GET') {
        $action = $_GET['action'] ?? null;
        switch ($action) {
            case 'onGet_InfoStock':
                $response = onGetInfoStock($_GET);
                break;
            case 'onGet_InfoCronograma':
                $response = onGetInfoCronograma($_GET);
                break;
            case 'onGet_InfoConteoResumen':
                $response = onGetInfoConteoResumen($_GET);
                break;
            default:
                throw new Exception("Acción GET no permitida.");
        }
    } elseif ($requestMethod === 'POST') {
        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            throw new Exception("Datos JSON inválidos o mal formados. Asegúrate de enviar un JSON válido.");
        }

        $action = $data['action'] ?? null;
        switch ($action) {
            case 'guardar_stock':
                $response = onPostSaveStock($data);
                break;
            case 'finalizar_Conteo':
                $response = onPost_FinalizarConteo($data);
                break;
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
