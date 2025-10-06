<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';
session_start();
$id_administrador = $_SESSION['administrador']->id_administrador;
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
        <h5><i class="fa-solid fa-file-excel me-2 fs-4"></i>
            Importar Base de datos SAP - Exactitud
        </h5>
        <form id="formBdsSapExactitud" enctype="multipart/form-data">
            <input type="hidden" class="form-control" name="id_administrador" id="id_administrador" value="<?= htmlspecialchars($id_administrador) ?>">

            <div class="mb-4 mt-5">
                <label for="" class="form-label">LX03: *</label>
                <input type="file" accept=".xlsx, .xls" class="form-control" id="" name="lx03">
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success px-4 shadow-sm" id="btn-cargar-bds">
                    <i class="bi bi-check-circle me-1"></i>Cargar
                </button>
            </div>
        </form>
    </div>

    <?php '../shared/footer.php'; ?>
    <!-- Scripts en orden -->
    <script src="../../../../../public/js/utils/libs/jquery.js"></script>
    <script src="../../../../../public/js/utils/libs/bootstrap.js"></script>
    <script src="../../../../../public/js/utils/libs/fancybox.js"></script>
    <script src="../../../../../public/js/utils/libs/notification.js"></script>


    <!-- Scripts funcionalidades -->
    <script src="../../../../../public/js/utils/libs/select2.js"></script>
    <script src="../../../../../public/js/utils/spinner.js"></script>
    <script src="../../../../../public/js/utils/notifications.js"></script>
    <script src="../../../../../public/js/inventory/bases_datos_sap_exactitud.js"></script>
</body>

</html>