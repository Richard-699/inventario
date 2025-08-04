$(document).ready(function () {

    document.getElementById('formBdsSap').addEventListener('submit', async function (e) {
        e.preventDefault();
        mostrarCarga();

        const form = document.getElementById('formBdsSap');
        const formData = new FormData(form);

        // Agregamos acción como campo adicional
        formData.append('action', 'migration_bds_sap');

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
                    location.reload();
                }, 2000);
            } else {
                notification('error', resultado.message || 'Error desconocido.', 5000);
            }

        } catch (error) {
            ocultarCarga();
            notification('error', error.message, 5000);
        }
    });

});