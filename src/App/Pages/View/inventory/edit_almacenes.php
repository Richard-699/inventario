<?php
// ========================================================
// ⚠️ Manejo de Errores y Función de Depuración ⚠️
// ========================================================

/**
 * Envía una respuesta de error o depuración al cliente y detiene la ejecución.
 * @param string $message Mensaje a mostrar.
 * @param array $data Datos adicionales para depuración (opcional).
 */
function debug_response($message, $data = null) {
    if (headers_sent()) {
        echo "<pre>ERROR de PHP: {$message}</pre>";
        if ($data) {
            echo "<pre>" . print_r($data, true) . "</pre>";
        }
        exit;
    }

    header('Content-Type: application/json');
    
    $response = [
        'success' => false,
        'error' => $message
    ];
    
    if ($data !== null) {
        $response['debug_data'] = $data;
    }
    
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
}

// --------------------------------------------------------

// ✅ 1. LECTURA DE DATOS JSON
$json_data = file_get_contents('php://input');

// ❌ VERIFICAR si se recibió algún dato
if (empty($json_data)) {
    debug_response('Error: El cuerpo de la solicitud (Request Body) está vacío.', ['method' => $_SERVER['REQUEST_METHOD']]);
}

// ✅ 2. DECODIFICACIÓN Y VERIFICACIÓN DE JSON
$data = json_decode($json_data, true);

// ❌ VERIFICAR si la decodificación JSON falló
if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    debug_response('Error: Falló la decodificación del JSON.', ['error_message' => json_last_error_msg(), 'raw_data' => $json_data]);
}

// ============================================
// ✅ 3. Asignación de variables usando el array $data
// ============================================

$localizaciones = $data['localizaciones'] ?? [];
$id_almacen = $data['id_almacen'] ?? null;

// --- Verificación de ID del Almacén ---
if ($id_almacen === null) {
    debug_response('Error: El ID del almacén no fue recibido.', $data);
}

// Localizaciones seleccionadas
$idsLocalizacionesSeleccionadas = [];
$localizacionesSelected = $data['localizacionesSelected'] ?? []; 
if (is_array($localizacionesSelected)) {
    foreach ($localizacionesSelected as $loc) {
        if (isset($loc['id_localizacion_localizaciones'])) {
            $idsLocalizacionesSeleccionadas[] = (int) $loc['id_localizacion_localizaciones'];
        }
    }
}

// --------------------------------------------
// ✅ Información del almacén actual - CORRECCIÓN CLAVE
// --------------------------------------------
$almacenRaw = $data['Almacen'] ?? []; 
$almacenInfo = [];

// Si JS envía un objeto plano bajo 'Almacen', lo tomamos directamente.
// Si envía un array de 1 elemento, tomamos el primer elemento (lógica de fallback).
if (is_array($almacenRaw) && isset($almacenRaw[0])) {
    // Si es un array de 1 elemento, tomamos el primero
    $almacenInfo = $almacenRaw[0]; 
} else {
    // Si es el objeto plano, o no es un array, lo tomamos como está
    $almacenInfo = $almacenRaw; 
}


// AHORA DEBE FUNCIONAR: Acceso directo a las propiedades del objeto.
$codigo_sap = $almacenInfo['codigo_sap'] ?? '';
$descripcion_almacen_val = $almacenInfo['descripcion_almacen'] ?? ''; 

// ❌ VERIFICACIÓN CLAVE DE CONTENIDO
if (empty($codigo_sap) && !empty($almacenInfo)) {
    // Si $almacenInfo tiene contenido, pero no se extrajeron las claves, 
    // el nombre de la clave es incorrecto (ej: 'codigo_sap' vs 'cod_sap').
    // Si activa esta línea, verá la estructura REAL de $almacenInfo.
    // debug_response('Fallo al extraer Codigo/Descripcion. Revise la estructura de $almacenInfo.', ['almacenInfo' => $almacenInfo, 'datos_completos' => $data]);
}


// --------------------------------------------
// Clasificaciones (todas y seleccionadas)
// --------------------------------------------
$clasificaciones = $data['clasificaciones'] ?? []; 
$clasificacionesSelected = $data['clasificacionesSelected'] ?? []; 

$idsClasificacionesSeleccionadas = [];
if (is_array($clasificacionesSelected)) {
    foreach ($clasificacionesSelected as $c) {
        if (isset($c['id_clasificacion_almacenes_almacenes_clasificaciones_almacenes'])) {
            $idsClasificacionesSeleccionadas[] = (int)$c['id_clasificacion_almacenes_almacenes_clasificaciones_almacenes'];
        }
    }
}

// --------------------------------------------
// 💡 FUNCIÓN DE DEPURACIÓN (Opcional, desactivar en producción)
// --------------------------------------------
/*
$DEBUG_MODE = true; // CAMBIA a true para ver qué datos se están cargando
if ($DEBUG_MODE) {
    // Si activa esta línea, Fancybox mostrará el JSON de depuración.
    debug_response('DEBUG MODE ACTIVADO - Revise los datos recibidos', $data);
}
*/
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="../../../../../public/css/inventory/edit_almacenes.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../public/img/LogoBlanco.png" type="image/x-icon">

    <link rel="stylesheet" href="../../../../../public/css/utils/libs/libs.css">
    <link rel="stylesheet" href="../../../../../public/css/utils/estilos_spinner.css">
    
    <link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet">
    
</head>

<body class="p-4">
    <div class="contenido_edit_almacenes">
        <h5 class="mb-4">
            <i class="fa-solid fa-warehouse"></i> Editar Almacén
        </h5>

        <form id="formUpdateAlmacen">
            <input type="hidden" name="id_almacen" id="id_almacen" value="<?= htmlspecialchars($id_almacen) ?>">

            <div class="mb-4">
                <label for="codigo_sap" class="form-label">Código SAP: *</label>
                <input type="text" class="form-control" id="codigo_sap" name="codigo_sap"
                    value="<?= htmlspecialchars($codigo_sap) ?>">
            </div>

            <div class="mb-4">
                <label for="descripcion_almacen" class="form-label">Descripción del Almacén: *</label>
                <input type="text" class="form-control" id="descripcion_almacen" name="descripcion_almacen"
                    value="<?= htmlspecialchars($descripcion_almacen_val) ?>">
            </div>

            <div class="mb-4">
                <label for="localizaciones" class="form-label">
                    Seleccione las localizaciones para este almacén: *
                </label>

                <select id="localizaciones" class="form-control shadow-sm rounded" multiple name="localizaciones[]">
                    <?php foreach ($localizaciones as $l): ?>
                        <?php
                        $id = (int)($l['id_localizacion'] ?? 0);
                        $descripcion = $l['descripcion_localizacion'] ?? 'N/A';
                        $selected = in_array($id, $idsLocalizacionesSeleccionadas) ? 'selected' : '';
                        ?>
                        <option value="<?= htmlspecialchars($id) ?>" <?= $selected ?>>
                            <?= htmlspecialchars($descripcion) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <div class="form-text mt-1">Puedes buscar y seleccionar múltiples opciones.</div>
            </div>

            <div class="mb-4">
                <label for="clasificaciones_select" class="form-label">
                    Seleccione las clasificaciones para este almacén: *
                </label>

                <select id="clasificaciones_select" class="form-control shadow-sm rounded" multiple
                    name="clasificaciones_select[]">

                    <?php foreach ($clasificaciones as $clasificacion): ?>
                        <?php
                        $id = (int)($clasificacion['id_clasificacion_almacenes'] ?? 0);
                        $descripcion = $clasificacion['descripcion_clasificacion_almacenes'] ?? 'N/A';
                        $selected = in_array($id, $idsClasificacionesSeleccionadas) ? 'selected' : '';
                        ?>
                        <option value="<?= htmlspecialchars($id) ?>" <?= $selected ?>>
                            <?= htmlspecialchars($descripcion) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <div class="form-text mt-1">Puedes buscar y seleccionar múltiples opciones.</div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success px-4 shadow-sm" id="btn-aprobar-editar">
                    <i class="bi bi-check-circle me-1"></i>Actualizar
                </button>
            </div>
        </form>
    </div>

    <script src="../../../../../public/js/utils/libs/jquery.js"></script> 
    
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <script src="../../../../../public/js/utils/libs/bootstrap.js"></script>
    <script src="../../../../../public/js/utils/libs/fancybox.js"></script>
    <script src="../../../../../public/js/utils/libs/notification.js"></script>
    <script src="../../../../../public/js/utils/spinner.js"></script>
    <script src="../../../../../public/js/utils/notifications.js"></script>

    <script src="../../../../../public/js/inventory/edit_almacenes.js"></script>

</body>
</html>