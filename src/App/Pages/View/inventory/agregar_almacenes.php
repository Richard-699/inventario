<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../../public/css/inventory/agregar_almacenes.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../public/img/LogoBlanco.png" type="image/x-icon">

    <link rel="stylesheet" href="../../../../../public/css/utils/libs/libs.css">

    <link rel="stylesheet" href="../../../../../public/css/utils/estilos_spinner.css">
</head>

<body class="p-4">

    <?php
    if (isset($_GET['clasificaciones_almacenes'])) {
        $clasificacionesEncoded = $_GET['clasificaciones_almacenes'];
        $clasificacionesJson = urldecode($clasificacionesEncoded);
        $clasificaciones = json_decode($clasificacionesJson);

        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log('JSON Decode Error in agregar_localizaciones.php: ' . json_last_error_msg());
        }
    } else {
        $clasificaciones = [];
    }
    ?>

    <div class="contenido-agregar-almacen">
        <div class="p-3">
            <h5 class="mb-4"><i class="fa-solid fa-warehouse me-2 fs-4"></i>Nuevo Almacén</h5>
            <form id="formAgregarAlmacen">
                <div class="mb-3">
                    <label for="codigo_sap" class="form-label">Código SAP: *</label>
                    <input type="text" class="form-control" id="codigo_sap" name="codigo_sap">
                </div>
                <div class="mb-3">
                    <label for="descripcion_almacen" class="form-label">Descripción: *</label>
                    <input type="text" class="form-control" id="descripcion_almacen" name="descripcion_almacen">
                </div>

                <div class="mb-4">
                    <label for="clasificacion_almacen_select" class="form-label">
                        Clasificación Almacén: *
                    </label>

                    <select id="clasificacion_almacen_select"
                        class="form-control shadow-sm rounded"
                        multiple
                        name="clasificacion_almacen_select"
                        multiple>
                        <?php
                        foreach ($clasificaciones as $p):
                            $id_clasificacion = (int)$p->id_clasificacion_almacenes;
                        ?>
                            <option value="<?= htmlspecialchars($id_clasificacion) ?>">
                                <?= htmlspecialchars($p->descripcion_clasificacion_almacenes) ?>
                            </option>
                        <?php endforeach;
                        ?>
                    </select>
                    <div class="form-text mt-1">
                        Puedes buscar y seleccionar múltiples opciones.
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" id="btn-save">
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
    <script src="../../../../../public/js/inventory/guardar_almacenes.js"></script>
</body>

</html>