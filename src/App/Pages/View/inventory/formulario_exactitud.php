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
    <link href="../../../../../public/css/inventory/formulario_exactitud.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../public/img/LogoBlanco.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../../../public/css/utils/libs/libs.css">
    <link rel="stylesheet" href="../../../../../public/css/utils/estilos_spinner.css">
</head>

<body class="p-4">

    <div class="exactitud">
        <h5 class="mb-4">
            <i class="fa-solid fa-check-to-slot  me-2 fs-4"></i>
            Registro Exactitud
        </h5>
        <form id="form_exactitud">
            <input type="hidden" name="id_exactitud" id="id_exactitud" value="<?= val('id_exactitud') ?>">

            <label for="coincide" class="form-label">
                ¿Hay exactitud en esta ubicación? *
            </label>
            <select id="coincide"
                class="form-control shadow-sm rounded"
                name="coincide">
                <option value="" selected disabled>Seleccione una opción</option>
                <option value="Si">Sí</option>
                <option value="No">No</option>
            </select>


            <label for="novedad" class="form-label mt-3">
               Seleccione la novedad: *
            </label>
            <select id="novedad"
                class="form-control shadow-sm rounded"
                name="novedad">
                <option value="" selected disabled>Seleccione una opción</option>
                <option value="Sin Novedad">Sin Novedad</option>
                <option value="Posición vacía, con material físico">Posición vacía, con material físico</option>
                <option value="Material pertenece a otra ubicación">Material pertenece a otra ubicación</option>
                <option value="Material cargado en sistema, posición vacía">Material cargado en sistema, posición vacía</option>
            </select>

            <div class="mb-3">
                <label for="observaciones" class="form-label mt-3">Describa la novedad (Opcional):</label>
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
                    <i class="fa-solid fa-floppy-disk me-2"></i>Enviar
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
    <script src="../../../../../public/js/inventory/formulario_exactitud.js"></script>
</body>

</html>