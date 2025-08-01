<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../../public/css/inventory/edit_grupos.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../public/img/LogoBlanco.png" type="image/x-icon">

    <link rel="stylesheet" href="../../../../../public/css/utils/libs/libs.css">

    <link rel="stylesheet" href="../../../../../public/css/utils/estilos_spinner.css">
</head>

<body class="p-4">

    <div class="contenido_edit_grupos">
        <h5 class="mb-4"><i class="fa-solid fa-file-excel me-2 fs-4"></i>
            Adjuntar Bases de Datos SAP
        </h5>
        <form id="formUpdateGrupo">

            <div class="mb-4">
                <label for="" class="form-label">MB-52: *</label>
                <input type="file" accept=".xlsx, .xls" class="form-control" id="" name="">
            </div>

            <div class="mb-4">
                <label for="" class="form-label">WM: *</label>
                <input type="file" accept=".xlsx, .xls" class="form-control" id="" name="">
            </div>

            <div class="mb-4">
                <label for="" class="form-label">0016: *</label>
                <input type="file" accept=".xlsx, .xls" class="form-control" id="" name="">
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success px-4 shadow-sm" id="btn-aprobar-editar">
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
    <script src="../../../../../public/js/inventory/edit_grupos.js"></script>
</body>

</html>