$(document).ready(function () {

    $('#tabla-exactitud').DataTable({
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
            "url": '../../Handler/inventory/exactitudHandler.php?action=onGet_exactitud',
            "dataSrc": ""
        },
        "columns": [
            { "data": "partnumber_exactitud", "className": "dt-center" },
            { "data": "descripcion_partnumber_exactitud", "className": "dt-center" },
            { "data": "tipo_almacen_exactitud", "className": "dt-center" },
            { "data": "area_almacenamiento_exactitud", "className": "dt-center" },
            { "data": "localizacion_exactitud", "className": "dt-center" },
            { "data": "coincide_exactitud", "className": "dt-center" },
            { "data": "fecha_hora_migracion_exactitud", "className": "dt-center" },
            {
                "data": "id_exactitud",
                "className": "dt-center",
                "render": function (data, type, row) {
                    return `
                            <button class="btn btn-primary btn-sm" onclick="DiligenciarExactitud('${data}')">
                                <i class="bi bi-pencil-square"></i>
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

    // Evento para el botón de importar bd sap para exactitud
    document.getElementById('btnMigrarSapExactitud').addEventListener('click', async function () {
        mostrarCarga();
        let btn = this;
        btn.disabled = true;

        try {
            Fancybox.show([{
                src: `bases_datos_sap_exactitud.php`,
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


async function DiligenciarExactitud(id_exactitud) {
    mostrarCarga();
    try {
        Fancybox.show([{
            src: `formulario_exactitud.php?id_exactitud=${id_exactitud}`,
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
}