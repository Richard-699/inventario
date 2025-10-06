const id_grupo = obtenerParametroURL('id_grupo');
if (!id_grupo) {
    window.location.href = 'cronograma.php';
}

mostrarCarga();

$(document).ready(function () {
    // Al cargar la página, primero obtenemos la información del grupo de forma asíncrona.
    obtenerInfoGrupo(id_grupo);
    obtenerInfoCronograma(id_grupo);
    // Evento para el botón de agregar Excel. Se mantiene sin cambios.
    document.getElementById('btnAgregarExcel').addEventListener('click', async function () {
        mostrarCarga();
        let btn = this;
        btn.disabled = true;

        try {
            Fancybox.show([{
                src: `bases_datos_sap.php?id_grupo=${id_grupo}`,
                type: 'ajax'
            }]);

            setTimeout(() => {
                ocultarCarga();
                Fancybox.getInstance().options = {
                    ...Fancybox.getInstance().options,
                    click: false,
                    trapFocus: false,
                    placeFocusBack: false
                };
            }, 100);

        } catch (error) {
            console.error('Error al cargar la modal:', error);
        } finally {
            ocultarCarga();
            btn.disabled = false;
        }
    });

    // Evento para el botón de agregar Excel. Se mantiene sin cambios.
    document.getElementById('btnFinalizar').addEventListener('click', async function () {
        mostrarCarga();
        let btn = this;
        btn.disabled = true;

        try {
            Fancybox.show([{
                src: `finalizar_conteo.php?id_grupo=${id_grupo}`,
                type: 'ajax'
            }]);

            setTimeout(() => {
                ocultarCarga();
                Fancybox.getInstance().options = {
                    ...Fancybox.getInstance().options,
                    click: false,
                    trapFocus: false,
                    placeFocusBack: false
                };
            }, 100);

        } catch (error) {
            console.error('Error al cargar la modal:', error);
        } finally {
            ocultarCarga();
            btn.disabled = false;
        }
    });

    // Evento para el botón de ver resumen.
    document.getElementById('btnResumen').addEventListener('click', async function () {
        mostrarCarga();
        let btn = this;
        btn.disabled = true;

        try {
            Fancybox.show([{
                src: `resumenConteo.php?id_grupo=${id_grupo}`,
                type: 'ajax'
            }]);

            setTimeout(() => {
                ocultarCarga();
                Fancybox.getInstance().options = {
                    ...Fancybox.getInstance().options,
                    click: false,
                    trapFocus: false,
                    placeFocusBack: false
                };
            }, 100);

        } catch (error) {
            console.error('Error al cargar la modal:', error);
        } finally {
            ocultarCarga();
            btn.disabled = false;
        }
    });
});

function obtenerParametroURL(nombre) {
    const params = new URLSearchParams(window.location.search);
    return params.get(nombre);
}

// Esta función ahora maneja toda la inicialización de la tabla.
async function obtenerInfoGrupo(id_grupo) {
    try {
        const response = await fetch(`../../Handler/inventory/partnumbersGrupoHandler.php?action=onGet_info_grupo&id_grupo=${id_grupo}`);
        const data = await response.json();
        let informacionMigradaSAPGrupo = 0;
        if (data.informacion_migrada_sap_grupo !== undefined) {
            informacionMigradaSAPGrupo = data.informacion_migrada_sap_grupo;
        }

        // Se inicializa el DataTable aquí, después de obtener los datos.
        $('#tabla-partnumbers-grupo').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            },
            lengthMenu: [
                [10, 50, 100, 200, -1],
                [10, 50, 100, 200, "Todos"]
            ],
            "scrollCollapse": true,
            "paging": true,
            pageLength: 10,
            "ajax": {
                "url": `../../Handler/inventory/partnumbersGrupoHandler.php?action=onGet_partnumbers&id_grupo=${id_grupo}`,
                "dataSrc": function (json) {
                    if (json.length > 0) {
                        const nombreGrupo = json[0].grupo;
                        document.querySelector('h5.m-0.fw-semibold.text-dark').textContent = `PartNumbers - ${nombreGrupo}`;
                    }
                    return json;
                }
            },
            "columns": [
                { "data": "id_partnumber", "className": "dt-center" },
                { "data": "partnumber", "className": "dt-center" },
                { "data": "umb", "className": "dt-center" },
                { "data": "nombre_interno", "className": "dt-center" },
                { "data": "grupo", "className": "dt-center" },
                { "data": "plataforma", "className": "dt-center" },
                {
                    "data": "id_partnumber",
                    "className": "dt-center",
                    "render": function (data, type, row) {
                        // El valor de informacionMigradaSAPGrupo ya es el correcto aquí.
                        if (informacionMigradaSAPGrupo == 1) {
                            return `<button class="btn btn-primary btn-sm" onclick="continuarAlmacen(this, '${data}')"><i class="fa-solid fa-warehouse"></i></button>`;
                        } else {
                            return `
                                <div title="Para continuar con el conteo, primero debe importar la información del grupo.">
                                    <button class="btn btn-primary btn-sm" disabled><i class="fa-solid fa-warehouse"></i></button>
                                </div>
                                `;
                        }
                    }
                }
            ],
            "responsive": true,
            "ordering": true,
            "info": true,
            "searching": true
        });

    } catch (error) {
        console.error("Error al obtener la información del grupo:", error);
    }
}


async function obtenerInfoCronograma(id_grupo) {
    const controller = new AbortController();
    const timeoutMs = 10000;
    const timeoutId = setTimeout(() => controller.abort(), timeoutMs);

    try {
        if (!id_grupo) throw new Error("id_grupo no proporcionado");

        const url = `../../Handler/inventory/partnumbersGrupoHandler.php?action=onGet_info_cronograma&id_grupo=${encodeURIComponent(id_grupo)}`;
        const response = await fetch(url, { signal: controller.signal });

        clearTimeout(timeoutId);

        if (!response.ok) {
            const txt = await response.text().catch(() => "");
            throw new Error(`HTTP ${response.status} ${response.statusText} ${txt}`);
        }

        let data = null;
        try {
            data = await response.json();
        } catch (err) {
            throw new Error("Respuesta no es JSON válido: " + err.message);
        }

        // obtiene el estado de forma segura
        const id_estado_cronograma = Number(
            data && (data.id_estado_cronograma ?? data.estado ?? data.status)
        ) || 0;
        console.log("id_estado_cronograma:", id_estado_cronograma);

        const botonFinalizar = document.getElementById("btnFinalizar");
        const botonMigracionSap = document.getElementById("btnAgregarExcel");

        // ids que bloquean botón Finalizar
        const idsPendientes = [1, 3, 4, 5, 6];
        const disableFinalizar = idsPendientes.includes(id_estado_cronograma);

        // id que bloquea botón Migración (según tu lógica original)
        const disableMigracion = id_estado_cronograma === 3;

        aplicarEstadoBoton(
            botonFinalizar,
            "No puedes finalizar el conteo de un grupo en estado pendiente.",
            disableFinalizar
        );

        aplicarEstadoBoton(
            botonMigracionSap,
            "No puedes importar la información de un grupo que está a espera de aprobación de un conteo ya hecho previamente.",
            disableMigracion
        );

        return data;
    } catch (error) {
        if (error.name === "AbortError") {
            console.error("La solicitud fue abortada por timeout.");
        } else {
            console.error("Error al obtener la información del cronograma:", error);
        }
        return null;
    } finally {
        clearTimeout(timeoutId);
        try { ocultarCarga?.(); } catch (e) { }
    }
}

function aplicarEstadoBoton(boton, mensaje, disable) {
    if (!boton) return;

    // aplicar estado básico
    boton.disabled = disable;
    boton.setAttribute("aria-disabled", String(disable));
    boton.classList.toggle("disabled", disable);

    // helper para saber si el padre contiene más de un botón
    const parent = boton.parentElement;
    const parentButtonsCount = parent ? parent.querySelectorAll("button").length : 0;

    // Nombre del atributo que usaremos para marcar el wrapper temporal
    const TEMP_WRAPPER_ATTR = "data-tooltip-wrapper";

    if (disable) {
        // siempre asignamos title al botón (por si el navegador lo muestra)
        boton.setAttribute("title", mensaje);

        // Si el padre solo contiene este botón, podemos usar el padre
        if (parent && parentButtonsCount === 1) {
            parent.setAttribute("title", mensaje);
            return;
        }

        // Si el padre contiene varios botones, envolvemos SOLO este botón
        // en un <span> temporal con title para que el tooltip sea único.
        const currentParent = boton.parentElement;
        // Si ya está envuelto, sólo actualizamos el title
        if (currentParent && currentParent.hasAttribute(TEMP_WRAPPER_ATTR)) {
            currentParent.setAttribute("title", mensaje);
            return;
        }

        // Crear wrapper si hace falta
        const span = document.createElement("span");
        span.setAttribute(TEMP_WRAPPER_ATTR, "true");
        span.style.display = "inline-block"; // mantener flujo inline
        span.title = mensaje;

        // Reemplazar el botón por el span y mover el botón dentro del span
        if (currentParent) {
            currentParent.replaceChild(span, boton);
            span.appendChild(boton);
        } else {
            // si por alguna razón no hay parent, no hacemos nada extra
            boton.setAttribute("title", mensaje);
        }

    } else {
        // habilitado -> limpiar title y quitar wrapper temporal si existe
        boton.removeAttribute("title");

        if (parent && parent.hasAttribute(TEMP_WRAPPER_ATTR)) {
            // si fue creado un wrapper temporal, desempaquetamos el botón
            const wrapper = parent;
            const grandParent = wrapper.parentElement;
            if (grandParent) {
                // reemplazamos el wrapper por el botón directamente
                grandParent.replaceChild(boton, wrapper);
            } else {
                // fallback: quitar atributo y dejar como está
                wrapper.removeAttribute("title");
                wrapper.removeAttribute(TEMP_WRAPPER_ATTR);
            }
        } else if (parent) {
            // si usamos title en el padre (porque era único), lo quitamos
            parent.removeAttribute("title");
        }
    }
}

async function continuarAlmacen(btn, id) {
    mostrarCarga();
    btn.disabled = true;

    try {
        const responseInfoSAP = await fetch(`../../Handler/inventory/partnumbersGrupoHandler.php?action=onGet_InformacionSAP&id_partnumber=${encodeURIComponent(id)}`, {
            method: 'GET'
        });

        const InfoSAP = await responseInfoSAP.json();
        const InfoSAPEncoded = encodeURIComponent(JSON.stringify(InfoSAP));

        var url = `options_almacenes.php?informacionSAP=${InfoSAPEncoded}&id_partnumber=${encodeURIComponent(id)}&id_grupo=${id_grupo}`;

        Fancybox.show([{
            src: url,
            type: 'ajax'
        }]);

        setTimeout(() => {
            ocultarCarga();
            Fancybox.getInstance().options = {
                ...Fancybox.getInstance().options,
                click: false,
                trapFocus: false,
                placeFocusBack: false
            };
        }, 100);

    } catch (error) {
        console.error('Error al cargar la modal:', error);
    } finally {
        btn.disabled = false;
    }
}