$(document).ready(function () {

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
                "data": "id_grupo_cronograma",
                "className": "dt-center",
                "render": function (data, type, row) {
                    return `
                            <button class="btn btn-primary btn-sm" onclick="abrirDetalleCronograma('${data}')">
                                <i class="fa-solid fa-list-ul"></i>
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
});

async function abrirDetalleCronograma(id) {
    const url = `partnumbersGrupo.php?id_grupo=${id}`;
    window.open(url, '_blank');
}



