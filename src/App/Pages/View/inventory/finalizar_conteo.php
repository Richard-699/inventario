<?php
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
    <link href="../../../../../public/css/inventory/finalizar_conteo.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../public/img/LogoBlanco.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../../../public/css/utils/libs/libs.css">
    <link rel="stylesheet" href="../../../../../public/css/utils/estilos_spinner.css">
</head>

<body class="p-4">

    <div class="finalizar_conteo_stock">
        <h5 class="mb-4"><i class="fa-solid fa-calculator me-2 fs-4"></i>
            Finalizar Conteo
        </h5>
        <form id="form_finalizar_conteo_stock">
            <input type="hidden" name="id_grupo" id="id_grupo" value="<?= val('id_grupo') ?>">
            <input type="hidden" name="id_estado_cronograma" id="id_estado_cronograma">

            <div class="mb-3" id="seccion_reconteo">
                <label class="form-label" id="label-reconteo">¿Desea hacer otro conteo de este grupo?</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="otro_conteo" id="otroConteoSi" value="si">
                        <label class="form-check-label" for="otroConteoSi">Sí</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="otro_conteo" id="otroConteoNo" value="no">
                        <label class="form-check-label" for="otroConteoNo">No</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="observaciones" class="form-label">Observaciones (Opcional):</label>
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

    <?php include '../shared/footer.php'; ?>
    <script src="../../../../../public/js/utils/libs/jquery.js"></script>
    <script src="../../../../../public/js/utils/libs/bootstrap.js"></script>
    <script src="../../../../../public/js/utils/libs/fancybox.js"></script>
    <script src="../../../../../public/js/utils/libs/notification.js"></script>

    <script src="../../../../../public/js/utils/libs/select2.js"></script>
    <script src="../../../../../public/js/utils/spinner.js"></script>
    <script src="../../../../../public/js/utils/notifications.js"></script>
    <script src="../../../../../public/js/inventory/finalizar_conteo_stock.js"></script>
</body>

</html>