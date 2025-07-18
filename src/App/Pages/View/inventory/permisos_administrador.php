<?php
$celulas = json_decode($_GET['celulas'], true);
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

    $celulasSelected = [];
    $idsCelulasSeleccionados = [];
    $tieneCelulas = false;

    if (isset($_GET['celulasSelected'])) {
        $celulasSelected = json_decode($_GET['celulasSelected'], true);

        if (count($celulasSelected) > 0) {
            $tieneCelulas = true;
            foreach ($celulasSelected as $celula) {
                if (isset($celula['id_celulas_areas_administradores'])) {
                    $idsCelulasSeleccionados[] = $celula['id_celulas_areas_administradores'];
                }
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
    <link rel="icon" type="image/x-icon" href="../../img/LogoBlanco.png">
    <link href="../../../public/css/partials/administradorCelulasPermisos.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../public/img/LogoBlanco.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body class="p-4">

    <div class="contenido-aprobacion-admin">
        <h5 class="mb-4"><i class="fas fa-users-gear"></i>
            <?= ($action == 'update') ? ' Editar Administrador' : ' Aprobar Administrador' ?>
        </h5>
        <form id="formUpdateAdministrador">
            <input type="hidden" name="action" id="action" value="<?= htmlspecialchars($action) ?>">
            <input type="hidden" name="id_administrador" id="id_administrador" value="<?= htmlspecialchars($id_administrador) ?>">
            <div class="col-md-12 mt-4">
                <p>Seleccione los permisos que tendrá este administrador: *</p>
                <?php if ($action == 'approve') { ?>

                    <select id="permisos_administradores" class="select2" multiple style="width: 100%" name="permisos_administradores[]">
                        <?php foreach ($permisos as $p): ?>
                            <option value="<?= $p['id_permiso'] ?>"><?= $p['tipo_permiso'] ?></option>
                        <?php endforeach; ?>
                    </select>

                <?php } else { ?>

                    <select id="permisos_administradores" class="select2" multiple style="width: 100%" name="permisos_administradores[]">
                        <?php foreach ($permisos as $p): ?>
                            <option value="<?= $p['id_permiso'] ?>" <?= in_array($p['id_permiso'], $idsPermisosSeleccionados) ? 'selected' : '' ?>>
                                <?= $p['tipo_permiso'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                <?php } ?>
            </div>
            <div id="contenedorCelulas" class="col-md-12 mt-3">
                <p>Seleccione las células que gestionará este administrador: *</p>

                <?php if ($action == 'approve') { ?>

                    <select id="celulas_administradores" class="select2" multiple style="width: 100%" name="celulas_administradores[]">
                        <?php foreach ($celulas as $c): ?>
                            <option value="<?= $c['id_celulas_areas'] ?>"><?= $c['nombre_celula'] ?></option>
                        <?php endforeach; ?>
                    </select>

                <?php } else { ?>

                    <select id="celulas_administradores" class="select2" multiple style="width: 100%" name="celulas_administradores[]">
                        <?php foreach ($celulas as $c): ?>
                            <option value="<?= $c['id_celulas_areas'] ?>" <?= in_array($c['id_celulas_areas'], $idsCelulasSeleccionados) ? 'selected' : '' ?>>
                                <?= $c['nombre_celula'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                <?php } ?>
            </div>
            <div class="d-flex justify-content-end mb-4">
                <button type="submit" class="btn btn-success" id="btn-aprobar-editar">
                    <?= ($action == 'update') ? 'Actualizar' : 'Aprobar' ?>
                </button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="../../../public/js/utils/notifications.js"></script>
    <script src="../../../public/js/partials/administradorCelulasPermisos.js"></script>
</body>

</html>