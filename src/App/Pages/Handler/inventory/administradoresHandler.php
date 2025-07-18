<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Application\Service\AdministradoresService;
use App\Domain\DTO\AdministradoresDTO;
use App\Domain\Model\PermisosAdministradores;
use App\Infrastructure\Repository\AdministradoresRepository;
use App\Infrastructure\Repository\PermisosAdministradoresRepository;
use App\Infrastructure\Repository\PermisosRepository;
use App\Shared\Validation\Validator;

function onPostEditarPermisosAdministradores(array $data): array {
    $idUsuario = $data['id_usuario'] ?? null;
    $nombre = $data['nombre'] ?? null;
    $email = $data['email'] ?? null;

    if (empty($idUsuario) || !is_numeric($idUsuario)) {
        return [
            'status' => 'error',
            'message' => 'ID de usuario válido es requerido para editar.'
        ];
    }

    if (empty($nombre) && empty($email)) {
        return [
            'status' => 'error',
            'message' => 'Se requiere al menos un campo (nombre o email) para editar.'
        ];
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return [
            'status' => 'error',
            'message' => 'El email proporcionado no es válido.'
        ];
    }

    return [
        'status' => 'success',
        'message' => "Usuario ID '{$idUsuario}' actualizado con éxito.",
        'updated_fields' => array_filter(['nombre' => $nombre, 'email' => $email])
    ];
}

function onPostDeleteAdministrador(array $data){
    try {
        $id_administrador = $data['id'] ?? null;

        if ($id_administrador === null) {
            throw new Exception("Error al procesar el Id del administrador.");
        }

        $administradoresService = new AdministradoresService(
            new AdministradoresRepository(),
            new PermisosAdministradoresRepository(),
            new PermisosRepository()
        );

        $delete_administrador = $administradoresService->deleteAdministrador($id_administrador);

        if (!$delete_administrador) {
            throw new Exception("No se pudo eliminar el administrador.");
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

function onGetAdministradores() {
    try {
        $administradoresService = new AdministradoresService(
            new AdministradoresRepository(),
            new PermisosAdministradoresRepository(),
            new PermisosRepository()
        );

        $administradores = $administradoresService->onGetAdministradores();

        if ($administradores) {
            return $administradores;
        } else {
            throw new Exception("No se encontraron administradores.");
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

function onGetPermisos() {
    try {
        $administradoresService = new AdministradoresService(
            new AdministradoresRepository(),
            new PermisosAdministradoresRepository(),
            new PermisosRepository()
        );

        $permisos = $administradoresService->onGetPermisos();

        if ($permisos) {
            return $permisos;
        } else {
            throw new Exception("No se encontraron permisos.");
        }
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
            case 'edit_administrador':
                $response = onPostEditarPermisosAdministradores($data);
                break;
            case 'delete_administrador':
                $response = onPostDeleteAdministrador($data);
                break;
            default:
                throw new Exception("Acción no permitida.");
                break;
        }
    } elseif ($requestMethod === 'GET') {
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'onGet_administradores':
                $response = onGetAdministradores();
                break;
            case 'onGet_permisos':
                $response = onGetPermisos();
                break;
            /* case 'onGet_permisosAdministrador':
                $response = onGetPermisosAdministrador($_GET);
                break; */
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

?>