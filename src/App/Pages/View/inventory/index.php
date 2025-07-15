<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

session_start();

$permisos_administrador = $_SESSION['administrador']->permisosAdministradoresDTO;

foreach ($permisos_administrador as $permisoDTO) {
    echo $permisoDTO->id_permiso_permisos . "<br>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../../public/css/administrador/index.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/69c3b582a7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <title>Novedades Nómina</title>
    <link rel="shortcut icon" href="../../../../../public/img/LogoBlanco.png" type="image/x-icon">
</head>

<body>
   <!--  <?php include __DIR__ . '/../shared/header.php'; ?> -->

    <video id="backgroundVideo" muted loop playsinline class="background-video" preload="auto">
        <source src="../../../../VideoSmartCenter/Video Principal.mp4" type="video/mp4">
        Tu navegador no soporta el video.
    </video>
    <div class="overlay"></div>



    <!-- <?php include __DIR__ . '/../shared/footer.php'; ?> -->
    <script src="../../../public/js/administrador/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</body>

</html>