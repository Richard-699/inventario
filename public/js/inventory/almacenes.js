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
    debugger;
    mostrarCarga();
    btn.disabled = true;

    try {

        // 1. Obtener datos necesarios desde el backend (FETCH)
        const [
            resLocalizaciones,
            resClasifAll,
            resClasifSelected,
            resAllAlmacenesLoc,
            resLocSelected,
            resAlmacen
        ] = await Promise.all([
            fetch('../../Handler/inventory/almacenesHandler.php?action=onGet_localizaciones'),
            fetch('../../Handler/inventory/almacenesHandler.php?action=onGet_clasificacionesAlmacenes'),
            fetch(`../../Handler/inventory/almacenesHandler.php?action=onGet_clasificacionesSelected&id_almacen=${id}`),
            fetch('../../Handler/inventory/almacenesHandler.php?action=onGet_AlmacenesLocalizaciones'),
            fetch(`../../Handler/inventory/almacenesHandler.php?action=onGet_localizacionesSelected&id_almacen=${id}`),
            fetch(`../../Handler/inventory/almacenesHandler.php?action=onGet_almacenes_By_Id&id_almacen=${id}`)
        ]);

        const [
            localizacionesRaw,
            clasificacionesRaw,
            clasificacionesSelRaw,
            almacenesLocalizacionesRaw,
            localizacionesSelRaw,
            almacenRaw
        ] = await Promise.all([
            resLocalizaciones.json(),
            resClasifAll.json(),
            resClasifSelected.json(),
            resAllAlmacenesLoc.json(),
            resLocSelected.json(),
            resAlmacen.json()
        ]);

        let almacenesLocalizaciones = Array.isArray(almacenesLocalizacionesRaw) ? almacenesLocalizacionesRaw : [];

        // 2. Filtrar localizaciones disponibles
        const idsOcupados = new Set(
            almacenesLocalizaciones
                .filter(item => String(item.id_almacen) !== String(id))
                .map(item => item.id_localizacion_localizaciones)
        );

        const localizacionesFiltradas = localizacionesRaw.filter(
            loc => !idsOcupados.has(loc.id_localizacion)
        );

        // ==========================================================
        // 3. CAMBIO: Enviar los datos por FETCH POST y obtener el HTML
        // ==========================================================
        const responseHtml = await fetch("edit_almacenes.php", {
            method: "POST",
            headers: {
                // Importante: Indica al servidor que el body es un JSON
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                // Enviamos los objetos directamente, fetch los serializa
                id_almacen: id,
                localizaciones: localizacionesFiltradas,
                localizacionesSelected: localizacionesSelRaw,
                Almacen: almacenRaw,
                clasificaciones: clasificacionesRaw,
                clasificacionesSelected: clasificacionesSelRaw
            })
        });

        // 4. Obtener el HTML retornado por el servidor
        const htmlContent = await responseHtml.text();

        // 5. Abrir Fancybox usando el HTML ya cargado
        Fancybox.show([{
            src: htmlContent,
            type: "html"
        }], {
            on: {
                done: () => {

                    // LOCALIZACIONES
                    const localizacionesSelect = document.getElementById('localizaciones');
                    if (localizacionesSelect && !localizacionesSelect.dataset.init) {
                        new Choices(localizacionesSelect, {
                            removeItemButton: true,
                            searchEnabled: true,
                            shouldSort: false
                        });
                        localizacionesSelect.dataset.init = "1";
                    }

                    // CLASIFICACIONES
                    const clasificacionesSelect = document.getElementById('clasificaciones_select');
                    if (clasificacionesSelect && !clasificacionesSelect.dataset.init) {
                        new Choices(clasificacionesSelect, {
                            removeItemButton: true,
                            searchEnabled: true,
                            shouldSort: false
                        });
                        clasificacionesSelect.dataset.init = "1";
                    }
                }
            }
        });


        ocultarCarga();

    } catch (error) {
        console.error("Error al cargar datos del almacén:", error);
        ocultarCarga();
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

