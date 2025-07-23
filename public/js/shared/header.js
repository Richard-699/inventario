function Inicio() {
    mostrarCarga();
    window.location.href = "index.php";
}

function Almacen() {
    mostrarCarga();
    window.location.href = "almacenes.php";
}

function Localizaciones() {
    mostrarCarga();
    window.location.href = "localizaciones.php";
}

function Grupos() {
    mostrarCarga();
    window.location.href = "grupos.php";
}

function GestionarAdministradores() {
    mostrarCarga();
    window.location.href = "administradores.php";
}

document.querySelectorAll('#BtnCerrarSesion, #BtnCerrarSesionMenu').forEach(btn => {
    btn.addEventListener('click', function (e) {
        debugger;
        e.preventDefault();
        mostrarCarga();

        setTimeout(() => {
            window.location.href = '../auth/log_out.php';
        }, 1200);
    });
});

