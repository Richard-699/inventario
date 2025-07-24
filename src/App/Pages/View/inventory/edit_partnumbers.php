<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../../public/css/inventory/edit_partnumbers.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../public/img/LogoBlanco.png" type="image/x-icon">

    <link rel="stylesheet" href="../../../../../public/css/utils/libs/libs.css">

    <link rel="stylesheet" href="../../../../../public/css/utils/estilos_spinner.css">
</head>

<body class="p-4">
    <?php

    $umbs = [];

    if (isset($_GET['umbs'])) {
        $umbsJson = $_GET['umbs'];
        $umbsDecoded = json_decode($umbsJson);

        if (json_last_error() === JSON_ERROR_NONE && is_array($umbsDecoded)) {
            $umbs = $umbsDecoded;
        } else {
            error_log('Error decodificando umbs');
        }
    }

    $plataformas = [];

    if (isset($_GET['plataformas'])) {
        $plataformasJson = $_GET['plataformas'];
        $plataformasDecoded = json_decode($plataformasJson);

        if (json_last_error() === JSON_ERROR_NONE && is_array($plataformasDecoded)) {
            $plataformas = $plataformasDecoded;
        } else {
            error_log('Error decodificando umbs');
        }
    }

    $partnumberSelectedJson = $_GET['partnumberSelected'] ?? null;
    $partnumberSelected = [];

    if ($partnumberSelectedJson) {
        $partnumberSelectedDecoded = json_decode($partnumberSelectedJson);

        if (json_last_error() === JSON_ERROR_NONE && is_object($partnumberSelectedDecoded)) {
            $partnumberSelected = $partnumberSelectedDecoded;
        } else {
            error_log('Error decodificando partnumberSelectedSelected');
        }
    }

    $id_partnumber = $_GET['id'] ?? null;
    ?>
    <div class="contenido_edit_partnumbers">
        <h5 class="mb-4"><i class="fa-solid fa-dolly"></i>
            Editar PartNumber
        </h5>
        <form id="formUpdatePartNumbers" class="mt-5">
            <input type="hidden" name="id_partnumber" id="id_partnumber" value="<?= htmlspecialchars($id_partnumber) ?>">
            <input type="hidden" name="id_grupo_partnumber" id="id_grupo_partnumber" value="<?= htmlspecialchars($partnumberSelected->id_grupo_partnumber) ?>">
            <div class="mb-3">
                <label for="partnumber" class="form-label">PartNumber: *</label>
                <input type="text" class="form-control" id="partnumber" name="partnumber"
                    value="<?= htmlspecialchars($partnumberSelected->partnumber ?? '') ?>">
            </div>
            <div class="mb-3">
                <label for="descripcion_breve" class="form-label">Texto breve de material SAP: *</label>
                <input type="text" class="form-control" id="descripcion_breve" name="descripcion_breve"
                    value="<?= htmlspecialchars($partnumberSelected->descripcion_breve ?? '') ?>">
            </div>
            <div class="mb-3">
                <label for="id_umb_partnumber" class="form-label">UMB: *</label>
                <select class="form-select" id="id_umb_partnumber" name="id_umb_partnumber">
                    <option value="">Seleccione una UMB</option>
                    <?php
                    if (!empty($umbs)) {
                        $selectedId = $partnumberSelected->id_umb_partnumber ?? '';

                        foreach ($umbs as $umb) {
                            $id = $umb->id_umb ?? '';
                            $descripcion = $umb->descripcion_umb ?? 'N/A';
                            $selected = ($selectedId == $id) ? 'selected' : '';
                            echo "<option value='{$id}' {$selected}>{$descripcion}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="nombre_interno" class="form-label">Nombre Interno: *</label>
                <input type="text" class="form-control" id="nombre_interno" name="nombre_interno"
                    value="<?= htmlspecialchars($partnumberSelected->nombre_interno ?? '') ?>">
            </div>
            <div class="mb-3">
                <label for="id_plataforma_partnumber" class="form-label">Plataforma: *</label>
                <select class="form-select" id="id_plataforma_partnumber" name="id_plataforma_partnumber">
                    <option value="">Seleccione una plataforma</option>
                    <?php
                    if (!empty($plataformas)) {
                        $selectedId = $partnumberSelected->id_plataforma_partnumber ?? '';

                        foreach ($plataformas as $plataforma) {
                            $id = $plataforma->id_plataforma ?? '';
                            $descripcion = $plataforma->descripcion_plataforma ?? 'N/A';
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
    <script src="../../../../../public/js/inventory/edit_partnumbers.js"></script>
</body>

</html>