<?php
// =========================================================================
// ARCHIVO CENTRAL DE SESIONES
// Ruta: src/Shared/Util/session_config.php
// =========================================================================

// Subimos 3 niveles desde Util para llegar a la raíz (inventario)
// 1: Shared | 2: src | 3: inventario
$projectRoot = dirname(__DIR__, 4); 

// Ruta absoluta a la carpeta 'sessions' (la misma que vimos en la imagen)
$sessionPath = $projectRoot . '/sessions';

// Crear la carpeta de sesiones si por alguna razón no existe
if (!file_exists($sessionPath)) {
    @mkdir($sessionPath, 0700, true);
}

// Configurar PHP para que SIEMPRE guarde y lea las sesiones desde aquí
ini_set('session.save_path', $sessionPath);

// Iniciar la sesión de forma segura si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>