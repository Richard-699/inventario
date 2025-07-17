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
            "url": '../../Handler/auth/almacenesHandler.php',
            "dataSrc": ""
        },
        "columns": [
            { "data": "cedula_administrador", "className": "dt-center" },
            {
                data: null,
                className: "dt-center",
                render: function (data, type, row) {
                    return `${row.nombre_administrador} ${row.apellidos_administrador}`;
                }
            },
            { "data": "correo_hwi_administrador", "className": "dt-center" },  
            {
                "data": "id_administrador",
                "className": "dt-center",
                "render": function (data, type, row) {
                    if (row.estado_administrador == 1) {
                        return `
                            <button class="btn btn-primary btn-sm" onclick="update(this, '${data}', 'update')">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                        `;
                    } else {
                        return `
                            <button class="btn btn-success btn-sm me-1" onclick="update(this, '${data}', 'approve')">
                                <i class="bi bi-check-lg"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="rechazar(this, '${data}')">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        `;
                    }
                }
            }        
        ],
        "responsive": true,
        "ordering": true,
        "info": true,
        "searching": true
    });
});

async function update(btn, id, action) {
    mostrarCarga();
    btn.disabled = true;

    try {
        const responseCelulas = await fetch('../../../public/router/router.php?action=obtener_celulas', {
            method: 'GET'
        });        
        const celulas = await responseCelulas.json();
        const celulasEncoded = encodeURIComponent(JSON.stringify(celulas));

        const responsePermisos = await fetch('../../../public/router/router.php?action=obtener_permisos', {
            method: 'GET'
        });
        const permisos = await responsePermisos.json();
        const permisosEncoded = encodeURIComponent(JSON.stringify(permisos));

        let tieneCelulas = false;
        var url = `../partials/administradorCelulasPermisos.php?celulas=${celulasEncoded}&permisos=${permisosEncoded}&action=${action}&id_administrador=${id}`;

        if(action == 'update'){
            const responsePermisosSelected = await fetch(`../../../public/router/router.php?action=obtener_permisosAdministrador&id=${id}`, {
                method: 'GET'
            });
            const permisosSelected = await responsePermisosSelected.json();
            const permisosSelectedEncoded = encodeURIComponent(JSON.stringify(permisosSelected));

            const responseCelulasSelected = await fetch(`../../../public/router/router.php?action=obtener_celulasAdministrador&id=${id}`, {
                method: 'GET'
            });
            const celulasSelected = await responseCelulasSelected.json();
            const celulasSelectedEncoded = encodeURIComponent(JSON.stringify(celulasSelected));
            url = `../partials/administradorCelulasPermisos.php?celulas=${celulasEncoded}&permisos=${permisosEncoded}&action=${action}&id_administrador=${id}&celulasSelected=${celulasSelectedEncoded}&permisosSelected=${permisosSelectedEncoded}`;
            
            if (Array.isArray(celulasSelected) && celulasSelected.length > 0) {
                tieneCelulas = celulasSelected.some(c => c.id_celulas_areas_administradores);
            }
        }

        Fancybox.show([{
            src: url,
            type: 'ajax'
        }]);

        setTimeout(() => {
            ocultarCarga();
            $('.select2').select2({
                dropdownParent: document.querySelector('.fancybox__container')
            });

            if (tieneCelulas) {
                $('#contenedorCelulas').removeClass('d-none');
            }else {
                $('#contenedorCelulas').addClass('d-none');
            }

            $(document).on('mousedown mouseup click', '.select2-selection__choice__remove', function (e) {
                e.stopPropagation();
                e.stopImmediatePropagation();
                return false;
            });

            $(document).on('mousedown mouseup click', '.select2-container', function (e) {
                e.stopPropagation();
            });

            $(document).on('mousedown mouseup click', '.select2-dropdown', function (e) {
                e.stopPropagation();
            });

            Fancybox.getInstance().options = {
                ...Fancybox.getInstance().options,
                click: false
            };
        }, 100);
    } catch (error) {
        console.error('Error al cargar la modal:', error);
    } finally {
        btn.disabled = false;
    }
}

async function rechazar(btn, id) {
    const confirmado = await mostrarConfirmacion({
        titulo: '¿Deseas rechazar este administrador?',
        texto: 'Una vez rechazado, no se podrá revertir.',
        icono: 'warning',
        textoConfirmar: 'Sí, rechazar',
        textoCancelar: 'Cancelar'
    });

    if (!confirmado) return;

    mostrarCarga();
    btn.disabled = true;
    try {
        const response = await fetch('../../../public/router/router.php?action=delete_administrador', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ 
                id: id
             })
        });

        const data = await response.json();
        ocultarCarga();

        if (data.success) {
            notification('success', 'Se rechazó el administrador.', 2000);
        } else {
            notification('error', 'Falló al rechazar el administrador, intenta nuevamente.', 2000);
        }
    } catch (error) {
        ocultarCarga();
        console.error('Error al rechazar:', error);
        btn.disabled = false;
    }
}
