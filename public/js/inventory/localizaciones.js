$(document).ready(function () {
    $('#tabla-administradores').DataTable({
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
            "url": '../../Handler/inventory/localizacionesHandler.php?action=onGet_localizaciones',
            "dataSrc": ""
        },
        "columns": [
            { "data": "id_localizacion", "className": "dt-center" },
            { "data": "tipo_localizacion", "className": "dt-center" },
            { "data": "descripcion_localizacion", "className": "dt-center" },
            {
                "data": "id_localizacion",
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

});




