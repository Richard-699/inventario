<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Localizaciones</title>
    <link rel="shortcut icon" href="../../../../../public/img/LogoBlanco.png" type="image/x-icon">

    <link rel="stylesheet" href="../../../../../public/css/utils/libs/libs.css">
    <link rel="stylesheet" href="../../../../../public/css/utils/estilos_spinner.css">
    <link rel="stylesheet" href="../../../../../public/css/dataTable/dataTable.css">
    <link rel="stylesheet" href="../../../../../public/css/inventory/localizaciones.css">

    <?php include('../../../Shared/Util/spinner.php'); ?>
</head>

<body>
    <?php include('../shared/header.php'); ?>

    <div class="container-fluid px-2 py-3">
        <div class="table-container table-responsive">
            <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-2">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-location-dot me-2 fs-4"></i>
                    <h5 class="m-0 fw-semibold text-dark">Localizaciones</h5>
                </div>
                <button class="btn btn-primary btn-sm" id="btnAgregarLocalizacion">
                    <i class="fa fa-plus me-1"></i> Agregar Localizaciones
                </button>
            </div>

            <table id="tabla-administradores" class="table table-striped table-bordered table-sm dt-responsive nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%;">Id</th>
                        <th style="width: 18%;">Tipo</th>
                        <th style="width: 18%;">Descripción</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <?php include('../shared/footer.php'); ?>
    <!-- Scripts en orden -->
    <script src="../../../../../public/js/utils/libs/jquery.js"></script>
    <script src="../../../../../public/js/utils/libs/bootstrap.js"></script>
    <script src="../../../../../public/js/utils/libs/datatables.js"></script>
    <script src="../../../../../public/js/utils/libs/fancybox.js"></script>
    <script src="../../../../../public/js/utils/libs/notification.js"></script>

    <!-- Scripts funcionalidades -->
    <script src="../../../../../public/js/utils/spinner.js"></script>
    <script src="../../../../../public/js/utils/notifications.js"></script>
    <script src="../../../../../public/js/inventory/localizaciones.js"></script>

</html>