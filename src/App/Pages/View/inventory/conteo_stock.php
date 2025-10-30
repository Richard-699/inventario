<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';
session_start();
$id_administrador = $_SESSION['administrador']->id_administrador;
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
    <link href="../../../../../public/css/inventory/conteo_stock.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../public/img/LogoBlanco.png" type="image/x-icon">

    <link rel="stylesheet" href="../../../../../public/css/utils/libs/libs.css">

    <link rel="stylesheet" href="../../../../../public/css/utils/estilos_spinner.css">
</head>

<body class="p-4">

    <div class="contenido_conteo_stock">
        <h5 class="mb-4"><i class="fa-solid fa-calculator me-2 fs-4"></i>
            Conteo Stock
        </h5>
        <form id="formConteoStock">
            <input type="hidden" name="id_informacion_sap_mb52_stock" id="id_informacion_sap_mb52" value="<?= val('id_informacion_sap_mb52') ?>">
            <input type="hidden" name="id_partnumber_stock" id="id_part_number_informacion_sap_mb52" value="<?= val('id_part_number_informacion_sap_mb52') ?>">
            <input type="hidden" name="id_almacen_stock" id="id_almacen_informacion_sap_mb52" value="<?= val('id_almacen_informacion_sap_mb52') ?>">
            <input type="hidden" name="id_localizacion_stock" id="id_localizacion" value="<?= val('id_localizacion') ?>">
            <input type="hidden" name="id_grupo_stock" id="id_grupo" value="<?= val('id_grupo') ?>">
            <input type="hidden" name="id_administrador" id="id_administrador" value="<?= htmlspecialchars($id_administrador) ?>">
            <div class="mb-3">
                <label for="cantidad_stock" class="form-label">Cantidad Encontrada: *</label>
                <input type="text" class="form-control" name="cantidad_stock" id="cantidad_stock">
            </div>

            <div class="mb-3">
                <label for="observaciones" class="form-label">Observaciones (Opcional)</label>
                <textarea
                    class="form-control"
                    name="observaciones"
                    id="observaciones"
                    maxlength="500"
                    rows="4"></textarea>
                <small id="charCount" class="text-muted">0 / 500 caracteres</small>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success px-4 shadow-sm" id="btn-save">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Guardar
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
    <script src="../../../../../public/js/inventory/conteo_stock.js"></script>
</body>

</html>