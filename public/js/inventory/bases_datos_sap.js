$(document).ready(function () {

    // 💡 CAMBIO CLAVE: Delegación de eventos. Funciona aunque el modal cargue un segundo después.
    $(document).on('submit', '#formBdsSap', async function (e) {
        e.preventDefault();
        
        // Verificamos si la función existe antes de llamarla para que no rompa el JS
        if (typeof mostrarCarga === 'function') {
            mostrarCarga();
        }

        // 'this' ahora hace referencia al formulario que disparó el evento
        const formData = new FormData(this);

        // Agregamos acción como campo adicional
        formData.append('action', 'migration_bds_sap');

        try {
            // Ruta absoluta para evitar la redirección que nos daba el error de Método No Permitido
            const response = await fetch('/inventario/src/App/Pages/Handler/inventory/bases_datos_sapHandler.php', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error(`Error del servidor: ${response.status}`);
            }

            const resultado = await response.json();

            if (typeof ocultarCarga === 'function') {
                ocultarCarga();
            }

            if (resultado.success) {
                notification('success', 'Se migró la información de SAP.', 2000);

                setTimeout(function () {
                    if (typeof Fancybox !== 'undefined' && Fancybox.getInstance()) {
                        Fancybox.getInstance().close();
                    }

                    const urlActual = window.location.href.split('?')[0];
                    const parametroCache = `?timestamp=${new Date().getTime()}`;
                    window.location.href = urlActual + parametroCache;
                }, 3000);
            } else {
                notification('error', resultado.message || 'Error desconocido.', 8000);
            }

        } catch (error) {
            if (typeof ocultarCarga === 'function') {
                ocultarCarga();
            }
            console.error("Error en la petición:", error);
            notification('error', error.message, 5000);
        }
    });

});