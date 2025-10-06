$(document).ready(function () {

    document.getElementById('formBdsSapExactitud').addEventListener('submit', async function (e) {
        e.preventDefault();
        mostrarCarga();

        const form = document.getElementById('formBdsSapExactitud');
        const formData = new FormData(form);

        // Agregamos acción como campo adicional
        formData.append('action', 'migration_bds_sap_exactitud');

        try {
            const response = await fetch('../../Handler/inventory/bases_datos_sapHandler.php', {
                method: 'POST',
                body: formData
            });

            const resultado = await response.json();

            ocultarCarga();

            if (resultado.success) {
                notification('success', 'Se migró la información de SAP.', 2000);

                setTimeout(function () {
                    if (typeof Fancybox !== 'undefined' && Fancybox.getInstance()) {
                        Fancybox.getInstance().close();
                    }

                    // Obtén la URL actual y agrega un parámetro de caché aleatorio
                    const urlActual = window.location.href.split('?')[0];
                    const parametroCache = `?timestamp=${new Date().getTime()}`;

                    // Recarga la página con la nueva URL para evitar la caché
                    window.location.href = urlActual + parametroCache;
                }, 3000);
            } else {
                notification('error', resultado.message || 'Error desconocido.', 8000);
            }

        } catch (error) {
            ocultarCarga();
            notification('error', error.message, 5000);
        }
    });

});