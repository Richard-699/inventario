<?php
// 1. FORZAR LA VISUALIZACIÓN DE ERRORES (Atrapará cualquier error fatal)
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Application\Service\BasesDatosSapService;
use App\Shared\Validation\Validator;

function onPostMigrationSap(string $idGrupo, string $id_administrador): array
{
    try {
        // 1. Validar solo los archivos estrictamente obligatorios (mb52 y wm)
        if (!isset($_FILES['mb52'], $_FILES['wm'])) {
            throw new Exception("Faltan los archivos requeridos (MB52 o WM).");
        }

        // 2. Validar si el archivo 0016 viene en la petición y si realmente se adjuntó
        $archivo0016 = null;
        if (isset($_FILES['0016']) && $_FILES['0016']['error'] !== UPLOAD_ERR_NO_FILE) {
            $archivo0016 = $_FILES['0016'];
        }

        $service = new BasesDatosSapService();
        // 3. Pasamos $archivo0016 (puede ser un array con el archivo o null)
        $service->procesarArchivosExcel($_FILES['mb52'], $_FILES['wm'], $archivo0016, $idGrupo, $id_administrador);

        return [
            'success' => true,
            'message' => 'Migración completada correctamente.'
        ];
    } catch (Throwable $e) { // <-- USAMOS THROWABLE PARA ATRAPAR ERRORES FATALES
        return [
            'success' => false,
            'message' => 'Error Crítico: ' . $e->getMessage() . ' | Archivo: ' . basename($e->getFile()) . ' | Línea: ' . $e->getLine()
        ];
    }
}

function onPostMigrationSapExactitud(string $id_administrador): array
{
    try {
        if (!isset($_FILES['lx03'])) {
            throw new Exception("El archivo es requerido para la migración");
        }
        $gruposSeleccionados = $_POST['grupos'] ?? [];
        $vacias = $_POST['vacias'] ?? null;

        if (!isset($vacias)) {
            throw new Exception("Especifique si solo desea migrar las ubicaciones vacias o no");
        }

        if (empty($gruposSeleccionados)) {
            throw new Exception("Debe seleccionar al menos un grupo para la migración.");
        }
        
        $service = new BasesDatosSapService();
        $service->procesarArchivosExcelExactitud($_FILES['lx03'], $id_administrador, $gruposSeleccionados, $vacias);

        return [
            'success' => true,
            'message' => 'Migración completada correctamente.'
        ];
    } catch (Throwable $e) { // <-- USAMOS THROWABLE AQUÍ TAMBIÉN
        return [
            'success' => false,
            'message' => 'Error Crítico: ' . $e->getMessage() . ' | Archivo: ' . basename($e->getFile()) . ' | Línea: ' . $e->getLine()
        ];
    }
}

$response = [];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? null;

        switch ($action) {
            case 'migration_bds_sap':
                $idGrupo = $_POST['id_grupo'] ?? null;
                $id_administrador = $_POST['id_administrador'] ?? null;
                $response = onPostMigrationSap($idGrupo, $id_administrador);
                break;
            case 'migration_bds_sap_exactitud':
                $id_administrador = $_POST['id_administrador'] ?? null;
                $response = onPostMigrationSapExactitud($id_administrador);
                break;
            default:
                throw new Exception("Acción no permitida.");
        }
    } else {
        throw new Exception("Método no permitido.");
    }
} catch (Throwable $e) { // <-- USAMOS THROWABLE EN EL BLOQUE PRINCIPAL
    $response = [
        'success' => false,
        'message' => "Un error interno ocurrió: " . $e->getMessage() . ' | Línea: ' . $e->getLine()
    ];
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit();