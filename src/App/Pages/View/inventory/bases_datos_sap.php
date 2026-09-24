<?php
// 1. Cargar Composer (Subimos 5 niveles hasta la raíz 'inventario')
require_once dirname(__DIR__, 5) . '/vendor/autoload.php';

// 2. Cargar Configuración de Sesión (Subimos 3 niveles hasta 'App' y entramos a Shared)
require_once dirname(__DIR__, 3) . '/Shared/Util/session_config.php'; 

// 3. Obtener el ID del administrador
$id_administrador = $_SESSION['administrador']->id_administrador ?? null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../../public/css/inventory/bases_datos_sap.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../public/img/LogoBlanco.png" type="image/x-icon">

    <link rel="stylesheet" href="../../../../../public/css/utils/libs/libs.css">
    <link rel="stylesheet" href="../../../../../public/css/utils/estilos_spinner.css">
    <?php
    $id_grupo = $_GET['id_grupo'] ?? null;
    ?>
</head>

<body class="p-4">
    <div class="contenido_bases_sap">
        <h5 class="mb-4"><i class="fa-solid fa-file-excel me-2 fs-4"></i>
            Importar Bases de Datos SAP
        </h5>
        <form id="formBdsSap" enctype="multipart/form-data">
            <input type="hidden" class="form-control" name="id_grupo" id="id_grupo" value="<?= htmlspecialchars($id_grupo) ?>">
            <input type="hidden" class="form-control" name="id_administrador" id="id_administrador" value="<?= htmlspecialchars($id_administrador) ?>">

            <div class="mb-4">
                <label for="" class="form-label">MB-52: *</label>
                <input type="file" accept=".xlsx, .xls" class="form-control" id="" name="mb52">
            </div>

            <div class="mb-4">
                <label for="" class="form-label">WM: *</label>
                <input type="file" accept=".xlsx, .xls" class="form-control" id="" name="wm">
            </div>

            <div class="mb-4">
                <label for="" class="form-label">0016: </label>
                <input type="file" accept=".xlsx, .xls" class="form-control" id="" name="0016">
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success px-4 shadow-sm" id="btn-cargar-bds">
                    <i class="bi bi-check-circle me-1"></i>Cargar
                </button>
            </div>
        </form>
    </div>

    <?php include '../shared/footer.php'; ?>
    
    <script src="../../../../../public/js/utils/libs/jquery.js"></script>
    <script src="../../../../../public/js/utils/libs/bootstrap.js"></script>
    <script src="../../../../../public/js/utils/libs/fancybox.js"></script>
    <script src="../../../../../public/js/utils/libs/notification.js"></script>

    <script src="../../../../../public/js/utils/libs/select2.js"></script>
    <script src="../../../../../public/js/utils/spinner.js"></script>
    <script src="../../../../../public/js/utils/notifications.js"></script>
    <script src="../../../../../public/js/inventory/bases_datos_sap.js?v=999"></script>
</body>
</html>