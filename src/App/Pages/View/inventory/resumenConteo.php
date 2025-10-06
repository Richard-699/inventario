<?php
function val($key)
{
    return htmlspecialchars($_GET[$key] ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../../public/css/inventory/resumen_conteo.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../public/img/LogoBlanco.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../../../public/css/utils/libs/libs.css">
    <link rel="stylesheet" href="../../../../../public/css/utils/estilos_spinner.css">
</head>

<body class="p-4">

    <div class="resumen_conteo">
        <h5 class="mb-4"><i class="fa-solid fa-calculator me-2 fs-4"></i>
            Resumen del conteo:
        </h5>
        <input type="hidden" name="id_grupo" id="id_grupo" value="<?= val('id_grupo') ?>">

        <table id="tablaDatos" class="table table-striped table-bordered">
            <thead>
                <tr class="table-primary">
                    <th>Part Number (MB52)</th>
                    <th>UMB</th>
                    <th>Almacen</th>
                    <th>Stock Total (MB52)</th>
                    <th>Localización</th>
                    <th>Stock (WM)</th>
                    <th>Entrada (WM)</th>
                    <th>Salida (WM)</th>
                    <th>Cantidad (STOCK)</th>
                    <th class="col-observaciones">Observaciones (STOCK)</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <?php include '../shared/footer.php'; ?>
    <script src="../../../../../public/js/utils/libs/jquery.js"></script>
    <script src="../../../../../public/js/utils/libs/bootstrap.js"></script>
    <script src="../../../../../public/js/utils/libs/fancybox.js"></script>
    <script src="../../../../../public/js/utils/libs/notification.js"></script>

    <script src="../../../../../public/js/utils/libs/select2.js"></script>
    <script src="../../../../../public/js/utils/spinner.js"></script>
    <script src="../../../../../public/js/utils/notifications.js"></script>
    <script src="../../../../../public/js/inventory/resumen_conteo.js"></script>
</body>

</html>