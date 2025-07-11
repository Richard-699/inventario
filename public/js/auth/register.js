document.addEventListener('DOMContentLoaded', async function () {
    const passwordInput = document.getElementById('inputPassword');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const passwordToggle = document.getElementById('passwordToggle');
    const cedula_administrador = document.getElementById('cedula_administrador');

    function togglePasswordIcon() {
        passwordToggle.style.display = passwordInput.value.length > 0 ? 'block' : 'none';
    }

    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const type = input.type === 'password' ? 'text' : 'password';
        input.type = type;
        const icon = document.querySelector(`[onclick="togglePassword('${inputId}')"] i`);
        icon.textContent = type === 'password' ? 'visibility' : 'visibility_off';
    }

    if (passwordInput) passwordInput.addEventListener('input', togglePasswordIcon);
    if (confirmPasswordInput) confirmPasswordInput.addEventListener('input', togglePasswordIcon);

    if (cedula_administrador) {
        cedula_administrador.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 10);
        });
    }

    window.togglePassword = togglePassword;

    const correoInput = document.getElementById('correo_hwi_administrador');
    const submitBtn = document.getElementById("btningresar");

    const errorMsg = document.createElement('div');
    errorMsg.style.color = 'red';
    errorMsg.style.fontSize = '0.9em';
    errorMsg.style.marginTop = '5px';
    errorMsg.style.textAlign = "left";
    errorMsg.style.marginLeft = "23px";
    errorMsg.textContent = 'Correo inválido';
    errorMsg.style.display = 'none';
    correoInput.parentNode.appendChild(errorMsg);

    correoInput.addEventListener('input', function () {
        const correoValido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correoInput.value);
        
        if (correoInput.value !== '' && !correoValido) {
            errorMsg.style.display = 'block';
            submitBtn.disabled = true;
        } else {
            errorMsg.style.display = 'none';
            submitBtn.disabled = !correoValido;
        }
    });

    const form = document.getElementById('formRegistro');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        mostrarCarga();

        const formData = new FormData(form);

        try {
            const response = await fetch('../../../public/router/router.php?action=register', {
                method: 'POST',
                body: formData
            });

            const resultado = await response.json();

            ocultarCarga();

            if (resultado.estado === 'ok') {
                notification('alert', 'Registro exitoso, debes esperar la aprobación.', 3000);
                setTimeout(() => window.location.href = 'login.php', 4000);
            } else if (resultado.estado === 'existe') {
                notification('error', 'Ya se encontraba registrado, inicia sesión.', 3000);
                setTimeout(() => window.location.href = 'login.php', 4000);
            } else {
                notification('error', 'Ocurrió un error en el registro, intenta nuevamente.', 3000);
            }
        } catch (error) {
            ocultarCarga();
            notification('error', 'Error de red o del servidor.', 3000);
            console.error('Error:', error);
        }
    });
});
