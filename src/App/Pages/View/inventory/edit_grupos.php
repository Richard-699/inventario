<?php
// Evitar que el navegador guarde la modal en caché
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

$id_grupo = $_GET['id_grupo'] ?? null;
$informacion_migrada_sap_grupo = $_GET['sap'] ?? '';
?>

<div class="contenido_edit_grupos container-fluid p-4" style="max-width: 600px; min-width: 350px; margin: auto;">
    <div class="d-flex align-items-center mb-4 border-bottom pb-3">
        <i class="fa-solid fa-layer-group me-2 fs-5 text-primary"></i> 
        <h5 class="mb-0 fw-bold">Editar Grupo</h5>
    </div>
    
    <form id="formUpdateGrupo" class="row g-3">
        <input type="hidden" name="id_grupo" id="id_grupo" value="<?= htmlspecialchars($id_grupo) ?>">
        <input type="hidden" name="informacion_migrada_sap_grupo" id="informacion_migrada_sap_grupo" value="<?= htmlspecialchars($informacion_migrada_sap_grupo) ?>">

        <div class="col-12 mb-2">
            <label for="descripcion_grupo" class="form-label small fw-bold">Descripción o nombre: *</label>
            <input type="text" class="form-control form-control-sm shadow-sm" id="descripcion_grupo" name="descripcion_grupo" placeholder="Ej: TAPA FIJA">
        </div>

        <div class="col-md-7 mb-2">
            <label for="fecha_programacion_grupo" class="form-label small fw-bold">Mes de conteo: *</label>
            <input type="month" class="form-control form-control-sm shadow-sm" id="fecha_programacion_grupo" name="fecha_programacion_grupo">
        </div>

        <div class="col-12 mb-3">
            <label for="part_numbers_select" class="form-label small fw-bold">Seleccione los part numbers: *</label>
            <select id="part_numbers_select" class="form-control shadow-sm" multiple name="part_numbers_select"></select>
            <div class="form-text mt-1" style="font-size: 0.75rem;">
                Puedes buscar y seleccionar múltiples opciones.
            </div>
        </div>

        <div class="col-12 d-flex justify-content-end gap-2 border-top pt-3 mt-3">
            <button type="button" class="btn btn-outline-secondary btn-sm px-3" onclick="Fancybox.close();">
                Cancelar
            </button>
            <button type="submit" class="btn btn-success btn-sm px-4 shadow-sm" id="btn-aprobar-editar">
                <i class="bi bi-check-circle me-1"></i> Actualizar
            </button>
        </div>
    </form>
</div>

<script src="../../../../../public/js/inventory/edit_grupos.js"></script>