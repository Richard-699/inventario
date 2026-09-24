<?php
// *****************************************************************
// INICIALIZACIÓN DE VISTA PROTEGIDA
// Este archivo carga Composer, Inicia la Sesión, Valida la Sesión 
// y define las variables de administrador requeridas por el header.
// *****************************************************************
include '../../Handler/auth/session_init.php'; 
// Las variables $administrador, $permisosAdministradores, y $permisos ya están definidas aquí.
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprobación</title>
    <link rel="shortcut icon" href="../../../../../public/img/LogoBlanco.png" type="image/x-icon">

    <link rel="stylesheet" href="../../../../../public/css/utils/libs/libs.css">
    <link rel="stylesheet" href="../../../../../public/css/utils/estilos_spinner.css">
    <link rel="stylesheet" href="../../../../../public/css/dataTable/dataTable.css">
    <link rel="stylesheet" href="../../../../../public/css/inventory/exactitud.css">

    <?php include('../../../Shared/Util/spinner.php'); ?>
</head>

<body>
    <?php include('../shared/header.php'); ?>

    <div class="container-fluid px-2 py-3">
        <div class="table-container table-responsive">
            <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-2">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-bullseye me-2 fs-4"></i>
                    <h5 class="m-0 fw-semibold text-dark">Exactitud</h5>
                </div>
                <div class="d-flex align-items-center">
                    <button class="btn btn-info btn-sm me-2" id="btnMigrarSapExactitud">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Importar Base de datos SAP
                    </button>
                </div>
            </div>

            <table id="tabla-exactitud" class="table table-striped table-bordered table-sm dt-responsive nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th style="width: 12%">Material</th>
                        <th style="width: 30%;">Descripcion</th>
                        <th style="width: 8%;">Tipo Alma.</th>
                        <th style="width: 8%;">Área Alma.</th>
                        <th style="width: 10%;">Ubicación</th>
                        <th style="width: 10%;">¿Coincide?</th>
                        <th style="width: 20%;">Fecha Migración</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <?php include('../shared/footer.php'); ?>
    <!-- Scripts en orden -->
    <script src="../../../../../public/js/utils/libs/jquery.js"></script>
    <script src="../../../../../public/js/utils/libs/bootstrap.js"></script>
    <script src="../../../../../public/js/utils/libs/datatables.js"></script>
    <script src="../../../../../public/js/utils/libs/fancybox.js"></script>
    <script src="../../../../../public/js/utils/libs/notification.js"></script>

    <!-- Scripts funcionalidades -->
    <script src="../../../../../public/js/utils/spinner.js"></script>
    <script src="../../../../../public/js/utils/notifications.js"></script>
    <script src="../../../../../public/js/inventory/exactitud.js"></script>

</html>