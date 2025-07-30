<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../../public/css/inventory/agregar_grupos.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../public/img/LogoBlanco.png" type="image/x-icon">

    <link rel="stylesheet" href="../../../../../public/css/utils/libs/libs.css">

    <link rel="stylesheet" href="../../../../../public/css/utils/estilos_spinner.css">
</head>

<body class="p-4">

    <div class="contenido-agregar-grupo">
        <div class="p-3">
            <h5 class="mb-4"><i class="fa-solid fa-layer-group me-2 fs-4"></i></i>Nuevo Grupo</h5>
            <form id="formAgregarGrupo">
                <div class="mb-3">
                    <label for="descripcion_grupo" class="form-label">Nombre o Descripción: *</label>
                    <input type="text" class="form-control" id="descripcion_grupo" name="descripcion_grupo">
                </div>

                <div class="mb-3">
                    <label for="fecha_programacion_grupo" class="form-label">Mes de conteo: *</label>
                    <input type="month" class="form-control" id="fecha_programacion_grupo" name="fecha_programacion_grupo">
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save me-1"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
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
    <script src="../../../../../public/js/inventory/guardar_grupo.js"></script>
</body>

</html>