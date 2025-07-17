<?php
session_start();
if (!isset($_SESSION['sidebarinactive'])) {
    $_SESSION['sidebarinactive'] = true;
}
define('SESSION_TIMEOUT', 1800);

if (!isset($_SESSION['administrador'])) {
    header('Location: /inventario/src/App/Pages/Views/auth/login.php');
    exit;
}

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
    session_unset();
    session_destroy();
    header('Location: /inventario/src/App/Pages/Views/auth/login.php?session_expired=true');
    exit;
}

$_SESSION['last_activity'] = time();

?>