<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Application\Service\BasesDatosSapService;
use App\Shared\Validation\Validator;

function onPostMigrationSap(): array
{
    try {
        if (!isset($_FILES['mb52'], $_FILES['wm'], $_FILES['0016'])) {
            throw new Exception("Faltan uno o más archivos requeridos.");
        }

        $service = new BasesDatosSapService();
        $service->procesarArchivosExcel($_FILES['mb52'], $_FILES['wm'], $_FILES['0016']);

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

// --- Lógica principal ---
$response = [];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? null;

        switch ($action) {
            case 'migration_bds_sap':
                $response = onPostMigrationSap();
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