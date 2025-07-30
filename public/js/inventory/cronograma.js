$(document).ready(function () {
    debugger;
    let primeraVez = true;
    let rangoInicio;
    let rangoFin;

    const formatoMes = (m) => (m + 1).toString().padStart(2, '0');

    const tabla = $('#tabla-cronograma').DataTable({
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
            "url": "../../Handler/inventory/cronogramaHandler.php?action=onGet_cronograma",
            "type": "GET",
            "data": function (d) {
                d.rangoInicio = rangoInicio;
                d.rangoFin = rangoFin;
            },
            "dataSrc": ""
        },
        "columns": [
            { "data": "id_cronograma", "className": "dt-center" },
            { "data": "grupo", "className": "dt-center" },
            { "data": "fecha_cronograma", "className": "dt-center" },
            { "data": "administrador", "className": "dt-center" },
            { "data": "estado", "className": "dt-center" },
            {
                "data": "id_cronograma",
                "className": "dt-center",
                "render": function (data, type, row) {
                    return `
                            <button class="btn btn-primary btn-sm" onclick="updateGrupo(this, '${data}')">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteGrupo(this, '${data}')">
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

    document.getElementById("btnNoProgramados").addEventListener("click", function () {
        rangoInicio = null;
        rangoFin = null;

        document.getElementById("btnProgramados").style.backgroundColor = "#17a2b8";
        document.getElementById("btnNoProgramados").style.backgroundColor = "#072B31";

        tabla.ajax.reload();
    });

    document.getElementById("btnProgramados").addEventListener("click", function () {
        const fecha = new Date();
        const anio = fecha.getFullYear();
        const mes = fecha.getMonth();
        const trimestre = Math.floor(mes / 3);
        const mesInicio = trimestre * 3;
        const mesFin = mesInicio + 2;

        rangoInicio = `${anio}-${formatoMes(mesInicio)}`;
        rangoFin = `${anio}-${formatoMes(mesFin)}`;

        document.getElementById("btnProgramados").style.backgroundColor = "#072B31";
        document.getElementById("btnNoProgramados").style.backgroundColor = "#17a2b8";

        if (!primeraVez) {
            tabla.ajax.reload();
        } else {
            primeraVez = false;
        }
    });

    document.getElementById("btnProgramados").click();

    /* document.getElementById('btnAgregarGrupo').addEventListener('click', function () {
        const url = 'agregar_grupos.php';
        Fancybox.show([{
            src: url,
            type: 'ajax'
        }]);
    }); */
});


async function updateGrupo(btn, id) {
    mostrarCarga();
    btn.disabled = true;

    try {
        // 1. Obtener TODOS los partnumbers
        const responsePartnumbers = await fetch('../../Handler/inventory/gruposHandler.php?action=onGet_partnumbers', {
            method: 'GET'
        });
        const allPartnumbers = await responsePartnumbers.json();

        // 2. Separar partnumbers seleccionados y sin asignación
        const idGrupoActual = String(id);

        const partnumbersSeleccionados = [];
        const partnumbersSinAsignacion = [];

        allPartnumbers.forEach(partnumber => {
            const partnumberIdGrupo = String(partnumber.id_grupo_partnumber);
            if (partnumberIdGrupo === idGrupoActual) {
                partnumbersSeleccionados.push(partnumber);
            }
            else if (partnumber.id_grupo_partnumber === null || partnumber.id_grupo_partnumber === undefined || partnumber.id_grupo_partnumber === 'No asignado') {
                partnumbersSinAsignacion.push(partnumber);
            }
        });

        // 3. Codificar las listas separadas para la URL
        const partnumbersSeleccionadosEncoded = encodeURIComponent(JSON.stringify(partnumbersSeleccionados));
        const partnumbersSinAsignacionEncoded = encodeURIComponent(JSON.stringify(partnumbersSinAsignacion));


        const responseGrupo = await fetch(`../../Handler/inventory/gruposHandler.php?action=onGet_grupo_By_id&id_grupo=${id}`, {
            method: 'GET'
        });
        const grupo = await responseGrupo.json();
        const grupoEnconded = encodeURIComponent(JSON.stringify(grupo));

        // 4. Construir la URL
        var url = `edit_grupos.php?id_grupo=${id}` +
            `&partnumbersSeleccionados=${partnumbersSeleccionadosEncoded}` +
            `&partnumbersSinAsignacion=${partnumbersSinAsignacionEncoded}` +
            `&infoGrupo=${grupoEnconded}`;

        debugger;
        Fancybox.show([{
            src: url,
            type: 'ajax'
        }]);

        // ... el resto de tu código de Choices.js y Fancybox, que está bien ...
        setTimeout(() => {
            ocultarCarga();

            const part_numbers_select = document.getElementById('part_numbers_select');
            if (part_numbers_select && !part_numbers_select.classList.contains('choices-initialized')) {
                const choicesInstance = new Choices(part_numbers_select, {
                    removeItemButton: true,
                    searchEnabled: true,
                    placeholder: true,
                    placeholderValue: 'Selecciona una o más partNumbers',
                    searchPlaceholderValue: 'Buscar partNumbers...',
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

                part_numbers_select.classList.add('choices-initialized');
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

async function deleteGrupo(btn, id_grupo) {
    const confirmado = await mostrarConfirmacion({
        titulo: '¿Deseas eliminar este grupo?',
        texto: 'Una vez eliminado, los Part Numbers asociados quedarán sin asignación',
        icono: 'warning',
        textoConfirmar: 'Sí, eliminar',
        textoCancelar: 'Cancelar'
    });

    if (!confirmado) return;

    mostrarCarga();
    btn.disabled = true;
    try {
        const response = await fetch('../../Handler/inventory/gruposHandler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'delete_grupo',
                id: id_grupo
            })
        });

        const data = await response.json();
        ocultarCarga();

        if (data.success) {
            notification('success', 'Se eliminó el grupo.', 2000);
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            btn.disabled = false;
            notification('error', 'Falló al eliminar el grupo, intenta nuevamente.', 2000);
        }
    } catch (error) {
        ocultarCarga();
        console.error('Error al eliminar:', error);
        btn.disabled = false;
    }
}



