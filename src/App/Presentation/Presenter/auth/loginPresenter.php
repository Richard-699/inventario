<?php

require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Application\Service\LoginService;
use App\Domain\DTO\AdministradoresDTO;
use App\Infrastructure\Repository\AdministradoresRepository;

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode([
            'estado' => 'error',
            'mensaje' => 'Método no permitido'
        ]);
        exit;
    }

    $correo = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($correo) || empty($password)) {
        http_response_code(400);
        echo json_encode([
            'estado' => 'error',
            'mensaje' => 'Debes ingresar tu correo y contraseña'
        ]);
        exit;
    }

    $administradoresDTO = new AdministradoresDTO(
        id_administrador: null,
        cedula_administrador: null,
        nombre_administrador: null,
        apellidos_administrador: null,
        correo_hwi_administrador: $correo,
        password_administrador: $password,
        password_is_temporal: null,
        estado_administrador: null
    );

    $loginService = new LoginService(new AdministradoresRepository());
    $administradorLogin = $loginService->login($administradoresDTO);

    if($administradorLogin->estado_administrador == 1){
        $approved = true;
    }else{
        $approved = false;
    }

    if($administradorLogin->password_is_temporal == 1){
        $is_temporal = true;
    }else{
        $is_temporal = false;
    }
    
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
