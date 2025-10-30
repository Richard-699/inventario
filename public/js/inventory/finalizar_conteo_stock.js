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

    // 3. Hacer una consulta GET al handler al cargar la página
    const handlerUrl = '../../Handler/inventory/stockHandler.php';
    const params = {
        action: 'onGet_InfoCronograma',
        id_grupo: document.getElementById("id_grupo").value
    };

    // Solo hacer la petición si tenemos id_conteo (evita llamadas innecesarias)
    mostrarCarga();
    if (params.id_grupo) {
        $.ajax({
            url: handlerUrl,
            method: 'GET',
            data: params,
            dataType: 'json',
            success: function (resp) {
                if (resp && resp.success) {
                    // Lógica para validar el id_estado_cronograma
                    const estado = resp.id_estado_cronograma;
                    const otroConteoSection = $('#seccion_reconteo');
                    const otroConteoLabel = $('#label-reconteo');
                    const id_estado_cronograma = $('#id_estado_cronograma');
                    id_estado_cronograma.val(estado)
                    if (estado == 2) {
                        otroConteoLabel.text('¿Desea hacer un conteo 2 de este grupo?');
                        otroConteoSection.show();
                    } else if (estado == 8) {
                        otroConteoLabel.text('¿Desea hacer un conteo 3 de este grupo?');
                        otroConteoSection.show();
                    } else if (estado == 9) {
                        otroConteoSection.hide();
                    } else {
                        // Ocultar por defecto o manejar otros estados si es necesario
                        otroConteoSection.hide();
                    }

                } else {
                    console.warn('Handler respondió con error:', resp && resp.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error en AJAX GET a handler:', textStatus, errorThrown);
            }
        });
    } else {
        console.warn('No se encontró data-id-grupo en el formulario; no se realizará GET al handler.');
    }
    ocultarCarga();

    // 4. Lógica para el envío del formulario.
    $('#form_finalizar_conteo_stock').on('submit', function (e) {
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

        // Validar si el campo de reconteo está visible y es requerido
        const reconteoSection = $('#seccion_reconteo');
        if (reconteoSection.is(':visible')) {
            const otroConteoValue = $('input[name="otro_conteo"]:checked').val();
            if (!otroConteoValue) {
                notification('warning', 'Debe seleccionar una opción para el reconteo.', 3000);
                submitBtn.prop('disabled', false);
                ocultarCarga();
                return; // Detiene el envío del formulario
            }
        }

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
                    location.reload();
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