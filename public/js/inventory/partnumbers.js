$(document).ready(function () {
    $('#tabla-partnumbers').DataTable({
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
            "url": '../../Handler/inventory/partnumbersHandler.php?action=onGet_partnumbers',
            "dataSrc": ""
        },
        "columns": [
            { "data": "id_partnumber", "className": "dt-center" },
            { "data": "partnumber", "className": "dt-center" },
            { "data": "descripcion_breve", "className": "dt-center" },
            { "data": "umb", "className": "dt-center" },
            { "data": "nombre_interno", "className": "dt-center" },
            { "data": "grupo", "className": "dt-center" },
            { "data": "plataforma", "className": "dt-center" },
            {
                "data": "id_partnumber",
                "className": "dt-center",
                "render": function (data, type, row) {
                    return `
                            <button class="btn btn-primary btn-sm" onclick="updateLocalizacion(this, '${data}')">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteLocalizacion(this, '${data}')">
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

    document.getElementById('btnAgregarPartNumbers').addEventListener('click', async function () {
        mostrarCarga();

        let btn = this;
        btn.disabled = true;

        try {
            const responseUMBS = await fetch('../../Handler/inventory/partnumbersHandler.php?action=onGet_UMBS', {
                method: 'GET'
            });
            const umbs = await responseUMBS.json();
            const umbsEncoded = encodeURIComponent(JSON.stringify(umbs));

            const responsePlataformas = await fetch('../../Handler/inventory/partnumbersHandler.php?action=onGet_Plataformas', {
                method: 'GET'
            });
            const plataformas = await responsePlataformas.json();
            const plataformasEncoded = encodeURIComponent(JSON.stringify(plataformas));

            var url = `agregar_partnumbers.php?umbs=${umbsEncoded}&plataformas=${plataformasEncoded}`;

            Fancybox.show([{
                src: url,
                type: 'ajax'
            }]);

            setTimeout(() => {
                ocultarCarga();
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

async function deleteLocalizacion(btn, id) {
    const confirmado = await mostrarConfirmacion({
        titulo: '¿Deseas eliminar esta localización?',
        texto: 'Una vez eliminada, no se podrá revertir',
        icono: 'warning',
        textoConfirmar: 'Sí, eliminar',
        textoCancelar: 'Cancelar'
    });

    if (!confirmado) return;

    mostrarCarga();
    btn.disabled = true;
    try {
        const response = await fetch('../../Handler/inventory/localizacionesHandler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'delete_localizacion',
                id: id
            })
        });

        const data = await response.json();
        ocultarCarga();

        if (data.success) {
            notification('success', 'Se eliminó la localización.', 2000);
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            btn.disabled = false;
            notification('error', 'Falló al eliminar la localización, intenta nuevamente.', 2000);
        }
    } catch (error) {
        ocultarCarga();
        console.error('Error al rechazar:', error);
        btn.disabled = false;
    }
}

async function updateLocalizacion(btn, id) {
    mostrarCarga();
    btn.disabled = true;

    try {
        const responseTipo_Localizaciones = await fetch('../../Handler/inventory/localizacionesHandler.php?action=onGet_tipoLocalizaciones', {
            method: 'GET'
        });
        const tipo_Localizaciones = await responseTipo_Localizaciones.json();
        const tipoLocalizacionesEncoded = encodeURIComponent(JSON.stringify(tipo_Localizaciones));

        const responseLocalizacionSelected = await fetch(`../../Handler/inventory/localizacionesHandler.php?action=onGet_localizacionSelected&id=${id}`, {
            method: 'GET'
        });
        const localizacionSelected = await responseLocalizacionSelected.json();
        const localizacionSelectedEnconded = encodeURIComponent(JSON.stringify(localizacionSelected));

        var url = `edit_localizaciones.php?tipo_localizaciones=${tipoLocalizacionesEncoded}&localizacionSelected=${localizacionSelectedEnconded}&id=${id}`;

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
                    placeholderValue: 'Selecciona uno o localizaciones',
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