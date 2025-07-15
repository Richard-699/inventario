<?php
/* require_once '../../controllers/ValidacionSesion.php'; */
include('../../../Shared/Util/spinner.php');

$fechaInicio = $_SESSION['fechas_corte']['fecha_inicio'];
$fechaFin = $_SESSION['fechas_corte']['fecha_fin'];
$permisos = $_SESSION['permisosAdministradores'];
if (count($_SESSION['celulasAdministradores']) > 0) {
    $celulas = $_SESSION['celulasAdministradores'];
} else {
    $celulas = null;
}
if ($celulas !== null) {
    $celulaActiva = $_SESSION['celula_activa'] ?? $celulas[0]['nombre_celula'];
}

if (isset($_SESSION['administrador'])) {
    $administrador = $_SESSION['administrador'];
    $nombreCompletoAdministrador = $administrador['nombre_administrador'] . ' ' . $administrador['apellidos_administrador'];
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Novedades Nómina</title>
    <link rel="shortcut icon" href="../../../public/img/LogoBlanco.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../../public/css/partials/estilos_header.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../../../public/css/utils/estilos_spinner.css">
    <script src=""></script>

</head>

<body>

    <div id="sidebar" class="sidebar">
        <a class="fondo-img" href="index.php"><img src="../../../public/img/LogoBlanco.png" class="img-logo"></a>
        <a href="javascript:void(0);" onclick="Inicio();" class="mt-3 hov"><i class="fas fa-home"></i> Inicio</a>
        <hr style="width: 93%; margin-left: 4%; color: white; margin-top: -1px; margin-bottom: -1px" />
        <?php
        $permiso_gestionar_celula = false;
        $tieneBasico = false;
        $tieneAvanzado = false;
        $AprobarNovedadesHorasExtrasManuales = null;
        $mostrarPersonalJiro = false;

        foreach ($permisos as $permiso) {
            switch ($permiso['tipo_permiso']) {
                case "Gestionar Célula":
                    echo '<a class="hov" href="javascript:void(0);" onclick="MiCelula();"><i class="fas fa-cogs"></i> Mi célula</a>';
                    echo '<hr style="width: 93%; margin-left: 4%; color: white; margin-top: -1px; margin-bottom: -1px" />';
                    $permiso_gestionar_celula = true;
                    break;
                case "Aprobar y Rechazar Horas Extras":
                    echo '<a class="hov" href="javascript:void(0);" onclick="MostrarHorasExtras();"><i class="fa-solid fa-clock"></i> Horas Extras</a>';
                    echo '<hr style="width: 93%; margin-left: 4%; color: white; margin-top: -1px; margin-bottom: -1px" />';
                    break;
                case "Aprobar y Rechazar Ausentismos":
                    echo '<a class="hov" href="javascript:void(0);" onclick="MostrarAusentismos();"><i class="fa-solid fa-user-xmark"></i> Ausentismos</a>';
                    echo '<hr style="width: 93%; margin-left: 4%; color: white; margin-top: -1px; margin-bottom: -1px" />';
                    break;
                case "Gestionar Administradores":
                    echo '<a class="hov" href="javascript:void(0);" onclick="GestionarAdministradores();"><i class="fa-solid fa-users-gear"></i> Administradores</a>';
                    echo '<hr style="width: 93%; margin-left: 4%; color: white; margin-top: -1px; margin-bottom: -1px" />';
                    break;
                case "Generar Excel Básico":
                    $tieneBasico = true;
                    break;
                case "Generar Excel Avanzado":
                    $tieneAvanzado = true;
                    break;
                case "Aprobar Novedades Horas Extras Manuales":
                    echo '<a class="hov" href="javascript:void(0);" onclick="MostrarHorasExtras();"><i class="fa-solid fa-clock"></i> Horas Extras</a>';
                    echo '<hr style="width: 93%; margin-left: 4%; color: white; margin-top: -1px; margin-bottom: -1px" />';
                    $AprobarNovedadesHorasExtrasManuales = 1;
                    break;
                case "Actualizar Fechas de Corte":
                    echo '<a class="hov" href="javascript:void(0);" onclick="FechasCorte();"><i class="fa-solid fa-calendar-days"></i> Fechas de Corte</a>';
                    echo '<hr style="width: 93%; margin-left: 4%; color: white; margin-top: -1px; margin-bottom: -1px" />';
                    break;
                case "Registrar Personal Jiro":
                case "Vincular Personal Jiro":
                    $mostrarPersonalJiro = true;
                    break;
            }
        }

        if ($mostrarPersonalJiro) {
            echo '<a class="hov" href="javascript:void(0);" onclick="PersonalJiro();"><i class="fa-solid fa-users"></i> Personal Jiro</a>';
            echo '<hr style="width: 93%; margin-left: 4%; color: white; margin-top: -1px; margin-bottom: -1px" />';
        }
        // Mostrar menú Generar Excel solo si tiene permisos
        if ($tieneBasico || $tieneAvanzado) {
            echo '<div class="submenu-container">
                <a class="hov submenu-toggle" href="#"><i class="fa-solid fa-file-excel"></i> Generar Excel</a>
                <div class="submenu">';

            // Submenú de Auditorías si tiene permiso Avanzado
            if ($tieneAvanzado) {
                echo '<div class="submenu-container">
                        <a href="#" onclick="ExcelAuditoriasHorasExtras();"><i class="fa-solid fa-file"></i> Horas Extras Auditorias</a>
                        
                    </div>';
            }

            // Ítems del Excel Básico
            if ($tieneBasico) {
                echo '<a onclick="ExcelBasicoHorasExtras()"><i class="fa-regular fa-clock"></i> Horas Extras</a>
                      <a onclick="ExcelBasicoAusentismos()"><i class="fa-solid fa-xmark"></i> Ausentismos</a>';
            }

            echo '</div></div>';
            echo '<hr style="width: 93%; margin-left: 4%; color: white; margin-top: -1px; margin-bottom: -1px" />';
        }
        ?>

        <a href="javascript:void(0);" class="hov" id="BtnCerrarSesion"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
    </div>


    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-light px-3">
            <button class="menu-toggle" id="menuToggle" onclick="toggleSidebar()">☰ Menú</button>
            <div class="ms-auto d-flex align-items-center">
                <?php
                if ($permiso_gestionar_celula) {

                    $numeroCelulas = count($celulas);
                    if ($numeroCelulas === 1) {
                        $nombreCelula = $celulas[0]['nombre_celula'];
                        echo "<span class='nombre-celula'>$nombreCelula</span>";
                    } elseif ($numeroCelulas > 1) {
                        echo "<span class='nombre-celula'>$celulaActiva</span>";
                        echo '<div class="dropdown celula-dropdown">
                            <a href="#" class="me-3 text-dark icon-config dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-cog fa-lg"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end bg-dark text-white" aria-labelledby="dropdownMenuButton">';
                        foreach ($celulas as $celula) {
                            echo '<li><a class="dropdown-item text-white cambiar-celula" href="#" data-celula="' . $celula['nombre_celula'] . '">' . $celula['nombre_celula'] . '</a></li>';
                        }
                        echo '</ul></div>';
                    }
                } else {
                    echo "<span class='nombre-celula'>Administrador Master</span>";
                }
                ?>
                <a href="javascript:void(0);" id="BtnCerrarSesionMenu" class="text-dark icon-logout"><i class="fas fa-sign-out-alt fa-lg"></i></a>
            </div>
        </nav>

        <div class="container mt-4">