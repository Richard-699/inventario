<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../../public/css/inventory/agregar_partnumbers.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../public/img/LogoBlanco.png" type="image/x-icon">

    <link rel="stylesheet" href="../../../../../public/css/utils/libs/libs.css">

    <link rel="stylesheet" href="../../../../../public/css/utils/estilos_spinner.css">
</head>

<body class="p-4">

    <?php
        if (isset($_GET['umbs'])) {
            $umbsEncoded = $_GET['umbs'];
            $umbsJson = urldecode($umbsEncoded);
            $umbs = json_decode($umbsJson);

            if (json_last_error() !== JSON_ERROR_NONE) {
                error_log('JSON Decode Error in agregar_partnumbers.php: ' . json_last_error_msg());
            }
        } else {
            $umbs = [];
        }
    ?>

    <div class="contenido-agregar-partnumbers">
        <div class="p-3">
            <h5 class="mb-4"><i class="fa-solid fa-dolly me-2 fs-4"></i>Agregar PartNumbers</h5>
            <form id="formAgregarPartnumbers">
                <div class="mb-3">
                    <label for="partnumber" class="form-label">PartNumber: *</label>
                    <input type="text" class="form-control" id="partnumber" name="partnumber">
                </div>
                <div class="mb-3">
                    <label for="descripcion_breve" class="form-label">Texto breve de material SAP: *</label>
                    <input type="text" class="form-control" id="descripcion_breve" name="descripcion_breve">
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">UMB: *</label>
                    <select class="form-select" id="id_tipo_localizacion_localizaciones" name="id_tipo_localizacion_localizaciones">
                        <option value="">Seleccione un tipo</option>
                        <?php
                        if (!empty($umbs)) {
                            foreach ($umbs as $umb) {
                                $id = $umb->id_umb ?? '';
                                $descripcion = $umb->descripcion_umb ?? 'N/A';
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