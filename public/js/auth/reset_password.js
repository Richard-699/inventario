window.addEventListener('load', function () {
    const passwordInput = document.getElementById('inputPassword');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const passwordToggle = document.getElementById('passwordToggle');
    const confirmPasswordToggle = document.getElementById('confirmPasswordToggle');

    function togglePasswordIcon() {
        passwordToggle.style.display = passwordInput.value.length > 0 ? 'block' : 'none';
        confirmPasswordToggle.style.display = confirmPasswordInput.value.length > 0 ? 'block' : 'none';
    }

    function validarContrasena() {
        const inputPassword = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        const errorSpan = document.getElementById("errorConfirmPassword");
        const submitButton = document.querySelector('button[type="submit"]');

        if (inputPassword === confirmPassword) {
            errorSpan.textContent = "";
            submitButton.removeAttribute("disabled");
        } else {
            errorSpan.textContent = "Las contraseñas no coinciden";
            submitButton.setAttribute("disabled", "disabled");
        }
    }

    passwordInput.addEventListener('input', togglePasswordIcon);
    confirmPasswordInput.addEventListener('input', togglePasswordIcon);
    passwordInput.addEventListener('input', validarContrasena);
    confirmPasswordInput.addEventListener('input', validarContrasena);
});

$('#formResetPassword').on('submit', function (e) {
        e.preventDefault();
        mostrarCarga();

        const form = this;
        const formData = new FormData(form);

        resetPassword();

        async function resetPassword(){
            try {
                const response = await fetch('../../../public/router/router.php?action=reset_password', {
                    method: 'POST',
                    body: formData
                });
                if (!response.ok) {
                    throw new Error('Error en la solicitud: ' + response.statusText);
                }

                const result = await response.json();

                if (result.success) {
                    notification('success', 'Se restableció la contraseña, inicie sesión nuevamente', 2500);
                    setTimeout(function () {
                        window.location.href = 'login.php';
                    }, 2500);
                } else {
                    notification('error', result.message, 2500);
                }
            } catch (error) {
                notification('error', 'Error al conectar con el servidor.', 2000);
            } finally {
                ocultarCarga();
            }
        }
    });
