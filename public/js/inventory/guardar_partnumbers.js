$(document).ready(function () {

    const btnAgregar = document.getElementById('btn-agregar');
    const contenedor = document.getElementById('secciones-partnumbers');
    const template = document.getElementById('template-partnumber').content;

    const agregarSeccion = (esPrimera = false) => {
        const clone = document.importNode(template, true);
        const seccion = clone.querySelector('.seccion-partnumber');

        if (esPrimera) {
            const btnEliminar = seccion.querySelector('.btn-eliminar-seccion');
            if (btnEliminar) btnEliminar.remove();
        } else {
            seccion.querySelector('.btn-eliminar-seccion').addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                e.target.closest('.seccion-partnumber').remove();
            });
        }

        contenedor.appendChild(clone);
    };

    btnAgregar.addEventListener('click', () => agregarSeccion());
    agregarSeccion(true);

    document.getElementById('formAgregarPartnumbers').addEventListener('submit', async function (e) {
        e.preventDefault();
        mostrarCarga();

        const form = document.getElementById('formAgregarPartnumbers');
        const formData = new FormData(form);

        // Convertimos FormData en un objeto plano
        const formObj = {};

        formData.forEach((value, key) => {
            const cleanKey = key.replace(/\[\]$/, '');
            if (formObj[cleanKey] === undefined) {
                formObj[cleanKey] = [value];
            } else {
                formObj[cleanKey].push(value);
            }
        });

        const action = 'guardar_partnumber';

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
                notification('success', 'Se registraron los partnumbers.', 2000);

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



