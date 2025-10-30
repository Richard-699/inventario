<?php
$permisos = json_decode($_GET['permisos'], true);
$action = $_GET['action'] ?? '';
$id_administrador = $_GET['id_administrador'] ?? null;

if ($action == 'update') {
    $permisosSelected = [];
    $idsPermisosSeleccionados = [];

    if (isset($_GET['permisosSelected'])) {
        $permisosSelected = json_decode($_GET['permisosSelected'], true);

        foreach ($permisosSelected as $permiso) {
            if (isset($permiso['id_permiso_permisos'])) {
                $idsPermisosSeleccionados[] = $permiso['id_permiso_permisos'];
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../../public/css/inventory/permisos_administrador.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../public/img/LogoBlanco.png" type="image/x-icon">

    <link rel="stylesheet" href="../../../../../public/css/utils/libs/libs.css">

    <link rel="stylesheet" href="../../../../../public/css/utils/estilos_spinner.css">
</head>

<body class="p-4">

    <div class="contenido-aprobacion-admin">
        <h5 class="mb-4"><i class="fas fa-users-gear"></i>
            <?= ($action == 'update') ? ' Editar Administrador' : ' Aprobar Administrador' ?>
        </h5>
        <form id="formUpdateAdministrador">
            <input type="hidden" name="action" id="action" value="<?= htmlspecialchars($action) ?>">
            <input type="hidden" name="id_administrador" id="id_administrador" value="<?= htmlspecialchars($id_administrador) ?>">

            <div class="mb-4">
                <label for="permisos_administradores" class="form-label fw-semibold">
                    Seleccione los permisos que tendrá este administrador: <span class="text-danger">*</span>
                </label>

                <select id="permisos_administradores"
                    class="form-control shadow-sm rounded"
                    multiple
                    name="permisos_administradores"
                    multiple>
                    <?php foreach ($permisos as $p): ?>
                        <option value="<?= $p['id_permiso'] ?>"
                            <?= ($action !== 'approve' && in_array($p['id_permiso'], $idsPermisosSeleccionados)) ? 'selected' : '' ?>>
                            <?= $p['tipo_permiso'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <div class="form-text mt-1">
                    Puedes buscar y seleccionar múltiples opciones.
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success px-4 shadow-sm" id="btn-aprobar-editar">
                    <i class="bi bi-check-circle me-1"></i>
                    <?= ($action == 'update') ? 'Actualizar' : 'Aprobar' ?>
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
    <script src="../../../../../public/js/inventory/permisos_administrador.js"></script>
</body>

</html>