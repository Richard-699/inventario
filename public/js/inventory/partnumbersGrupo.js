$(document).ready(function () {

    const id_grupo = obtenerParametroURL('id_grupo');
    if (!id_grupo) {
        window.location.href = 'cronograma.php';
    }

    $('#tabla-partnumbers-grupo').DataTable({
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
            "url": `../../Handler/inventory/partnumbersGrupoHandler.php?action=onGet_partnumbers&id_grupo=${id_grupo}`,
            "dataSrc": function (json) {
                if (json.length > 0) {
                    const nombreGrupo = json[0].grupo;
                    document.querySelector('h5.m-0.fw-semibold.text-dark').textContent = `PartNumbers - ${nombreGrupo}`;
                }
                return json;
            }
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
                            <button class="btn btn-primary btn-sm" onclick="continuarAlmacen(this, '${data}')">
                                <i class="fa-solid fa-warehouse"></i>
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

    document.getElementById('btnAgregarExcel').addEventListener('click', async function () {
        mostrarCarga();

        let btn = this;
        btn.disabled = true;

        try {
            Fancybox.show([{
                src: "bases_datos_sap.php",
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

function obtenerParametroURL(nombre) {
    const params = new URLSearchParams(window.location.search);
    return params.get(nombre);
}

async function continuarAlmacen(btn, id) {
    mostrarCarga();
    btn.disabled = true;

    try {
        const responseInfoSAP = await fetch(`../../Handler/inventory/partnumbersGrupoHandler.php?action=onGet_InformacionSAP&id_partnumber=${encodeURIComponent(id)}`, {
            method: 'GET'
        });

        const InfoSAP = await responseInfoSAP.json();
        const InfoSAPEncoded = encodeURIComponent(JSON.stringify(InfoSAP));

        var url = `options_almacenes.php?informacionSAP=${InfoSAPEncoded}&id_partnumber=${encodeURIComponent(id)}`;

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
        btn.disabled = false;
    }
}