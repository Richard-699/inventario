<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../../public/css/inventory/agregar_localizaciones.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../public/img/LogoBlanco.png" type="image/x-icon">

    <link rel="stylesheet" href="../../../../../public/css/utils/libs/libs.css">

    <link rel="stylesheet" href="../../../../../public/css/utils/estilos_spinner.css">
</head>

<body class="p-4">

    <?php
        if (isset($_GET['tipo_Localizaciones'])) {
            $tipoLocalizacionesEncoded = $_GET['tipo_Localizaciones'];
            $tipoLocalizacionesJson = urldecode($tipoLocalizacionesEncoded);
            $tiposLocalizaciones = json_decode($tipoLocalizacionesJson);

            if (json_last_error() !== JSON_ERROR_NONE) {
                error_log('JSON Decode Error in agregar_localizaciones.php: ' . json_last_error_msg());
            }
        } else {
            $tiposLocalizaciones = [];
        }
    ?>

    <div class="contenido-agregar-localizacion">
        <div class="p-3">
            <h5 class="mb-4"><i class="fa-solid fa-location-dot me-2 fs-4"></i>Nueva Localización</h5>
            <form id="formAgregarLocalizacion">
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Tipo Localización: *</label>
                    <select class="form-select" id="id_tipo_localizacion_localizaciones" name="id_tipo_localizacion_localizaciones">
                        <option value="">Seleccione un tipo</option>
                        <?php
                        if (!empty($tiposLocalizaciones)) {
                            foreach ($tiposLocalizaciones as $tipo) {
                                $id = $tipo->id_tipo_localizacion ?? '';
                                $descripcion = $tipo->descripcion_tipo_localizacion ?? 'N/A';
                                echo "<option value='{$id}'>{$descripcion}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción: *</label>
                    <input type="text" class="form-control" id="descripcion_localizacion" name="descripcion_localizacion">
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
    <script src="../../../../../public/js/inventory/guardar_localizaciones.js"></script>
</body>

</html>