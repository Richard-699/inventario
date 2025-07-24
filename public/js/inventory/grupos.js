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
            "url": '../../Handler/inventory/gruposHandler.php?action=onGet_grupos',
            "dataSrc": ""
        },
        "columns": [
            { "data": "id_grupo", "className": "dt-center" },
            { "data": "descripcion_grupo", "className": "dt-center" },
            {
                "data": "id_grupo",
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


    document.getElementById('btnAgregarGrupo').addEventListener('click', function () {
        const url = 'agregar_grupos.php';
        Fancybox.show([{
            src: url,
            type: 'ajax'
        }]);
    });
});

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



