<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Application\Service\BasesDatosSapService;
use App\Shared\Validation\Validator;

function onPostMigrationSap(string $idGrupo, string $id_administrador): array
{
    try {
        if (!isset($_FILES['mb52'], $_FILES['wm'], $_FILES['0016'])) {
            throw new Exception("Faltan uno o más archivos requeridos.");
        }

        $service = new BasesDatosSapService();
        // Llama al nuevo método del servicio que manejará la limpieza y el procesamiento
        $service->procesarArchivosExcel($_FILES['mb52'], $_FILES['wm'], $_FILES['0016'], $idGrupo, $id_administrador);

        return [
            'success' => true,
            'message' => 'Migración completada correctamente.'
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Error al migrar datos: ' . $e->getMessage()
        ];
    }
}

function onPostMigrationSapExactitud(string $id_administrador): array
{
    try {
        if (!isset($_FILES['lx03'])) {
            throw new Exception("El archivo es requerido para la migración");
        }

        $service = new BasesDatosSapService();
        // Llama al nuevo método del servicio que manejará la limpieza y el procesamiento
        $service->procesarArchivosExcelExactitud($_FILES['lx03'], $id_administrador);

        return [
            'success' => true,
            'message' => 'Migración completada correctamente.'
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Error al migrar datos: ' . $e->getMessage()
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
} catch (Exception $e) {
    $response = [
        'success' => false,
        'message' => "Un error interno ocurrió: " . $e->getMessage()
    ];
}

// ✅ Aquí va:
header('Content-Type: application/json; charset=utf-8');
echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit();
