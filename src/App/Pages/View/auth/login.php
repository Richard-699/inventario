<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Inventario HWI</title>
    <link rel="shortcut icon" href="../../../../../public/img/LogoBlanco.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../../../../../public/css/auth/estilos_login.css">
    <link rel="stylesheet" href="../../../../../public/css/utils/estilos_spinner.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <?php
    include('../../../Shared/Util/spinner.php');
    ?>
</head>

<body>

    <div class="container w-75 mt-5 bg-white rounded shadow">
        <div class="row align-items-stretch">
            <div class="col bg">

            </div>
            <div class="col p-5 rounded-end">
                <h2 class="fw-bold text-center py-4">Iniciar Sesión</h2>
                <form id="formLogin">
                    <div class="mb-4 form-group mt-5">
                        <input autocomplete="off" type="text" class="custom-input" id="correo_hwi_administrador" name="correo_hwi_administrador" placeholder=" ">
                        <label for="email" class="floating-label">Correo Corporativo</label>
                    </div>
                    <div class="mb-2 form-group">
                        <input autocomplete="off" type="password" class="custom-input" id="password_administrador" name="password_administrador" placeholder=" ">
                        <label for="password" class="floating-label">Contraseña</label>
                        <button class="password-toggle" id="passwordToggle" type="button" onclick="togglePassword('password_administrador')">
                            <i class="material-icons" id="passwordIcon">visibility</i>
                        </button>
                    </div>
                    <div class="d-grid mb-4">
                        <button type="submit" value="Ingresar" name="btningresar" class="btn btn-success align-items-center w-100 mx-auto" id="btningresar">
                            <i class="material-icons align-middle" style="font-size: 24px;"></i>
                            <span class="align-middle">Ingresar</span>
                        </button>
                    </div>
                    <p style="text-align: center; margin: 0 auto;">
                        <a href="validate_email.php">¿Haz olvidado la contraseña?</a>
                    </p>
                    <p style="text-align: center; margin: 0 auto;">¿No tienes una cuenta? <a href="register.php">Regístrate</a></p>
                </form>
            </div>
        </div>
    </div>

    <br>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="../../../../../public/js/utils/notifications.js"></script>
    <script src="../../../../../public/js/utils/spinner.js"></script>
    <script src="../../../../../public/js/auth/login.js"></script>

    <?php if (isset($_GET['session_expired']) && $_GET['session_expired'] === 'true'): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                notification('alert', 'Tu sesión ha expirado por inactividad. Por favor, inicia sesión nuevamente.', 4000);
                if (window.history.replaceState) {
                    const url = new URL(window.location);
                    url.searchParams.delete('session_expired');
                    window.history.replaceState(null, '', url);
                }
            });
        </script>
    <?php endif; ?>

</body>

</html>