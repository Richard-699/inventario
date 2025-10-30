<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../../public/css/inventory/edit_localizaciones.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../public/img/LogoBlanco.png" type="image/x-icon">

    <link rel="stylesheet" href="../../../../../public/css/utils/libs/libs.css">

    <link rel="stylesheet" href="../../../../../public/css/utils/estilos_spinner.css">
</head>

<body class="p-4">
    <?php

    $tiposLocalizaciones = [];

    if (isset($_GET['tipo_localizaciones'])) {
        $tipoLocalizacionesJson = $_GET['tipo_localizaciones'];
        $tiposLocalizacionesDecoded = json_decode($tipoLocalizacionesJson);

        if (json_last_error() === JSON_ERROR_NONE && is_array($tiposLocalizacionesDecoded)) {
            $tiposLocalizaciones = $tiposLocalizacionesDecoded;
        } else {
            error_log('Error decodificando tipo_localizaciones');
        }
    }
    $localizacionSelectedJson = $_GET['localizacionSelected'] ?? null;
    $localizacionSelected = [];

    if ($localizacionSelectedJson) {
        $localizacionSelectedDecoded = json_decode($localizacionSelectedJson);

        if (json_last_error() === JSON_ERROR_NONE && is_object($localizacionSelectedDecoded)) {
            $localizacionSelected = $localizacionSelectedDecoded;
        } else {
            error_log('Error decodificando localizacionSelected');
        }
    }

    $tipoAlmacenamiento = [];

    if (isset($_GET['tipo_almacenamiento'])) {
        $tipoAlmacenamientoJson = $_GET['tipo_almacenamiento'];
        $tipoAlmacenamientoDecoded = json_decode($tipoAlmacenamientoJson);

        if (json_last_error() === JSON_ERROR_NONE && is_array($tipoAlmacenamientoDecoded)) {
            $tipoAlmacenamiento = $tipoAlmacenamientoDecoded;
        } else {
            error_log('Error decodificando tipo_localizaciones');
        }
    }


    $id_localizacion = $_GET['id'] ?? null;
    ?>
    <div class="contenido_edit_localizaciones">
        <h5 class="mb-4"><i class="fa-solid fa-location-dot"></i>
            Editar Localización
        </h5>
        <form id="formUpdateLocalizaciones">
            <input type="hidden" name="id_localizacion" id="id_localizacion" value="<?= htmlspecialchars($id_localizacion) ?>">

            <div class="mb-3">
                <label for="id_tipo_localizacion_localizaciones" class="form-label">Tipo Localización: *</label>
                <select class="form-select" id="id_tipo_localizacion_localizaciones" name="id_tipo_localizacion_localizaciones">
                    <option value="">Seleccione un tipo</option>
                    <?php
                    if (!empty($tiposLocalizaciones)) {
                        $selectedId = $localizacionSelected->id_tipo_localizacion_localizaciones ?? '';

                        foreach ($tiposLocalizaciones as $tipo) {
                            $id = $tipo->id_tipo_localizacion ?? '';
                            $descripcion = $tipo->descripcion_tipo_localizacion ?? 'N/A';
                            $selected = ($selectedId == $id) ? 'selected' : '';
                            echo "<option value='{$id}' {$selected}>{$descripcion}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción: *</label>
                <input type="text" class="form-control" id="descripcion_localizacion" name="descripcion_localizacion"
                    value="<?= htmlspecialchars($localizacionSelected->descripcion_localizacion ?? '') ?>">
            </div>

            <div class="mb-3">
                <label for="id_tipo_almacenamiento" class="form-label">Tipo Almacenamiento: *</label>
                <select class="form-select" id="id_tipo_almacenamiento" name="id_tipo_almacenamiento">
                    <option value="">Seleccione un tipo</option>
                    <?php
                    if (!empty($tipoAlmacenamiento)) {
                        $selectedId = $localizacionSelected->id_tipo_almacenamientos_localizaciones ?? '';

                        foreach ($tipoAlmacenamiento as $tipo) {
                            $id = $tipo->id_tipo_almacenamiento ?? '';
                            $descripcion = $tipo->descripcion_tipo_almacenamiento ?? 'N/A';
                            $selected = ($selectedId == $id) ? 'selected' : '';
                            echo "<option value='{$id}' {$selected}>{$descripcion}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" id="btn-editar">
                    <i class="bi bi-check-circle me-1"></i>Actualizar
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
    <script src="../../../../../public/js/inventory/edit_localizaciones.js"></script>
</body>

</html>