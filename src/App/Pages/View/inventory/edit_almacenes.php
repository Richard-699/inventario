<?php
$localizaciones = json_decode($_GET['localizaciones'], true);
$id_almacen = $_GET['id_almacen'] ?? null;
$idsLocalizacionesSeleccionadas = [];

if (isset($_GET['localizacionesSelected'])) {
    $localizacionesSelected = json_decode($_GET['localizacionesSelected'], true);

    foreach ($localizacionesSelected as $loc_select) {
        if (isset($loc_select['id_localizacion_localizaciones'])) {
            $idsLocalizacionesSeleccionadas[] = (int)$loc_select['id_localizacion_localizaciones'];
        }
    }
}

$almacenInfo = [];
if (isset($_GET['Almacen'])) {
    $almacenInfo = json_decode($_GET['Almacen'], true);
}
$codigo_sap = $almacenInfo['codigo_sap'] ?? '';
$descripcion_almacen_val = $almacenInfo['descripcion_almacen'] ?? '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../../public/css/inventory/edit_almacenes.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../public/img/LogoBlanco.png" type="image/x-icon">

    <link rel="stylesheet" href="../../../../../public/css/utils/libs/libs.css">

    <link rel="stylesheet" href="../../../../../public/css/utils/estilos_spinner.css">
</head>

<body class="p-4">

    <div class="contenido_edit_almacenes">
        <h5 class="mb-4"><i class="fa-solid fa-warehouse"></i>
            Editar Almacén
        </h5>
        <form id="formUpdateAlmacen">
            <input type="hidden" name="id_almacen" id="id_almacen" value="<?= htmlspecialchars($id_almacen) ?>">

            <div class="mb-4">
                <label for="codigo_sap" class="form-label">Código SAP: *</label>
                <input type="text" class="form-control" id="codigo_sap" name="codigo_sap" value="<?= htmlspecialchars($codigo_sap) ?>">
            </div>

            <div class="mb-4">
                <label for="descripcion_almacen" class="form-label">Descripción del Almacén: *</label>
                <input type="text" class="form-control" id="descripcion_almacen" name="descripcion_almacen" value="<?= htmlspecialchars($descripcion_almacen_val ?? '') ?>">
            </div>

            <div class="mb-4">
                <label for="permisos_administradores" class="form-label">
                    Seleccione las localizaciones para este almacén: *
                </label>

                <select id="localizaciones"
                    class="form-control shadow-sm rounded"
                    multiple
                    name="localizaciones"
                    multiple>
                    <?php foreach ($localizaciones as $l): ?>
                        <option value="<?= htmlspecialchars($l['id_localizacion']) ?>"
                            <?= (in_array((int)$l['id_localizacion'], $idsLocalizacionesSeleccionadas)) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($l['descripcion_localizacion']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="form-text mt-1">
                    Puedes buscar y seleccionar múltiples opciones.
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success px-4 shadow-sm" id="btn-aprobar-editar">
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
    <script src="../../../../../public/js/inventory/edit_almacenes.js"></script>
</body>

</html>