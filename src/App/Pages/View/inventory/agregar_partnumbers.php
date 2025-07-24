<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../../public/css/inventory/agregar_partnumbers.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../public/img/LogoBlanco.png" type="image/x-icon">

    <link rel="stylesheet" href="../../../../../public/css/utils/libs/libs.css">

    <link rel="stylesheet" href="../../../../../public/css/utils/estilos_spinner.css">
</head>

<body class="p-4">

    <?php
    if (isset($_GET['umbs'])) {
        $umbsEncoded = $_GET['umbs'];
        $umbsJson = urldecode($umbsEncoded);
        $umbs = json_decode($umbsJson);

        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log('JSON Decode Error in agregar_partnumbers.php: ' . json_last_error_msg());
        }
    } else {
        $umbs = [];
    }

    if (isset($_GET['plataformas'])) {
        $plataformasEncoded = $_GET['plataformas'];
        $plataformasJson = urldecode($plataformasEncoded);
        $plataformas = json_decode($plataformasJson);

        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log('JSON Decode Error in agregar_partnumbers.php: ' . json_last_error_msg());
        }
    } else {
        $plataformas = [];
    }
    ?>

    <div class="contenido-agregar-partnumbers">
        <div class="p-3">
            <h5 class="mb-4"><i class="fa-solid fa-dolly me-2 fs-4"></i>Agregar PartNumbers</h5>
            <form id="formAgregarPartnumbers">
                <div id="secciones-partnumbers">
                </div>

                <div class="text-end">
                    <button type="submit" id="btn-save" class="btn btn-success">
                        <i class="fa fa-save me-1"></i> Guardar
                    </button>
                </div>

                <button type="button" id="btn-agregar" class="btn btn-agregar">
                    <i class="fa fa-plus me-1"></i> Agregar
                </button>
            </form>
        </div>
    </div>

    <template id="template-partnumber">
        <div class="seccion-partnumber border rounded p-3 mb-3 mt-5 position-relative">
            <div class="mb-3">
                <label class="form-label">PartNumber: *</label>
                <input type="text" class="form-control" name="partnumber[]">
            </div>
            <div class="mb-3">
                <label class="form-label">Texto breve de material SAP: *</label>
                <input type="text" class="form-control" name="descripcion_breve[]">
            </div>
            <div class="mb-3">
                <label class="form-label">UMB: *</label>
                <select class="form-select" name="id_umb_partnumber[]">
                    <option value="">Seleccione una UMB</option>
                    <?php
                    if (!empty($umbs)) {
                        foreach ($umbs as $umb) {
                            $id = $umb->id_umb ?? '';
                            $descripcion = $umb->descripcion_umb ?? 'N/A';
                            echo "<option value='{$id}'>{$descripcion}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Nombre interno: *</label>
                <input type="text" class="form-control" name="nombre_interno[]">
            </div>
            <div class="mb-3 d-flex align-items-end justify-content-between">
                <div class="w-100 me-2">
                    <label class="form-label">Plataforma: *</label>
                    <select class="form-select" name="id_plataforma_partnumber[]">
                        <option value="">Seleccione una plataforma</option>
                        <?php
                        if (!empty($plataformas)) {
                            foreach ($plataformas as $plataforma) {
                                $id = $plataforma->id_plataforma ?? '';
                                $descripcion = $plataforma->descripcion_plataforma ?? 'N/A';
                                echo "<option value='{$id}'>{$descripcion}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <button type="button" class="btn btn-danger btn-eliminar-seccion">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
    </template>

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
    <script src="../../../../../public/js/inventory/guardar_partnumbers.js"></script>
</body>

</html>