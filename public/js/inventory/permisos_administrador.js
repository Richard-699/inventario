$(document).ready(function() {

    const permisosSelect = $('#permisos_administradores');

    document.getElementById('formUpdateAdministrador').addEventListener('submit', async function (e) {
        e.preventDefault();
        mostrarCarga();

        const permisos = $('#permisos_administradores').val();
        const celulas = $('#celulas_administradores').val();

        if (!permisos || permisos.length === 0) {
            notification('error', 'Debe seleccionar al menos un permiso', 2000);
            setTimeout(() => {
                ocultarCarga();
            }, 2500); 
            return;
        }
        if(validarCelulas){
            if (!celulas || celulas.length === 0) {
                notification('error', 'Debe seleccionar al menos una célula', 2000);
                setTimeout(() => {
                    ocultarCarga();
                }, 2500); 
                return;
            }
        }
    
        const form = document.getElementById('formUpdateAdministrador');
        const formData = new FormData(form);

        if (celulas || celulas.length > 0) {
            formData.append('tiene_celulas', true)
        }

        const action = document.getElementById('action').value;

        try {
            const response = await fetch('../../../public/router/router.php?action=updateAdministrador', {
                method: 'POST',
                body: formData
            });

            const resultado = await response.json();

            ocultarCarga();

            if (resultado.estado === 'ok') {
                if(action == 'approve'){
                    notification('success', 'Se aprobó el administrador.', 2000);
                }else{
                    notification('success', 'Se actualizó el administrador.', 2000);
                }

                setTimeout(function () {
                    window.actualizoAdministrador = true;

                    if (Fancybox.getInstance()) {
                        Fancybox.getInstance().close();
                    }

                    location.reload();
                }, 2000);
            } else {
                notification('error', resultado.mensaje || 'Error en el servidor.', 4000);
            }
        } catch (error) {
            ocultarCarga();
            notification('error', 'Error de red o del servidor.', 3000);
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target.matches('.carousel__button.is-close')) {
            location.reload();
        }
    });
});
