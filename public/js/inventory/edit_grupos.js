$(document).ready(function () {
    // 1. Inicialización de la Modal
    const idGrupo = $('#id_grupo').val();
    if (idGrupo) {
        // Ejecutamos la carga inicial
        initModal(idGrupo);
    }

    // 2. Evento Submit para Guardar
    const form = document.getElementById('formUpdateGrupo');
    if (form) {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            mostrarCarga();

            const formData = new FormData(this);
            const formObj = {};

            // Conversión de FormData a Objeto (soporta múltiples valores para el select)
            formData.forEach((value, key) => {
                if (formObj[key] === undefined) {
                    formObj[key] = value;
                } else if (Array.isArray(formObj[key])) {
                    formObj[key].push(value);
                } else {
                    formObj[key] = [formObj[key], value];
                }
            });

            try {
                const response = await fetch('../../Handler/inventory/gruposHandler.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        action: "updateGrupo",
                        form: formObj
                    })
                });

                const resultado = await response.json();
                ocultarCarga();

                if (resultado.success) {
                    notification('success', 'Se actualizó la información correctamente.', 2000);
                    
                    // Esperamos a que la notificación se vea y cerramos
                    setTimeout(() => {
                        if (Fancybox.getInstance()) {
                            Fancybox.getInstance().close();
                        }
                        // Forzamos la recarga de la página principal para limpiar cualquier estado
                        window.location.reload();
                    }, 1500);
                } else {
                    notification('error', resultado.message || 'Error al actualizar', 4000);
                }
            } catch (error) {
                ocultarCarga();
                console.error("Error en submit:", error);
                notification('error', 'Error de red o del servidor.', 3000);
            }
        });
    }

    // Listener para el botón cerrar de Fancybox (X)
    $(document).on('click', '.carousel__button.is-close', function() {
        window.location.reload();
    });
});

/**
 * Función para cargar los datos en la modal
 * @param {string|number} id - ID del grupo a editar
 */
async function initModal(id) {
    try {
        // --- CORRECCIÓN 1: Limpieza de instancia previa ---
        const selectEl = document.getElementById('part_numbers_select');
        if (selectEl && selectEl.choices) {
            selectEl.choices.destroy();
        }

        // --- CORRECCIÓN 2: Pequeño retardo (Anti-race condition) ---
        // Esperamos 300ms para asegurar que el servidor procesó cualquier cambio previo
        await new Promise(resolve => setTimeout(resolve, 300));

        // --- CORRECCIÓN 3: Timestamp único para burlar el caché ---
        const timestamp = new Date().getTime();

        const [respPartnumbers, respGrupo] = await Promise.all([
            fetch(`../../Handler/inventory/gruposHandler.php?action=onGet_partnumbers&_t=${timestamp}`),
            fetch(`../../Handler/inventory/gruposHandler.php?action=onGet_grupo_By_id&id_grupo=${id}&_t=${timestamp}`)
        ]);

        const allPartnumbers = await respPartnumbers.json();
        const grupo = await respGrupo.json();

        // Debug en consola para verificar qué está llegando realmente
        console.log("Datos recibidos del servidor:", grupo);

        // Llenar campos de texto y ocultos
        $('#descripcion_grupo').val(grupo.descripcion_grupo);
        $('#fecha_programacion_grupo').val(grupo.fecha_programacion_grupo);
        $('#informacion_migrada_sap_grupo').val(grupo.informacion_migrada_sap_grupo);

        // --- CORRECCIÓN 4: Inicialización limpia de Choices.js ---
        const choices = new Choices(selectEl, {
            removeItemButton: true,
            searchEnabled: true,
            placeholderValue: 'Busca part numbers...',
            shouldSort: false,
            loadingText: 'Cargando...',
            noResultsText: 'No se encontraron resultados'
        });

        // Mapear y filtrar los partnumbers
        const choicesData = allPartnumbers.map(p => {
            const isSelected = String(p.id_grupo_partnumber) === String(id);
            const isAvailable = !p.id_grupo_partnumber || 
                                p.id_grupo_partnumber === 'No asignado' || 
                                p.id_grupo_partnumber === null ||
                                isSelected;

            if (isAvailable) {
                return {
                    value: String(p.id_partnumber),
                    label: `${p.partnumber} - ${p.descripcion_breve}`,
                    selected: isSelected
                };
            }
            return null;
        }).filter(opt => opt !== null);

        // Inyectar las opciones al select
        choices.setChoices(choicesData, 'value', 'label', true);
        
        // Guardar la instancia en el elemento para poder destruirla después si es necesario
        selectEl.choices = choices;

        ocultarCarga();

    } catch (error) {
        console.error("Error en initModal:", error);
        notification('error', "No se pudo cargar la información actualizada", 3000);
        ocultarCarga();
    }
}