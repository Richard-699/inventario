$(document).ready(function () {
    // Función para actualizar el contador de caracteres
    function updateCharCount() {
        const textarea = document.getElementById('observaciones');
        const charCount = document.getElementById('charCount');
        if (!textarea || !charCount) {
            return;
        }
        const maxLength = textarea.getAttribute('maxlength') || 0;
        const currentLength = textarea.value.length;
        charCount.textContent = `${currentLength} / ${maxLength} caracteres`;
    }

    // 1. Inicializar el contador al cargar la página.
    updateCharCount();

    // 2. Vincular el evento 'input' al textarea para actualizar el contador en tiempo real.
    $('#observaciones').on('input', updateCharCount);

    
    // 4. Lógica para el envío del formulario.
    $('#form_aprobar_conteo').on('submit', function (e) {
        debugger;
        e.preventDefault();

        // Bloquear el botón para evitar múltiples envíos
        const submitBtn = $('#btn-save');
        submitBtn.prop('disabled', true);
        mostrarCarga();

        // Obtener los datos del formulario en un array de objetos
        const formDataArray = $(this).serializeArray();

        // Convertir el array a un objeto para estructurar el JSON
        const formObject = {};
        $.each(formDataArray, function (i, field) {
            formObject[field.name] = field.value;
        });

        // Construir el objeto JSON final que incluye la acción y los datos del formulario
        const requestData = {
            action: "finalizar_Conteo",
            form: formObject
        };

        // Realizar la petición AJAX
        $.ajax({
            url: handlerUrl,
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(requestData),
            dataType: 'json',
            success: function (resp) {
                if (resp.success) {
                    notification('success', resp.message || 'El conteo se finalizó correctamente.', 3000);
                    // Opcional: Cerrar la Fancybox o redirigir al usuario
                    setTimeout(function () {
                        if (Fancybox.getInstance()) {
                            Fancybox.getInstance().close();
                        }
                    }, 2000);
                    // Puedes recargar la tabla principal si es necesario
                } else {
                    notification('error', resp.message || 'Hubo un error al finalizar el conteo.', 3000);
                    console.warn('Handler respondió con error:', resp.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                notification('error', 'Error en la comunicación con el servidor. Intente de nuevo.', 3000);
                console.error('Error en AJAX POST a handler:', textStatus, errorThrown);
            },
            complete: function () {
                ocultarCarga();
                submitBtn.prop('disabled', false); // Habilitar el botón nuevamente
            }
        });
    });
});