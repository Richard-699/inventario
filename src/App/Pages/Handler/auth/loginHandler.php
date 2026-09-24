<?php

require_once __DIR__ . '/../../../../../vendor/autoload.php';
// 1. Incluimos el archivo central de sesiones (4 niveles arriba hasta src)
require_once __DIR__ . '/../../../Shared/Util/session_config.php';

use App\Application\Service\LoginService;
use App\Domain\DTO\AdministradoresDTO;
use App\Shared\Validation\Validator;

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405); 
        throw new Exception('Método no permitido');
    }

    $administradoresDTO = new AdministradoresDTO(
        id_administrador: null,
        cedula_administrador: null,
        nombre_administrador: null,
        apellidos_administrador: null,
        correo_hwi_administrador: $_POST['correo_hwi_administrador'] ?? '',
        password_administrador: $_POST['password_administrador'] ?? '',
        password_is_temporal: null,
        estado_administrador: null,
        type: 'login'
    );

    Validator::validateDTO($administradoresDTO);

    $loginService = new LoginService();
    $administradorLogin = $loginService->login($administradoresDTO);

    $approved = false;
    $is_temporal = false;

    // --- 3. Procesar el resultado del Login ---
    if($administradorLogin){
        
        if($administradorLogin->permisosAdministradoresDTO === null){
            throw new Exception("No tiene permisos en el sistema.");
        }
        
        if($administradorLogin->password_is_temporal == 1){
            $is_temporal = true;
        }
        
        if($administradorLogin->estado_administrador == 1){
            $approved = true;
        }
        
        // La sesión ya fue iniciada por session_config.php, solo asignamos los datos
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION['administrador'] = $administradorLogin;
            $_SESSION['sidebarinactive'] = true;

            // Log opcional (dejándolo en la raíz del proyecto para que no falle la ruta)
            $logPath = dirname(__DIR__, 5) . '/session_test.log';
            @file_put_contents($logPath, 
                "[" . date('Y-m-d H:i:s') . "] Sesión iniciada correctamente en Login. ID: " . session_id() . "\n", 
                FILE_APPEND
            );
        } else {
            $logPath = dirname(__DIR__, 5) . '/session_test.log';
            @file_put_contents($logPath, 
                "[" . date('Y-m-d H:i:s') . "] Falló el inicio de sesión en Login.\n", 
                FILE_APPEND
            );
        }

    }else{
        throw new Exception("El administrador no se encontró");
    }
    
    // --- 4. Respuesta de Éxito ---
    echo json_encode([
        'success' => true,
        'approved' => $approved,
        'is_temporal' => $is_temporal
    ]);

} catch (Exception $e) {
    http_response_code(401); 
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}