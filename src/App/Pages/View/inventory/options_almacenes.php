<?php

if (isset($_GET['informacionSAP'])) {
    $informacionSAPJson = urldecode($_GET['informacionSAP']);
    $informacionSAPArray = json_decode($informacionSAPJson, true);

    if (!is_array($informacionSAPArray)) {
        echo "Error: formato de datos inválido.";
        exit;
    }

    $id_partnumber = $_GET['id_partnumber'];

    $listaAlmacenes = array_map(function ($item) {
        return [
            'id_almacen' => $item['id_almacen_informacion_sap_mb52'] ?? '',
            'almacen' => $item['almacen'] ?? ''
        ];
    }, $informacionSAPArray);
} else {
    echo "No se recibió el parámetro información SAP.";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../../public/css/inventory/options_almacenes.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../public/img/LogoBlanco.png" type="image/x-icon">

    <link rel="stylesheet" href="../../../../../public/css/utils/libs/libs.css">

    <link rel="stylesheet" href="../../../../../public/css/utils/estilos_spinner.css">
</head>

<body class="p-4">

    <div class="contenido_options_almacenes">
        <h5 class="mb-4"><i class="fa-solid fa-warehouse me-2 fs-4"></i>
            Seleccionar Almacén
        </h5>
        <form id="formOptionAlmacen">
            <div class="mb-3">
                <input type="hidden" value="<?php echo $id_partnumber; ?>" id="id_partnumber" name="id_partnumber">
                <label for="id_tipo_localizacion_localizaciones" class="form-label">Almacén: *</label>
                <select class="form-select" id="id_almacen_informacion_sap_mb52" name="id_almacen_informacion_sap_mb52">
                    <option value="">Seleccione un almacén</option>
                    <?php
                    foreach ($listaAlmacenes as $almacen) {
                        $id = $almacen['id_almacen'];
                        $nombre = $almacen['almacen'];
                        echo "<option value='{$id}'>{$nombre}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success px-4 shadow-sm" id="btn-aprobar-editar">
                    <i class="bi bi-check-circle me-1"></i>Continuar
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
    <script src="../../../../../public/js/inventory/options_almacenes.js"></script>
</body>

</html>