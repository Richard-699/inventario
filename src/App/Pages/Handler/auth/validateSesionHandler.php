<?php
// *****************************************************************
// ARCHIVO CRÍTICO: No debe tener salida ni código de depuración (echo, print_r, etc.)
// *****************************************************************

// 1. Incluimos el archivo central de sesiones
require_once __DIR__ . '/../../../Shared/Util/session_config.php';

// 2. Establecer variables por defecto (si no existen)
if (!isset($_SESSION['sidebarinactive'])) {
    $_SESSION['sidebarinactive'] = true;
}

// 3. Lógica de validación y redirección
if (!isset($_SESSION['administrador'])) {
    header('Location: /inventario/src/App/Pages/View/auth/login.php');
    exit;
}
// El script continuará si la sesión es válida.
?>