<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Application\Service\BasesDatosSapService;

$id_partnumber = $_POST['id_partnumber'] ?? $_GET['id_partnumber'] ?? null;
$id_grupo = $_POST['id_grupo'] ?? $_GET['id_grupo'] ?? null;

if (!$id_partnumber) {
    echo "<div class='alert alert-danger'>No se recibió el Part Number.</div>";
    exit;
}

try {
    $basesDatosSapService = new BasesDatosSapService();
    $informacionesSap = $basesDatosSapService->onGetInformacionSAP($id_partnumber, null);

/*     // === Debug temporal ===
    echo "<pre style='background:#111;color:#0f0;padding:10px;border-radius:6px;'>";
    print_r($informacionesSap);
    echo "</pre>";
    exit;
    // ====================== */

    if (empty($informacionesSap)) {
        echo "<div class='alert alert-warning'>No se encontraron datos SAP para el Part Number.</div>";
        exit;
    }

    $listaAlmacenes = [];
    $almacenesUnicos = [];

    foreach ($informacionesSap as $item) {
        $idAlmacen = $item->id_almacen_informacion_sap_mb52 ?? '';
        $nombreAlmacen = $item->almacen ?? '';

        // Solo agregar si tiene id y aún no se ha agregado
        if (!empty($idAlmacen) && !isset($almacenesUnicos[$idAlmacen])) {
            $almacenesUnicos[$idAlmacen] = true;

            $listaAlmacenes[] = [
                'id_almacen' => $idAlmacen,
                'almacen' => $nombreAlmacen
            ];
        }
    }

    // Si después del filtrado no quedó nada, mostrar aviso
    if (empty($listaAlmacenes)) {
        echo "<div class='alert alert-warning'>No se encontraron almacenes asociados a la información SAP del Part Number.</div>";
        exit;
    }
} catch (Throwable $e) {
    echo "<div class='alert alert-danger'>Error al obtener información SAP: " . htmlspecialchars($e->getMessage()) . "</div>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Seleccionar almacén</title>
    <link href="../../../../../public/css/inventory/options_almacenes.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../../../public/css/utils/libs/libs.css">
</head>

<body class="p-4">
    <div class="contenido_options_almacenes">
        <h5 class="mb-4"><i class="fa-solid fa-warehouse me-2 fs-4"></i> Seleccionar Almacén</h5>

        <form id="formOptionAlmacen" method="post">
            <input type="hidden" id="id_partnumber" name="id_partnumber" value="<?php echo htmlspecialchars($id_partnumber); ?>">
            <input type="hidden" id="id_grupo" name="id_grupo" value="<?php echo htmlspecialchars($id_grupo); ?>">

            <div class="mb-3">
                <label for="id_almacen_informacion_sap_mb52" class="form-label">Almacén: *</label>
                <select class="form-select" id="id_almacen_informacion_sap_mb52" name="id_almacen_informacion_sap_mb52">
                    <option value="">Seleccione un almacén</option>
                    <?php foreach ($listaAlmacenes as $almacen):
                        $id = htmlspecialchars($almacen['id_almacen']);
                        $nombre = htmlspecialchars($almacen['almacen']);
                    ?>
                        <option value="<?php echo $id; ?>"><?php echo $nombre; ?></option>
                    <?php endforeach; ?>
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