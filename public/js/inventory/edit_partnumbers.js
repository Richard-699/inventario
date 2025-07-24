$(document).ready(function () {

    document.getElementById('formUpdatePartNumbers').addEventListener('submit', async function (e) {
        e.preventDefault();
        mostrarCarga();

        const form = document.getElementById('formUpdatePartNumbers');
        const formData = new FormData(form);

        // Convertimos FormData en un objeto plano
        const formObj = {};
        formData.forEach((value, key) => {
            if (formObj[key] === undefined) {
                formObj[key] = value;
            } else {
                formObj[key] = [formObj[key], value];
            }
        });

        const action = 'edit_partnumber';

        try {
            const response = await fetch('../../Handler/inventory/partnumbersHandler.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: action,
                    form: formObj
                })
            });

            const resultado = await response.json();

            ocultarCarga();

            if (resultado.success) {
                notification('success', 'Se actualizó el partnumber.', 2000);

                setTimeout(function () {

                    if (Fancybox.getInstance()) {
                        Fancybox.getInstance().close();
                    }

                    location.reload();
                }, 2000);
            } else {
                notification('error', resultado.message, 4000);
            }
        } catch (error) {
            ocultarCarga();
            notification('error', error.message, 3000);
        }
    });

});



