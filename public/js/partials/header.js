function Inicio() {
    mostrarCarga();
    window.location.href = "index.php";
}

function MostrarHorasExtras() {
    mostrarCarga();
    window.location.href = "horasExtra.php";
}

function MostrarAusentismos() {
    mostrarCarga();
    window.location.href = "ausentismos.php";
}

function GestionarAdministradores() {
    mostrarCarga();
    window.location.href = "administradores.php";
}

function ExcelAuditoriasHorasExtras() {
    mostrarCarga();
    window.location.href = "excelHorasExtrasAuditorias.php";
}

function ExcelBasicoHorasExtras() {
    mostrarCarga();
    window.location.href = "excelHorasExtrasBasico.php";
}

function ExcelBasicoAusentismos() {
    mostrarCarga();
    window.location.href = "excelAusentismosBasico.php";
}

function MiCelula() {
    mostrarCarga();
    window.location.href = "miCelula.php";
}

function FechasCorte() {
    mostrarCarga();
    window.location.href = "fechasCorte.php";
}

function PersonalJiro() {
    mostrarCarga();
    window.location.href = "personalJiro.php";
}



document.querySelectorAll('#BtnCerrarSesion, #BtnCerrarSesionMenu').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        mostrarCarga();

        setTimeout(() => {
            window.location.href = '../auth/log_out.php';
        }, 1200);
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const dropdown = document.querySelector('.celula-dropdown');
    let showTimeout;

    dropdown.addEventListener('mouseenter', function () {
        showTimeout = setTimeout(() => {
            dropdown.classList.add('show');
        }, 500);
    });

    dropdown.addEventListener('mouseleave', function () {
        clearTimeout(showTimeout);
        dropdown.classList.remove('show');
    });

    document.querySelectorAll('.cambiar-celula').forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            mostrarCarga();
            const celula = e.target.getAttribute('data-celula');

            fetch('../../../public/router/router.php?action=setCelula', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'celula=' + encodeURIComponent(celula)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        ocultarCarga();
                        console.error('Error al guardar célula:', data.error);
                    }
                });
        });
    });
});

