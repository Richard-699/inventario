$(document).ready(function() {

    document.getElementById('formUpdateGrupo').addEventListener('submit', async function (e) {
        e.preventDefault();
        mostrarCarga();
    
        const form = document.getElementById('formUpdateGrupo');
        const formData = new FormData(form);

        const formObj = {};
        formData.forEach((value, key) => {
            if (formObj[key] === undefined) {
                formObj[key] = value; // Asignar valor directo
            } else if (Array.isArray(formObj[key])) {
                formObj[key].push(value);
            } else {
                formObj[key] = [formObj[key], value];
            }
        });

        const action = "updateGrupo";
        debugger;
        try {
            const response = await fetch('../../Handler/inventory/gruposHandler.php', {
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
                notification('success', 'Se actualizó la información del grupo.', 2000);


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
            notification('error', 'Error de red o del servidor.', 3000);
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target.matches('.carousel__button.is-close')) {
            location.reload();
        }
    });
});
