<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Application\Service\AprobacionService;
use App\Application\Service\ConteoService;
use App\Application\Service\CronogramaService;
use App\Domain\DTO\ConteoDTO;
use App\Shared\Validation\Validator;
use App\Domain\DTO\PartNumbersDTO;
use App\Domain\DTO\CronogramaDTO;

function onGetConteo()
{
    try {
        $id = null;
        $aprobacionService = new AprobacionService();
        $conteo = $aprobacionService->onGetConteo();

        if ($conteo) {
            return $conteo;
        } else {
            throw new Exception("No se encontraron conteos.");
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

function onPostAprobarConteo(array $data)
{
    try {
        $form = $data['form'] ?? [];

        $id_conteo = ($form['id_conteo'] ?? null);
        $observaciones = strtoupper($form['observaciones'] ?? null);

        // La instancia del servicio debe ser inyectada si es posible
        $conteoService = new ConteoService();

        $datosActualesConteo = $conteoService->onGetConteo_By__id($id_conteo);

        // Lanza una excepción si no se encuentra el registro del conteo.
        if (!$datosActualesConteo) {
            throw new Exception("No se encontraron datos de este conteo #" . $id_conteo);
        }

        // Asigna los valores a las variables
        $id_grupo_conteo = $datosActualesConteo->id_grupo_conteo;
        $id_encargado_conteo = $datosActualesConteo->id_encargado_conteo;
        $fecha_hora_inicio_conteo = $datosActualesConteo->fecha_hora_inicio_conteo;
        $fecha_hora_final_conteo = $datosActualesConteo->fecha_hora_final_conteo;
        $observaciones_conteo = $datosActualesConteo->observaciones_conteo;
        $estado_conteo = "Aprobado";
        $observacion_final_conteo = $observaciones;

        $ConteoDTO = new ConteoDTO(
            id_conteo: $id_conteo,
            id_grupo_conteo: $id_grupo_conteo,
            id_encargado_conteo: $id_encargado_conteo,
            fecha_hora_inicio_conteo: $fecha_hora_inicio_conteo,
            fecha_hora_final_conteo: $fecha_hora_final_conteo,
            observaciones_conteo: $observaciones_conteo,
            estado_conteo: $estado_conteo,
            observacion_final_conteo: $observacion_final_conteo
        );


        Validator::validateConteoDTO($ConteoDTO);

        $updateConteo = $conteoService->updateConteo($ConteoDTO);

        if (!$updateConteo) {
            throw new Exception("No se pudo aprobar este conteo");
        }

        $cronogramaService = new CronogramaService();
        /* ACTUALIZAR LA INFORMACION DEL CRONOGRAMA */
        $FechaActualCronograma = $cronogramaService->onGetCronograma_By__Id_Grupo($id_grupo_conteo);
        $fechaBD = $FechaActualCronograma->fecha_cronograma;
        $id_estado_cronograma = $FechaActualCronograma->id_estado_cronograma;

        // Se inicializan las variables con valores por defecto
        $id_nuevo_estado = null;
        $nuevaFechaCronogramaString = null; // Variable para la cadena de texto

        // Crear el objeto DateTime
        $fechaCronograma = DateTime::createFromFormat('Y-m', $fechaBD);


        // Se reinicia el estado del cronograma y se cambia la fecha una vez se apruebe el conteo por el administrador
        // Se deja vacio el id_administrador para que no quede vinculado el cronograma hasta que alguien mas lo tome
        $id_nuevo_estado = 1;
        $fechaCronograma->modify('+3 months');
        
        // Convertir el objeto DateTime a la cadena 'Y-m' (char(7)) que espera el DTO.
        $nuevaFechaCronogramaString = $fechaCronograma->format('Y-m'); 
        

        // Ahora, al final de la lógica, puedes usar las variables ya asignadas
        if (is_null($id_nuevo_estado) || is_null($nuevaFechaCronogramaString)) {
            // Manejar el caso si no se asignó un estado o fecha (por si el 'if' inicial falla)
            throw new Exception("No se pudo determinar el nuevo estado o fecha del cronograma.");
        }

        // Aquí es donde actualizamos la base de datos, usando las variables ya validadas

        $cronogramaDTO = new CronogramaDTO(
            fecha_cronograma: $nuevaFechaCronogramaString,
            id_grupo_cronograma: $id_grupo_conteo,
            id_estado_cronograma: $id_nuevo_estado,
            id_administrador_cronograma: null
        );


        $actualizarCronograma = $cronogramaService->updateCronograma($cronogramaDTO);
        if (!$actualizarCronograma) {
            throw new Exception("No se pudo actualizar el cronograma.");
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

function onPostRechazarConteo(array $data)
{
    try {
        $form = $data['form'] ?? [];

        $id_conteo = ($form['id_conteo'] ?? null);
        $observaciones = strtoupper($form['observaciones'] ?? null);

        // La instancia del servicio debe ser inyectada si es posible
        $conteoService = new ConteoService();

        $datosActualesConteo = $conteoService->onGetConteo_By__id($id_conteo);

        // Lanza una excepción si no se encuentra el registro del conteo.
        if (!$datosActualesConteo) {
            throw new Exception("No se encontraron datos de este conteo #" . $id_conteo);
        }

        // Asigna los valores a las variables
        $id_grupo_conteo = $datosActualesConteo->id_grupo_conteo;
        $id_encargado_conteo = $datosActualesConteo->id_encargado_conteo;
        $fecha_hora_inicio_conteo = $datosActualesConteo->fecha_hora_inicio_conteo;
        $fecha_hora_final_conteo = $datosActualesConteo->fecha_hora_final_conteo;
        $observaciones_conteo = $datosActualesConteo->observaciones_conteo;
        $estado_conteo = "Rechazado";
        $observacion_final_conteo = $observaciones;

        $ConteoDTO = new ConteoDTO(
            id_conteo: $id_conteo,
            id_grupo_conteo: $id_grupo_conteo,
            id_encargado_conteo: $id_encargado_conteo,
            fecha_hora_inicio_conteo: $fecha_hora_inicio_conteo,
            fecha_hora_final_conteo: $fecha_hora_final_conteo,
            observaciones_conteo: $observaciones_conteo,
            estado_conteo: $estado_conteo,
            observacion_final_conteo: $observacion_final_conteo
        );


        Validator::validateConteoDTO($ConteoDTO);

        $updateConteo = $conteoService->updateConteo($ConteoDTO);

        if (!$updateConteo) {
            throw new Exception("No se pudo aprobar este conteo");
        }

        $cronogramaService = new CronogramaService();
        /* ACTUALIZAR LA INFORMACION DEL CRONOGRAMA */
        $FechaActualCronograma = $cronogramaService->onGetCronograma_By__Id_Grupo($id_grupo_conteo);
        $fechaBD = $FechaActualCronograma->fecha_cronograma;
        $id_administrador_cronograma = $FechaActualCronograma->id_administrador_cronograma;
        $id_estado_cronograma = $FechaActualCronograma->id_estado_cronograma;

        // Se inicializan las variables con valores por defecto
        $id_nuevo_estado = null;
        $id_nuevo_estado = 5;

        // Aquí es donde actualizamos la base de datos, usando las variables ya validadas

        $cronogramaDTO = new CronogramaDTO(
            fecha_cronograma: $fechaBD,
            id_grupo_cronograma: $id_grupo_conteo,
            id_estado_cronograma: $id_nuevo_estado,
            id_administrador_cronograma: $id_administrador_cronograma
        );

        $actualizarCronograma = $cronogramaService->updateCronograma($cronogramaDTO);
        if (!$actualizarCronograma) {
            throw new Exception("No se pudo actualizar el cronograma.");
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
            case 'aprobar_conteo_administrador':
                $response = onPostAprobarConteo($data);
                break;
            case 'rechazar_conteo_administrador':
                $response = onPostRechazarConteo($data);
                break;
            default:
                throw new Exception("Acción no permitida.");
                break;
        }
    } elseif ($requestMethod === 'GET') {
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'onGet_conteos':
                $response = onGetConteo();
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
