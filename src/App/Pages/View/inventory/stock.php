<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock</title>
    <link rel="shortcut icon" href="../../../../../public/img/LogoBlanco.png" type="image/x-icon">

    <link rel="stylesheet" href="../../../../../public/css/utils/libs/libs.css">
    <link rel="stylesheet" href="../../../../../public/css/utils/estilos_spinner.css">
    <link rel="stylesheet" href="../../../../../public/css/dataTable/dataTable.css">
    <link rel="stylesheet" href="../../../../../public/css/inventory/stock.css">

    <?php include('../../../Shared/Util/spinner.php'); ?>
</head>

<body>
    <?php include('../shared/header.php'); ?>

    <div class="container-fluid px-2 py-3">
        <div class="table-container table-responsive">
            <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-2">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-boxes-packing me-2 fs-4"></i>
                    <h5 class="m-0 fw-semibold text-dark">Stock</h5>
                </div>
<!--                 <button class="btn btn-primary btn-sm" id="btnFinalizarConteo">
                    <i class="fa-solid fa-floppy-disk me-1"></i> Guardar y Finalizar Conteo
                </button>
                <button class="btn btn-primary btn-sm" id="btnFinalizarConteo">
                    <i class="fa-solid fa-floppy-disk me-1"></i> Actualizar
                </button> -->
            </div>

            <table id="tabla-stock" class="table table-striped table-bordered table-sm dt-responsive nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <!-- <th style="width: 5%;">Id</th> -->
                        <th style="width: 18%;">Tipo Localización</th>
                        <th style="width: 18%;">Localización</th>
                        <th style="width: 17%;">Tipo Almacenamiento</th>
                        <th style="width: 18%;">Cantidad Registrada</th>
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
    <script src="../../../../../public/js/inventory/stock.js"></script>

</html>