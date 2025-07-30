$(document).ready(function () {
    $('#tabla-almacenes').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        },
        lengthMenu: [
            [10, 50, 100, 200, -1],
            [10, 50, 100, 200, "Todos"]
        ],
        "scrollCollapse": true,
        "paging": true,
        pageLength: 10,

        "ajax": {
            "url": '../../Handler/inventory/almacenesHandler.php?action=onGet_almacenes',
            "dataSrc": ""
        },
        "columns": [
            { "data": "id_almacen", "className": "dt-center" },
            { "data": "codigo_sap", "className": "dt-center" },
            { "data": "descripcion_almacen", "className": "dt-center" },
            {
                "data": "id_almacen",
                "className": "dt-center",
                "render": function (data, type, row) {
                    return `
                            <button class="btn btn-primary btn-sm" onclick="updateAlmacen(this, '${data}')">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteAlmacen(this, '${data}')">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        `;
                }
            }
        ],
        "responsive": true,
        "ordering": true,
        "info": true,
        "searching": true
    });


    document.getElementById('btnAgregarAlmacen').addEventListener('click', function () {
        const url = 'agregar_almacenes.php';
        Fancybox.show([{
            src: url,
            type: 'ajax'
        }]);
    });

});

async function updateAlmacen(btn, id) {
    mostrarCarga();
    btn.disabled = true;

    try {
        // 1. Obtener todas las localizaciones
        const responseLocalizaciones = await fetch('../../Handler/inventory/almacenesHandler.php?action=onGet_localizaciones', {
            method: 'GET'
        });
        const localizaciones = await responseLocalizaciones.json();

        // 2. Obtener todas las localizaciones ya asignadas a almacenes
        const responseAlmacenesLocalizaciones = await fetch(`../../Handler/inventory/almacenesHandler.php?action=onGet_AlmacenesLocalizaciones`, {
            method: 'GET'
        });
        let AlmacenesLocalizaciones = await responseAlmacenesLocalizaciones.json();

        // 3. Validar que sea un array, si no lo es, lo inicializamos como vacío
        if (!Array.isArray(AlmacenesLocalizaciones)) {
            AlmacenesLocalizaciones = [];
        }

        // 4. Obtener los IDs de localizaciones ocupadas en otros almacenes (≠ almacén actual)
        let idsOcupados = new Set();
        if (AlmacenesLocalizaciones.length > 0) {
            idsOcupados = new Set(
                AlmacenesLocalizaciones
                    .filter(item => String(item.id_almacen) !== String(id)) // solo otros almacenes
                    .map(item => item.id_localizacion_localizaciones)
            );
        }

        // 5. Filtrar localizaciones disponibles (las que no están en otros almacenes)
        const localizacionesFiltradas = localizaciones.filter(
            loc => !idsOcupados.has(loc.id_localizacion)
        );

        const localizacionesEnconded = encodeURIComponent(JSON.stringify(localizacionesFiltradas));

        // 6. Obtener las localizaciones ya asignadas al almacén actual
        const responseLocalizacionesSelected = await fetch(`../../Handler/inventory/almacenesHandler.php?action=onGet_localizacionesSelected&id_almacen=${id}`, {
            method: 'GET'
        });
        const localizacionesSelected = await responseLocalizacionesSelected.json();
        const localizacionesSelectedEnconded = encodeURIComponent(JSON.stringify(localizacionesSelected));

        // 7. Obtener datos del almacén actual
        const responseAlmacen = await fetch(`../../Handler/inventory/almacenesHandler.php?action=onGet_almacenes_By_Id&id_almacen=${id}`, {
            method: 'GET'
        });
        const Almacen = await responseAlmacen.json();
        const AlmacenEnconded = encodeURIComponent(JSON.stringify(Almacen));

        var url = `edit_almacenes.php?localizaciones=${localizacionesEnconded}&localizacionesSelected=${localizacionesSelectedEnconded}&Almacen=${AlmacenEnconded}&id_almacen=${id}`;

        Fancybox.show([{
            src: url,
            type: 'ajax'
        }]);

        setTimeout(() => {
            ocultarCarga();

            const localizacionesSelect = document.getElementById('localizaciones');
            if (localizacionesSelect && !localizacionesSelect.classList.contains('choices-initialized')) {
                const choicesInstance = new Choices(localizacionesSelect, {
                    removeItemButton: true,
                    searchEnabled: true,
                    placeholder: true,
                    placeholderValue: 'Selecciona una o más localizaciones',
                    searchPlaceholderValue: 'Buscar localizaciones...',
                    shouldSort: false
                });

                // Delegación de eventos: escucha clics desde el contenedor padre
                document.addEventListener('click', function (e) {
                    const opcion = e.target.closest('.choices__item--selectable');
                    const contenedor = e.target.closest('.choices__list--dropdown');

                    // Asegúrate que esté dentro del dropdown de Choices
                    if (opcion && contenedor) {
                        e.preventDefault();
                        e.stopPropagation();

                        const value = opcion.getAttribute('data-value');
                        if (!value) return;

                        const selectedValues = choicesInstance.getValue(true);
                        const isSelected = selectedValues.includes(value);

                        if (isSelected) {
                            choicesInstance.removeActiveItemsByValue(value);
                        } else {
                            choicesInstance.setChoiceByValue(value);
                        }
                    }
                });

                localizacionesSelect.classList.add('choices-initialized');
            }

            // Evitar que el modal se cierre por clic externo
            Fancybox.getInstance().options = {
                ...Fancybox.getInstance().options,
                click: false,
                trapFocus: false,
                placeFocusBack: false
            };
        }, 100);

    } catch (error) {
        console.error('Error al cargar la modal:', error);
    } finally {
        btn.disabled = false;
    }
}

async function deleteAlmacen(btn, id_almacen) {
    const confirmado = await mostrarConfirmacion({
        titulo: '¿Deseas eliminar este almacén?',
        texto: 'Una vez eliminado, se eliminarán tambíen las ubicaciones asociadas',
        icono: 'warning',
        textoConfirmar: 'Sí, eliminar',
        textoCancelar: 'Cancelar'
    });

    if (!confirmado) return;

    mostrarCarga();
    btn.disabled = true;
    try {
        const response = await fetch('../../Handler/inventory/almacenesHandler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'delete_almacenes',
                id: id_almacen
            })
        });

        const data = await response.json();
        ocultarCarga();

        if (data.success) {
            notification('success', 'Se eliminó el almacén.', 2000);
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            btn.disabled = false;
            notification('error', 'Falló al eliminar el almacen, intenta nuevamente.', 2000);
        }
    } catch (error) {
        ocultarCarga();
        console.error('Error al eliminar:', error);
        btn.disabled = false;
    }
}

