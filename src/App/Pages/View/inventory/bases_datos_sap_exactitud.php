<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';
session_start();
$id_administrador = $_SESSION['administrador']->id_administrador;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../../public/css/inventory/bases_datos_sap.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../public/img/LogoBlanco.png" type="image/x-icon">

    <link rel="stylesheet" href="../../../../../public/css/utils/libs/libs.css">

    <link rel="stylesheet" href="../../../../../public/css/utils/estilos_spinner.css">
    <?php
    $id_grupo = $_GET['id_grupo'] ?? null;
    ?>
</head>

<body class="p-4">

    <div class="contenido_bases_sap">
        <h5><i class="fa-solid fa-file-excel me-2 fs-4"></i>
            Importar Base de datos SAP - Exactitud
        </h5>
        <form id="formBdsSapExactitud" enctype="multipart/form-data">
            <input type="hidden" class="form-control" name="id_administrador" id="id_administrador" value="<?= htmlspecialchars($id_administrador) ?>">

            <div class="mb-4 mt-5">
                <label for="" class="form-label">LX03: *</label>
                <input type="file" accept=".xlsx, .xls" class="form-control" id="" name="lx03">
            </div>

            <div class="mb-4">
                <label for="vacias" class="form-label">¿Importar solo las ubicaciones vacías? *</label>
                <select class="form-select" name="vacias" id="vacias">
                    <option selected disabled value="">Selecciona una opción</option>
                    <option value="Si">Si, solo las vacías</option>
                    <option value="No">No, migrar todo</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">Filtrar por tipo de almacén:</label>
                <div class="filtro-opciones">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="checkAll" name="check_all">
                        <label class="form-check-label" for="checkAll">(Seleccionar todo)</label>
                    </div>
                    <div id="lista-grupos" class="lista-checkboxes">
                        <div class="form-check">
                            <input class="form-check-input grupo-check" type="checkbox" name="grupos[]" value="901" id="grupo901">
                            <label class="form-check-label" for="grupo901">901</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input grupo-check" type="checkbox" name="grupos[]" value="902" id="grupo902">
                            <label class="form-check-label" for="grupo902">902</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input grupo-check" type="checkbox" name="grupos[]" value="904" id="grupo904">
                            <label class="form-check-label" for="grupo904">904</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input grupo-check" type="checkbox" name="grupos[]" value="910" id="grupo910">
                            <label class="form-check-label" for="grupo910">910</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input grupo-check" type="checkbox" name="grupos[]" value="917" id="grupo917">
                            <label class="form-check-label" for="grupo917">917</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input grupo-check" type="checkbox" name="grupos[]" value="921" id="grupo921">
                            <label class="form-check-label" for="grupo921">921</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input grupo-check" type="checkbox" name="grupos[]" value="922" id="grupo922">
                            <label class="form-check-label" for="grupo922">922</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input grupo-check" type="checkbox" name="grupos[]" value="998" id="grupo998">
                            <label class="form-check-label" for="grupo998">998</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input grupo-check" type="checkbox" name="grupos[]" value="999" id="grupo999">
                            <label class="form-check-label" for="grupo999">999</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input grupo-check" type="checkbox" name="grupos[]" value="ALP" id="grupoALP">
                            <label class="form-check-label" for="grupoALP">ALP</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input grupo-check" type="checkbox" name="grupos[]" value="COL" id="grupoCOL">
                            <label class="form-check-label" for="grupoCOL">COL</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input grupo-check" type="checkbox" name="grupos[]" value="DOP" id="grupoDOP">
                            <label class="form-check-label" for="grupoDOP">DOP</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input grupo-check" type="checkbox" name="grupos[]" value="EGR" id="grupoEGR">
                            <label class="form-check-label" for="grupoEGR">EGR</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input grupo-check" type="checkbox" name="grupos[]" value="ETQ" id="grupoETQ">
                            <label class="form-check-label" for="grupoETQ">ETQ</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input grupo-check" type="checkbox" name="grupos[]" value="LAM" id="grupoLAM">
                            <label class="form-check-label" for="grupoLAM">LAM</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input grupo-check" type="checkbox" name="grupos[]" value="PKN" id="grupoPKN">
                            <label class="form-check-label" for="grupoPKN">PKN</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input grupo-check" type="checkbox" name="grupos[]" value="SPI" id="grupoSPI">
                            <label class="form-check-label" for="grupoSPI">SPI</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input grupo-check" type="checkbox" name="grupos[]" value="TER" id="grupoTER">
                            <label class="form-check-label" for="grupoTER">TER</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success px-4 shadow-sm" id="btn-cargar-bds">
                    <i class="bi bi-check-circle me-1"></i>Cargar
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
    <script src="../../../../../public/js/inventory/bases_datos_sap_exactitud.js"></script>
</body>

</html>