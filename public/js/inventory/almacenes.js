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
            /* { "data": "id_almacen", "className": "dt-center" }, */
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

    document.getElementById('btnAgregarAlmacen').addEventListener('click', async function () {

        mostrarCarga();

        let btn = this;
        btn.disabled = true;

        try {
            const response_clasificacion_almacenes = await fetch('../../Handler/inventory/almacenesHandler.php?action=onGet_clasificacionesAlmacenes', {
                method: 'GET'
            });
            const clasificaciones_almacenes = await response_clasificacion_almacenes.json();
            const clasificaciones_almacenesEncoded = encodeURIComponent(JSON.stringify(clasificaciones_almacenes));

            var url = `agregar_almacenes.php?clasificaciones_almacenes=${clasificaciones_almacenesEncoded}`;

            Fancybox.show([{
                src: url,
                type: 'ajax'
            }]);


            // ... el resto de tu código de Choices.js y Fancybox, que está bien ...
            setTimeout(() => {
                ocultarCarga();

                const clasificacion_almacen_select = document.getElementById('clasificacion_almacen_select');
                if (clasificacion_almacen_select && !clasificacion_almacen_select.classList.contains('choices-initialized')) {
                    const choicesInstance = new Choices(clasificacion_almacen_select, {
                        removeItemButton: true,
                        searchEnabled: true,
                        placeholder: true,
                        placeholderValue: 'Selecciona una o clasificaciones',
                        searchPlaceholderValue: 'Buscar clasificación...',
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

                    clasificacion_almacen_select.classList.add('choices-initialized');
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
            ocultarCarga();
            btn.disabled = false;
        }
    });

});

async function updateAlmacen(btn, id) {
    mostrarCarga();
    btn.disabled = true;

    try {
        // ================================================
        // 1. Obtener datos necesarios desde el backend
        // ================================================

        // 1.1. Obtener todas las localizaciones disponibles
        const responseLocalizaciones = await fetch('../../Handler/inventory/almacenesHandler.php?action=onGet_localizaciones');
        const localizaciones = await responseLocalizaciones.json();

        // 1.2. Obtener todas las clasificaciones posibles
        const response_clasificacion_almacenes = await fetch('../../Handler/inventory/almacenesHandler.php?action=onGet_clasificacionesAlmacenes');
        const clasificaciones_almacenes = await response_clasificacion_almacenes.json();

        // 1.3. Obtener las clasificaciones ya asignadas a este almacén
        const responseClasificacionesSelected = await fetch(`../../Handler/inventory/almacenesHandler.php?action=onGet_clasificacionesSelected&id_almacen=${id}`);
        const clasificacionesSelected = await responseClasificacionesSelected.json();

        // 1.4. Obtener todas las localizaciones ya asignadas a cualquier almacén
        const responseAlmacenesLocalizaciones = await fetch(`../../Handler/inventory/almacenesHandler.php?action=onGet_AlmacenesLocalizaciones`);
        let AlmacenesLocalizaciones = await responseAlmacenesLocalizaciones.json();

        // Validar que sea un array
        if (!Array.isArray(AlmacenesLocalizaciones)) {
            AlmacenesLocalizaciones = [];
        }

        // ================================================
        // 2. Filtrar localizaciones que no estén ocupadas
        // ================================================

        // 2.1. Obtener IDs de localizaciones ocupadas por otros almacenes (≠ almacén actual)
        let idsOcupados = new Set();
        if (AlmacenesLocalizaciones.length > 0) {
            idsOcupados = new Set(
                AlmacenesLocalizaciones
                    .filter(item => String(item.id_almacen) !== String(id))
                    .map(item => item.id_localizacion_localizaciones)
            );
        }

        // 2.2. Filtrar localizaciones disponibles
        const localizacionesFiltradas = localizaciones.filter(
            loc => !idsOcupados.has(loc.id_localizacion)
        );

        const localizacionesEnconded = encodeURIComponent(JSON.stringify(localizacionesFiltradas));

        // ================================================
        // 3. Obtener datos del almacén actual
        // ================================================

        // 3.1. Localizaciones asignadas al almacén actual
        const responseLocalizacionesSelected = await fetch(`../../Handler/inventory/almacenesHandler.php?action=onGet_localizacionesSelected&id_almacen=${id}`);
        const localizacionesSelected = await responseLocalizacionesSelected.json();
        const localizacionesSelectedEnconded = encodeURIComponent(JSON.stringify(localizacionesSelected));

        // 3.2. Información del almacén
        const responseAlmacen = await fetch(`../../Handler/inventory/almacenesHandler.php?action=onGet_almacenes_By_Id&id_almacen=${id}`);
        const Almacen = await responseAlmacen.json();
        const AlmacenEnconded = encodeURIComponent(JSON.stringify(Almacen));

        // 3.3. Codificar clasificaciones
        const clasificacionesAllEncoded = encodeURIComponent(JSON.stringify(clasificaciones_almacenes));
        const clasificacionesSelectedEncoded = encodeURIComponent(JSON.stringify(clasificacionesSelected));

        // 4. Mostrar formulario en modal (Fancybox)
        const url = `edit_almacenes.php?localizaciones=${localizacionesEnconded}&localizacionesSelected=${localizacionesSelectedEnconded}&Almacen=${AlmacenEnconded}&id_almacen=${id}&clasificaciones=${clasificacionesAllEncoded}&clasificacionesSelected=${clasificacionesSelectedEncoded}`;

        Fancybox.show([{
            src: url,
            type: 'ajax'
        }]);

        // 5. Inicializar elementos dinámicos (Choices.js)
        setTimeout(() => {
            ocultarCarga();

            // -------- Localizaciones --------
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

                // Delegar eventos para selección y deselección
                document.addEventListener('click', function (e) {
                    const opcion = e.target.closest('.choices__item--selectable');
                    const contenedor = e.target.closest('.choices__list--dropdown');

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

            // -------- Clasificaciones --------
            const clasificacionesSelect = document.getElementById('clasificaciones_select');
            if (clasificacionesSelect && !clasificacionesSelect.classList.contains('choices-initialized')) {
                const choicesInstance = new Choices(clasificacionesSelect, {
                    removeItemButton: true,
                    searchEnabled: true,
                    placeholder: true,
                    placeholderValue: 'Selecciona una o más clasificaciones',
                    searchPlaceholderValue: 'Buscar clasificación...',
                    shouldSort: false
                });

                // Delegar eventos para selección y deselección
                document.addEventListener('click', function (e) {
                    const opcion = e.target.closest('.choices__item--selectable');
                    const contenedor = e.target.closest('.choices__list--dropdown');

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

                clasificacionesSelect.classList.add('choices-initialized');
            }

            // Evitar que el modal se cierre al hacer clic fuera
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

