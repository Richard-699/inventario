$(document).ready(function () {
    console.log("js cargadop")

    // funcionalidad del para el conteo de caracteres en el textArea
    window.updateCharCount = function () {
        const textarea = document.getElementById('observaciones');
        const charCount = document.getElementById('charCount');
        if (!textarea || !charCount) return;
        const maxLength = textarea.getAttribute('maxlength') || 500;
        const currentLength = textarea.value.length;
        charCount.textContent = `${currentLength} / ${maxLength} carácteres`;
    };
    $('#observaciones').on('input', window.updateCharCount);
    window.updateCharCount();

    /* evento para enviar el formulario */
    document.getElementById('formConteoStock').addEventListener('submit', async function (e) {
        e.preventDefault();
        mostrarCarga();

        const form = document.getElementById('formConteoStock');
        const formData = new FormData(form);

        const formObj = {};
        formData.forEach((value, key) => {
            if (formObj[key] === undefined) {
                formObj[key] = value;
            } else {
                formObj[key] = [formObj[key], value];
            }
        });

        const action = 'guardar_stock';

        try {
            const response = await fetch('../../Handler/inventory/stockHandler.php', {
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
                notification('success', 'Se registró el conteo.', 2000);

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

function updateCharCount() {
    const textarea = document.getElementById('observaciones');
    const charCount = document.getElementById('charCount');
    const maxLength = textarea.getAttribute('maxlength');
    const currentLength = textarea.value.length;

    charCount.textContent = `${currentLength} / ${maxLength} caracteres`;
}
// Exponer al scope global
window.updateCharCount = updateCharCount;