$(document).ready(function () {
    $('#tabla-conteos').DataTable({
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
            "url": '../../Handler/inventory/aprobacionHandler.php?action=onGet_conteos',
            "dataSrc": ""
        },
        "columns": [
            { "data": "descripcion_grupo", "className": "dt-center" },
            { "data": "fecha_hora_inicio_conteo", "className": "dt-center" },
            { "data": "fecha_hora_final_conteo", "className": "dt-center" },
            { "data": "nombre_encargado", "className": "dt-center" },
            { "data": "observaciones_conteo", "className": "dt-center observaciones-col" },
            {
                "data": "id_conteo",
                "className": "dt-center",
                "render": function (data, type, row) {
                    const id_conteo = data;
                    const id_grupo = row.id_grupo_conteo;

                    return `
            <button class="btn btn-primary btn-sm" onclick="detalleConteo('${id_grupo}')">
                <i class="fa-solid fa-eye"></i>
            </button>
            <button class="btn btn-success btn-sm" onclick="aprobarConteo('${id_conteo}')">
                <i class="fa-solid fa-check"></i>
            </button>
            <button class="btn btn-danger btn-sm" onclick="RechazarConteo('${id_conteo}')">
                <i class="fa-solid fa-x"></i>
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
});

// Asegúrate de que este código se ejecute después de Fancybox
function detalleConteo(id_grupo) {
    mostrarCarga(); // Muestra el spinner de carga

    // Utiliza el id_grupo_conteo para cargar el contenido de la modal
    Fancybox.show([
        {
            src: `resumenConteo.php?id_grupo=${id_grupo}`,
            type: 'ajax',
            on: {
                done: (fancybox, slide) => {
                    ocultarCarga();
                },
                error: (fancybox, slide) => {
                    // Se ejecuta si hay un error al cargar el contenido
                    ocultarCarga();
                    console.error('Error al cargar la modal:', slide.error);
                }
            }
        }
    ]);
}


function aprobarConteo(id_conteo) {
    Fancybox.show([
        {
            src: `aprobar_conteo.php?id_conteo=${id_conteo}`,
            type: 'ajax',
            on: {
                done: (fancybox, slide) => {

                },
                error: (fancybox, slide) => {
                    // Hay un error. Oculta el spinner.

                    console.error('Error al cargar la modal:', slide.error);
                }
            }
        }
    ]);
}

function RechazarConteo(id_conteo) {
    Fancybox.show([
        {
            src: `rechazar_conteo.php?id_conteo=${id_conteo}`,
            type: 'ajax',
            on: {
                done: (fancybox, slide) => {

                },
                error: (fancybox, slide) => {
                    // Hay un error. Oculta el spinner.

                    console.error('Error al cargar la modal:', slide.error);
                }
            }
        }
    ]);
}