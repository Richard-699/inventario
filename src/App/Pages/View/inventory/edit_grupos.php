<?php
$partnumbersSeleccionados = json_decode($_GET['partnumbersSeleccionados'] ?? '[]', true);
$partnumbersSinAsignacion = json_decode($_GET['partnumbersSinAsignacion'] ?? '[]', true);

$allPartnumbersForSelect = array_merge($partnumbersSeleccionados, $partnumbersSinAsignacion);

$idsPartnumbersSelected = [];
foreach ($partnumbersSeleccionados as $p_selected) {
    if (isset($p_selected['id_partnumber'])) {
        $idsPartnumbersSelected[] = (int)$p_selected['id_partnumber'];
    }
}

$grupoInfo = [];
if (isset($_GET['infoGrupo'])) {
    $grupoInfo = json_decode($_GET['infoGrupo'], true);
}
$descripcion_grupo = $grupoInfo['descripcion_grupo'] ?? '';

?>
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
        <h5 class="mb-4"><i class="fa-solid fa-layer-group me-2 fs-4"></i>
            Editar Grupo
        </h5>
        <form id="formUpdateGrupo">
            <input type="hidden" name="id_grupo" id="id_grupo" value="<?= htmlspecialchars($id_grupo) ?>">

            <div class="mb-4">
                <label for="descripcion_grupo" class="form-label">Descrición o nombre: *</label>
                <input type="text" class="form-control" id="descripcion_grupo" name="descripcion_grupo" value="<?= htmlspecialchars($descripcion_grupo) ?>">
            </div>
            <div class="mb-4">
                <label for="part_numbers_select" class="form-label">
                    Seleccione los part numbers para este grupo: *
                </label>

                <select id="part_numbers_select"
                    class="form-control shadow-sm rounded"
                    multiple
                    name="part_numbers_select"
                    multiple>
                    <?php
                    foreach ($allPartnumbersForSelect as $p):
                        $id_partnumber = (int)$p['id_partnumber'];
                        $isSelected = in_array($id_partnumber, $idsPartnumbersSelected);
                    ?>
                        <option value="<?= htmlspecialchars($partnumberId) ?>"
                            <?= $isSelected ? 'selected' : '' ?>>
                            <?= htmlspecialchars($p['partnumber']) . " - " . htmlspecialchars($p['descripcion_breve']) ?>
                        </option>
                    <?php endforeach;
                    ?>
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
    <script src="../../../../../public/js/inventory/edit_grupos.js"></script>
</body>

</html>