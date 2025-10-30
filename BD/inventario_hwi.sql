-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-10-2025 a las 19:42:58
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inventario_hwi`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_administradores`
--

CREATE TABLE `inventario_hwi_administradores` (
  `id_administrador` varchar(300) NOT NULL,
  `cedula_administrador` bigint(20) NOT NULL,
  `nombre_administrador` varchar(100) NOT NULL,
  `apellidos_administrador` varchar(100) NOT NULL,
  `correo_hwi_administrador` varchar(100) NOT NULL,
  `password_administrador` varchar(400) NOT NULL,
  `password_is_temporal` int(1) NOT NULL,
  `estado_administrador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario_hwi_administradores`
--

INSERT INTO `inventario_hwi_administradores` (`id_administrador`, `cedula_administrador`, `nombre_administrador`, `apellidos_administrador`, `correo_hwi_administrador`, `password_administrador`, `password_is_temporal`, `estado_administrador`) VALUES
('51d0d540-2777-49ef-9de3-a08dda914ca7', 1001250449, 'Samuel', 'Cano', 'administrador.smartcenter@hacebwhirlpool.com', '$2y$10$gRvwHzNlMZfm82VWJ.6iMu/TFHVA6mKhUXDKpeF8F5pkanRAmu7u6', 0, 1),
('6abed997-cb75-442b-bd04-c44c0d49927d', 1006493515, 'Ricardo', 'Rojas Yepes', 'ricardo.rojas@hacebwhirlpool.com', '$2y$10$I8r6tHkHy9PnIoI5uGwhCOdq..5M5z3ydlLPKDurrV/ETt7yHDL4u', 0, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_almacenes`
--

CREATE TABLE `inventario_hwi_almacenes` (
  `id_almacen` varchar(300) NOT NULL,
  `codigo_sap` varchar(100) NOT NULL,
  `descripcion_almacen` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario_hwi_almacenes`
--

INSERT INTO `inventario_hwi_almacenes` (`id_almacen`, `codigo_sap`, `descripcion_almacen`) VALUES
('393f7b1e-6db1-4cf3-af2f-0350b5bb6436', 'EXT4', 'EXT4'),
('486836be-8808-4368-a680-b7cb09126041', '0006', '0006'),
('8202686d-6d50-4419-9e0f-95a735e33bef', 'EXT1', 'EXT1'),
('cff383c1-6c34-4c11-868c-57f4850abc7d', 'WM01', 'WM01'),
('d6070b12-c723-49ed-b08a-0ba09a37936d', '0016', '0016'),
('fbcdeabb-5c8c-4353-a78f-53e26223d0c1', '0010', '0010');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_almacenes_clasificaciones_almacenes`
--

CREATE TABLE `inventario_hwi_almacenes_clasificaciones_almacenes` (
  `id_almacenes_clasificaciones_almacenes` int(11) NOT NULL,
  `id_almacen_almacenes_clasificaciones_almacenes` varchar(300) NOT NULL,
  `id_clasificacion_almacenes_almacenes_clasificaciones_almacenes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario_hwi_almacenes_clasificaciones_almacenes`
--

INSERT INTO `inventario_hwi_almacenes_clasificaciones_almacenes` (`id_almacenes_clasificaciones_almacenes`, `id_almacen_almacenes_clasificaciones_almacenes`, `id_clasificacion_almacenes_almacenes_clasificaciones_almacenes`) VALUES
(17, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 4),
(23, '486836be-8808-4368-a680-b7cb09126041', 4),
(24, 'fbcdeabb-5c8c-4353-a78f-53e26223d0c1', 4),
(25, 'd6070b12-c723-49ed-b08a-0ba09a37936d', 4),
(26, '8202686d-6d50-4419-9e0f-95a735e33bef', 4),
(27, '393f7b1e-6db1-4cf3-af2f-0350b5bb6436', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_almacenes_localizaciones`
--

CREATE TABLE `inventario_hwi_almacenes_localizaciones` (
  `id_localizaciones_almacenes` int(11) NOT NULL,
  `id_almacen` varchar(300) NOT NULL,
  `id_localizacion_localizaciones` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_clasificacion_almacenes`
--

CREATE TABLE `inventario_hwi_clasificacion_almacenes` (
  `id_clasificacion_almacenes` int(11) NOT NULL,
  `descripcion_clasificacion_almacenes` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario_hwi_clasificacion_almacenes`
--

INSERT INTO `inventario_hwi_clasificacion_almacenes` (`id_clasificacion_almacenes`, `descripcion_clasificacion_almacenes`) VALUES
(1, 'Actualizar'),
(2, 'Ajustar'),
(3, 'Reclasificar'),
(4, 'N/A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_conteos`
--

CREATE TABLE `inventario_hwi_conteos` (
  `id_conteo` int(11) NOT NULL,
  `id_grupo_conteo` varchar(300) NOT NULL,
  `id_encargado_conteo` varchar(300) NOT NULL,
  `fecha_hora_inicio_conteo` datetime DEFAULT NULL,
  `fecha_hora_final_conteo` datetime DEFAULT NULL,
  `observaciones_conteo` varchar(500) DEFAULT NULL,
  `estado_conteo` varchar(50) DEFAULT NULL,
  `observacion_final_conteo` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_cronograma`
--

CREATE TABLE `inventario_hwi_cronograma` (
  `id_cronograma` int(11) NOT NULL,
  `fecha_cronograma` char(7) NOT NULL,
  `id_grupo_cronograma` varchar(300) NOT NULL,
  `id_estado_cronograma` int(11) NOT NULL,
  `id_administrador_cronograma` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_estados`
--

CREATE TABLE `inventario_hwi_estados` (
  `id_estado` int(11) NOT NULL,
  `tipo_estado` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario_hwi_estados`
--

INSERT INTO `inventario_hwi_estados` (`id_estado`, `tipo_estado`) VALUES
(1, 'Pendiente Conteo 1'),
(2, 'En Proceso Conteo 1'),
(3, 'Pendiente Aprobación'),
(4, 'Pendiente Ajuste'),
(5, 'Pendiente Conteo 2'),
(6, 'Pendiente Conteo 3'),
(8, 'En Proceso Conteo 2'),
(9, 'En Proceso Conteo 3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_exactitud`
--

CREATE TABLE `inventario_hwi_exactitud` (
  `id_exactitud` int(11) NOT NULL,
  `partnumber_exactitud` varchar(50) NOT NULL,
  `descripcion_partnumber_exactitud` varchar(500) DEFAULT NULL,
  `tipo_almacen_exactitud` varchar(20) NOT NULL,
  `area_almacenamiento_exactitud` varchar(20) NOT NULL,
  `localizacion_exactitud` varchar(20) NOT NULL,
  `coincide_exactitud` varchar(2) DEFAULT NULL,
  `novedad_exactitud` varchar(500) DEFAULT NULL,
  `descripcion_novedad_exactitud` varchar(500) DEFAULT NULL,
  `fecha_hora_migracion_exactitud` datetime NOT NULL,
  `id_administrador` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_grupos`
--

CREATE TABLE `inventario_hwi_grupos` (
  `id_grupo` varchar(300) NOT NULL,
  `descripcion_grupo` varchar(300) DEFAULT NULL,
  `fecha_programacion_grupo` char(7) DEFAULT NULL,
  `informacion_migrada_sap_grupo` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_historico_cronograma`
--

CREATE TABLE `inventario_hwi_historico_cronograma` (
  `id_historico_cronograma` int(11) NOT NULL,
  `fecha_historico_cronograma` date NOT NULL,
  `id_grupo_historico_cronograma` varchar(300) NOT NULL,
  `id_administrador_historico_cronograma` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_historico_mb52`
--

CREATE TABLE `inventario_hwi_historico_mb52` (
  `id_historico_mb52` int(11) NOT NULL,
  `id_informacion_sap_mb52_historico_mb52` varchar(300) NOT NULL,
  `fecha_historico_mb52` date NOT NULL,
  `cantidad_historico_mb52` decimal(13,3) NOT NULL,
  `fechaRegistro_historico_mb52` date DEFAULT NULL,
  `id_part_number_historico_mb52` int(11) DEFAULT NULL,
  `id_almacen_historico_mb52` varchar(300) DEFAULT NULL,
  `id_grupo_historico_mb52` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_historico_stock`
--

CREATE TABLE `inventario_hwi_historico_stock` (
  `id_historico_stock` int(11) NOT NULL,
  `fecha_historico_stock` date NOT NULL,
  `cantidad_historico_stock` int(11) NOT NULL,
  `id_almacen_historico_stock` varchar(300) DEFAULT NULL,
  `id_localizacion_historico_stock` int(11) DEFAULT NULL,
  `id_informacion_sap_mb52_historico_stock` varchar(300) DEFAULT NULL,
  `id_partnumber_historico_stock` int(11) DEFAULT NULL,
  `id_novedad_historico_stock` int(11) DEFAULT NULL,
  `observaciones_novedad_historico_stock` varchar(500) NOT NULL,
  `id_grupo_historico_stock` varchar(300) NOT NULL,
  `id_conteo_stock` int(11) NOT NULL,
  `fecha_hora_stock` datetime NOT NULL,
  `id_administrador_stock` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_historico_wm`
--

CREATE TABLE `inventario_hwi_historico_wm` (
  `id_historico_wm` int(11) NOT NULL,
  `fecha_historico_wm` date NOT NULL,
  `stock_disponible_historico_wm` decimal(13,3) DEFAULT NULL,
  `stock_entrada_historico_wm` decimal(13,3) DEFAULT NULL,
  `stock_salida_historico_wm` decimal(13,3) DEFAULT NULL,
  `id_localizacion_historico_wm` int(11) DEFAULT NULL,
  `id_partnumber_historico_wm` int(11) DEFAULT NULL,
  `id_grupo_historico_wm` varchar(300) DEFAULT NULL,
  `id_informacion_sap_mb52_historico_wm` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_informacion_sap_mb52`
--

CREATE TABLE `inventario_hwi_informacion_sap_mb52` (
  `id_informacion_sap_mb52` varchar(300) NOT NULL,
  `fecha_registro_informacion_sap_mb52` date NOT NULL,
  `id_part_number_informacion_sap_mb52` int(11) NOT NULL,
  `cantidad_informacion_sap_mb52` decimal(15,3) NOT NULL,
  `id_almacen_informacion_sap_mb52` varchar(300) NOT NULL,
  `id_grupo_informacion_sap_mb52` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_informacion_sap_wm`
--

CREATE TABLE `inventario_hwi_informacion_sap_wm` (
  `id_informacion_sap_wm` int(11) NOT NULL,
  `id_part_number_informacion_sap_wm` int(11) NOT NULL,
  `id_localizacion_informacion_sap_wm` int(11) DEFAULT NULL,
  `id_grupo_informacion_sap_wm` varchar(300) NOT NULL,
  `id_informacion_sap_mb52_informacion_sap_wm` varchar(300) NOT NULL,
  `stock_disponible_sap_informacion_sap_wm` decimal(13,3) NOT NULL,
  `stock_entrada_sap_informacion_sap_wm` decimal(13,3) NOT NULL,
  `stock_salida_sap_informacion_sap_wm` decimal(13,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_localizaciones`
--

CREATE TABLE `inventario_hwi_localizaciones` (
  `id_localizacion` int(11) NOT NULL,
  `id_tipo_localizacion_localizaciones` int(11) NOT NULL,
  `descripcion_localizacion` varchar(100) NOT NULL,
  `id_tipo_almacenamientos_localizaciones` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario_hwi_localizaciones`
--

INSERT INTO `inventario_hwi_localizaciones` (`id_localizacion`, `id_tipo_localizacion_localizaciones`, `descripcion_localizacion`, `id_tipo_almacenamientos_localizaciones`) VALUES
(15, 3, 'A-5-8-2', 1),
(16, 3, 'A-9-5-2', 1),
(17, 3, 'B-1-1-2', 1),
(18, 3, 'B-3-6-1', 1),
(19, 3, 'B-7-4-1', 1),
(20, 3, 'B-8-4-2', 1),
(21, 3, 'C-10-2-2', 1),
(22, 3, 'C-5-3-2', 1),
(23, 3, 'C-8-1-2', 1),
(24, 3, 'E-4-5-2', 1),
(25, 3, 'E-5-7-2', 1),
(26, 3, 'E-5-8-1', 1),
(27, 3, 'E-7-6-1', 1),
(28, 3, 'E-7-6-2', 1),
(29, 3, 'E-8-5-1', 1),
(30, 3, 'E-8-8-2', 1),
(31, 3, 'E-9-6-2', 1),
(32, 3, 'E-9-8-1', 1),
(33, 3, 'F-10-5-1', 1),
(34, 3, 'F-10-6-1', 1),
(35, 3, 'F-10-7-1', 1),
(36, 3, 'F-4-3-2', 1),
(37, 3, 'F-5-2-1', 1),
(38, 3, 'F-6-2-1', 1),
(39, 3, 'F-7-1-1', 1),
(40, 3, 'F-9-4-1', 1),
(41, 3, 'G-1-6-1', 1),
(42, 3, 'G-1-6-2', 1),
(43, 3, 'G-10-5-2', 1),
(44, 3, 'G-10-6-1', 1),
(45, 3, 'G-2-4-2', 1),
(46, 3, 'G-4-4-1', 1),
(47, 3, 'G-4-5-1', 1),
(48, 3, 'G-5-7-2', 1),
(49, 3, 'G-6-2-2', 1),
(50, 3, 'G-8-6-1', 1),
(51, 3, 'G-8-6-2', 1),
(52, 3, 'G-9-5-1', 1),
(53, 3, 'G-9-8-2', 1),
(54, 3, 'GR-ZONE', 1),
(55, 3, 'H-1-7-2', 1),
(56, 3, 'H-2-7-1', 1),
(57, 3, 'H-3-3-2', 1),
(58, 3, 'H-4-3-2', 1),
(59, 3, 'H-9-6-1', 1),
(60, 3, 'H-9-6-2', 1),
(61, 3, 'H-9-7-2', 1),
(62, 3, 'I-1-5-1', 1),
(63, 3, 'I-1-7-2', 1),
(64, 3, 'I-10-4-2', 1),
(65, 3, 'I-10-5-2', 1),
(66, 3, 'I-10-6-1', 1),
(67, 3, 'I-10-6-2', 1),
(68, 3, 'I-10-8-2', 1),
(69, 3, 'I-3-4-1', 1),
(70, 3, 'I-4-5-1', 1),
(71, 3, 'I-4-6-1', 1),
(72, 3, 'I-5-6-1', 1),
(73, 3, 'I-5-7-2', 1),
(74, 3, 'I-6-2-2', 1),
(75, 3, 'I-6-3-2', 1),
(76, 3, 'I-6-5-1', 1),
(77, 3, 'I-6-8-2', 1),
(78, 3, 'I-7-2-2', 1),
(79, 3, 'I-8-7-2', 1),
(80, 3, 'I-9-2-1', 1),
(81, 3, 'I-9-3-1', 1),
(82, 3, 'I-9-3-2', 1),
(83, 3, 'I-9-6-1', 1),
(84, 3, 'I-9-6-2', 1),
(85, 3, 'MEC-C1', 1),
(86, 3, 'MEC-C2', 1),
(87, 2, 'A-4-7', 1),
(88, 3, 'LOG EXT4', 5),
(89, 3, 'LOG 0006', 5),
(90, 3, 'LOG 0010', 5),
(91, 3, 'LOG EXT1', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_novedades`
--

CREATE TABLE `inventario_hwi_novedades` (
  `id_novedad` int(11) NOT NULL,
  `id_tipo_novedad` int(11) NOT NULL,
  `descripcion_novedad` varchar(500) NOT NULL,
  `cantidad_novedad` varchar(100) DEFAULT NULL,
  `id_conteo_novedad` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='2';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_partnumbers`
--

CREATE TABLE `inventario_hwi_partnumbers` (
  `id_partnumber` int(11) NOT NULL,
  `partnumber` varchar(100) NOT NULL,
  `descripcion_breve` varchar(100) NOT NULL,
  `id_umb_partnumber` int(11) NOT NULL,
  `nombre_interno` varchar(100) NOT NULL,
  `id_grupo_partnumber` varchar(300) DEFAULT NULL,
  `id_plataforma_partnumber` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_permisos`
--

CREATE TABLE `inventario_hwi_permisos` (
  `id_permiso` int(11) NOT NULL,
  `tipo_permiso` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario_hwi_permisos`
--

INSERT INTO `inventario_hwi_permisos` (`id_permiso`, `tipo_permiso`) VALUES
(1, 'Gestión Interna Inventario'),
(2, 'Aprobación y Ajuste Inventario'),
(3, 'Gestionar Administradores');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_permisos_administradores`
--

CREATE TABLE `inventario_hwi_permisos_administradores` (
  `id_permisos_administradores` int(11) NOT NULL,
  `id_permiso_permisos` int(11) NOT NULL,
  `id_administrador_permisos` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario_hwi_permisos_administradores`
--

INSERT INTO `inventario_hwi_permisos_administradores` (`id_permisos_administradores`, `id_permiso_permisos`, `id_administrador_permisos`) VALUES
(1, 1, '51d0d540-2777-49ef-9de3-a08dda914ca7'),
(2, 2, '51d0d540-2777-49ef-9de3-a08dda914ca7'),
(31, 2, '6abed997-cb75-442b-bd04-c44c0d49927d'),
(32, 3, '51d0d540-2777-49ef-9de3-a08dda914ca7');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_plataforma`
--

CREATE TABLE `inventario_hwi_plataforma` (
  `id_plataforma` int(11) NOT NULL,
  `descripcion_plataforma` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario_hwi_plataforma`
--

INSERT INTO `inventario_hwi_plataforma` (`id_plataforma`, `descripcion_plataforma`) VALUES
(1, 'Botero'),
(2, 'Botero 2'),
(3, 'Copa 1'),
(4, 'Copa 2'),
(5, 'Copa 1 y 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_stock`
--

CREATE TABLE `inventario_hwi_stock` (
  `id_stock` int(11) NOT NULL,
  `id_partnumber_stock` int(11) NOT NULL,
  `id_almacen_stock` varchar(300) NOT NULL,
  `id_localizacion_stock` int(10) NOT NULL,
  `cantidad_stock` decimal(15,3) NOT NULL,
  `id_informacion_sap_mb52_stock` varchar(300) NOT NULL,
  `id_novedad_stock` int(11) DEFAULT NULL,
  `observaciones_novedad_stock` varchar(500) DEFAULT NULL,
  `id_grupo_stock` varchar(300) NOT NULL,
  `id_conteo_stock` int(11) NOT NULL,
  `fecha_hora_stock` datetime DEFAULT NULL,
  `id_administrador_stock` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_tipo_almacenamientos`
--

CREATE TABLE `inventario_hwi_tipo_almacenamientos` (
  `id_tipo_almacenamiento` int(11) NOT NULL,
  `descripcion_tipo_almacenamiento` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario_hwi_tipo_almacenamientos`
--

INSERT INTO `inventario_hwi_tipo_almacenamientos` (`id_tipo_almacenamiento`, `descripcion_tipo_almacenamiento`) VALUES
(1, 'DOP'),
(2, 'EGR'),
(3, 'PKN'),
(4, '902'),
(5, 'N/A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_tipo_localizaciones`
--

CREATE TABLE `inventario_hwi_tipo_localizaciones` (
  `id_tipo_localizacion` int(10) NOT NULL,
  `descripcion_tipo_localizacion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario_hwi_tipo_localizaciones`
--

INSERT INTO `inventario_hwi_tipo_localizaciones` (`id_tipo_localizacion`, `descripcion_tipo_localizacion`) VALUES
(1, 'Célula / Área'),
(2, 'Sección'),
(3, 'Ubicación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_tipo_novedades`
--

CREATE TABLE `inventario_hwi_tipo_novedades` (
  `id_novedad` int(11) NOT NULL,
  `descripcion_novedad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario_hwi_tipo_novedades`
--

INSERT INTO `inventario_hwi_tipo_novedades` (`id_novedad`, `descripcion_novedad`) VALUES
(1, 'Actualizado'),
(2, 'Ajustado'),
(3, 'Reclasificado'),
(4, 'Sin Novedad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_umb`
--

CREATE TABLE `inventario_hwi_umb` (
  `id_umb` int(11) NOT NULL,
  `descripcion_umb` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario_hwi_umb`
--

INSERT INTO `inventario_hwi_umb` (`id_umb`, `descripcion_umb`) VALUES
(1, 'CJ'),
(2, 'G'),
(3, 'KG'),
(4, 'M'),
(5, 'ML'),
(6, 'PC'),
(7, 'UN');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `inventario_hwi_administradores`
--
ALTER TABLE `inventario_hwi_administradores`
  ADD PRIMARY KEY (`id_administrador`);

--
-- Indices de la tabla `inventario_hwi_almacenes`
--
ALTER TABLE `inventario_hwi_almacenes`
  ADD PRIMARY KEY (`id_almacen`);

--
-- Indices de la tabla `inventario_hwi_almacenes_clasificaciones_almacenes`
--
ALTER TABLE `inventario_hwi_almacenes_clasificaciones_almacenes`
  ADD PRIMARY KEY (`id_almacenes_clasificaciones_almacenes`),
  ADD KEY `relacion_clasificacion_almacenes` (`id_clasificacion_almacenes_almacenes_clasificaciones_almacenes`),
  ADD KEY `relacion_almacenes_clasificaciones_intermedia` (`id_almacen_almacenes_clasificaciones_almacenes`);

--
-- Indices de la tabla `inventario_hwi_almacenes_localizaciones`
--
ALTER TABLE `inventario_hwi_almacenes_localizaciones`
  ADD PRIMARY KEY (`id_localizaciones_almacenes`),
  ADD KEY `inventario_hwi_almacenes_localizaciones_ibfk_2` (`id_localizacion_localizaciones`),
  ADD KEY `relacion_almacenes_almecenes_localizaciones` (`id_almacen`);

--
-- Indices de la tabla `inventario_hwi_clasificacion_almacenes`
--
ALTER TABLE `inventario_hwi_clasificacion_almacenes`
  ADD PRIMARY KEY (`id_clasificacion_almacenes`);

--
-- Indices de la tabla `inventario_hwi_conteos`
--
ALTER TABLE `inventario_hwi_conteos`
  ADD PRIMARY KEY (`id_conteo`);

--
-- Indices de la tabla `inventario_hwi_cronograma`
--
ALTER TABLE `inventario_hwi_cronograma`
  ADD PRIMARY KEY (`id_cronograma`),
  ADD KEY `id_grupo_cronograma` (`id_grupo_cronograma`,`id_estado_cronograma`,`id_administrador_cronograma`),
  ADD KEY `relacion_estados_cronograma` (`id_estado_cronograma`),
  ADD KEY `relacion_administradores_cronograma` (`id_administrador_cronograma`);

--
-- Indices de la tabla `inventario_hwi_estados`
--
ALTER TABLE `inventario_hwi_estados`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `inventario_hwi_exactitud`
--
ALTER TABLE `inventario_hwi_exactitud`
  ADD PRIMARY KEY (`id_exactitud`);

--
-- Indices de la tabla `inventario_hwi_grupos`
--
ALTER TABLE `inventario_hwi_grupos`
  ADD PRIMARY KEY (`id_grupo`);

--
-- Indices de la tabla `inventario_hwi_historico_cronograma`
--
ALTER TABLE `inventario_hwi_historico_cronograma`
  ADD PRIMARY KEY (`id_historico_cronograma`),
  ADD KEY `relacion_administradores_historico_cronograma` (`id_administrador_historico_cronograma`),
  ADD KEY `relacion_grupos_historico_cronograma` (`id_grupo_historico_cronograma`);

--
-- Indices de la tabla `inventario_hwi_historico_mb52`
--
ALTER TABLE `inventario_hwi_historico_mb52`
  ADD PRIMARY KEY (`id_historico_mb52`),
  ADD KEY `idx_part_number_mb52` (`id_part_number_historico_mb52`),
  ADD KEY `idx_almacen_mb52` (`id_almacen_historico_mb52`),
  ADD KEY `idx_grupo_mb52` (`id_grupo_historico_mb52`);

--
-- Indices de la tabla `inventario_hwi_historico_stock`
--
ALTER TABLE `inventario_hwi_historico_stock`
  ADD PRIMARY KEY (`id_historico_stock`),
  ADD KEY `idx_almacen_historico_stock` (`id_almacen_historico_stock`),
  ADD KEY `idx_localizacion_historico_stock` (`id_localizacion_historico_stock`),
  ADD KEY `idx_informacion_sap` (`id_informacion_sap_mb52_historico_stock`),
  ADD KEY `idx_partnumber_historico_stock` (`id_partnumber_historico_stock`),
  ADD KEY `relacion_novedad_historico_stock` (`id_novedad_historico_stock`),
  ADD KEY `relacion_grupo_historico_stock` (`id_grupo_historico_stock`);

--
-- Indices de la tabla `inventario_hwi_historico_wm`
--
ALTER TABLE `inventario_hwi_historico_wm`
  ADD PRIMARY KEY (`id_historico_wm`),
  ADD KEY `idx_localizacion_historico_wm` (`id_localizacion_historico_wm`),
  ADD KEY `idx_partnumber_historico_wm` (`id_partnumber_historico_wm`),
  ADD KEY `idx_grupo_historico_wm` (`id_grupo_historico_wm`),
  ADD KEY `idx_informacion_sap_mb52_historico_wm` (`id_informacion_sap_mb52_historico_wm`);

--
-- Indices de la tabla `inventario_hwi_informacion_sap_mb52`
--
ALTER TABLE `inventario_hwi_informacion_sap_mb52`
  ADD PRIMARY KEY (`id_informacion_sap_mb52`),
  ADD KEY `id_grupo_informacion_sap_mb52` (`id_grupo_informacion_sap_mb52`),
  ADD KEY `relacion_pn_mb52` (`id_part_number_informacion_sap_mb52`),
  ADD KEY `relacion_almacenes_mb52` (`id_almacen_informacion_sap_mb52`);

--
-- Indices de la tabla `inventario_hwi_informacion_sap_wm`
--
ALTER TABLE `inventario_hwi_informacion_sap_wm`
  ADD PRIMARY KEY (`id_informacion_sap_wm`),
  ADD KEY `part_number_informacion_sap` (`id_part_number_informacion_sap_wm`),
  ADD KEY `id_localizacion` (`id_localizacion_informacion_sap_wm`),
  ADD KEY `id_grupo_informacion_sap_wm` (`id_grupo_informacion_sap_wm`,`id_informacion_sap_mb52_informacion_sap_wm`),
  ADD KEY `relacion_mb52_wm` (`id_informacion_sap_mb52_informacion_sap_wm`);

--
-- Indices de la tabla `inventario_hwi_localizaciones`
--
ALTER TABLE `inventario_hwi_localizaciones`
  ADD PRIMARY KEY (`id_localizacion`),
  ADD KEY `id_tipo_localizacion_localizaciones` (`id_tipo_localizacion_localizaciones`),
  ADD KEY `relacion_localizaciones_tipo_almacenamiento` (`id_tipo_almacenamientos_localizaciones`);

--
-- Indices de la tabla `inventario_hwi_partnumbers`
--
ALTER TABLE `inventario_hwi_partnumbers`
  ADD PRIMARY KEY (`id_partnumber`),
  ADD KEY `id_umb_partnumber` (`id_umb_partnumber`),
  ADD KEY `id_grupo_partnumber` (`id_grupo_partnumber`),
  ADD KEY `id_plataforma_partnumber` (`id_plataforma_partnumber`);

--
-- Indices de la tabla `inventario_hwi_permisos`
--
ALTER TABLE `inventario_hwi_permisos`
  ADD PRIMARY KEY (`id_permiso`);

--
-- Indices de la tabla `inventario_hwi_permisos_administradores`
--
ALTER TABLE `inventario_hwi_permisos_administradores`
  ADD PRIMARY KEY (`id_permisos_administradores`),
  ADD KEY `id_permiso` (`id_permiso_permisos`),
  ADD KEY `id_administrador_permisos` (`id_administrador_permisos`);

--
-- Indices de la tabla `inventario_hwi_plataforma`
--
ALTER TABLE `inventario_hwi_plataforma`
  ADD PRIMARY KEY (`id_plataforma`);

--
-- Indices de la tabla `inventario_hwi_stock`
--
ALTER TABLE `inventario_hwi_stock`
  ADD PRIMARY KEY (`id_stock`),
  ADD KEY `id_localizacion_conteo` (`id_localizacion_stock`),
  ADD KEY `id_partnumber_partnumbers` (`id_partnumber_stock`),
  ADD KEY `relacion_almacen_conteo` (`id_almacen_stock`),
  ADD KEY `relacion_mb52_conteo` (`id_informacion_sap_mb52_stock`),
  ADD KEY `relacion_novedad_stock` (`id_novedad_stock`),
  ADD KEY `relacion_grupo_stock` (`id_grupo_stock`);

--
-- Indices de la tabla `inventario_hwi_tipo_almacenamientos`
--
ALTER TABLE `inventario_hwi_tipo_almacenamientos`
  ADD PRIMARY KEY (`id_tipo_almacenamiento`);

--
-- Indices de la tabla `inventario_hwi_tipo_localizaciones`
--
ALTER TABLE `inventario_hwi_tipo_localizaciones`
  ADD PRIMARY KEY (`id_tipo_localizacion`);

--
-- Indices de la tabla `inventario_hwi_tipo_novedades`
--
ALTER TABLE `inventario_hwi_tipo_novedades`
  ADD PRIMARY KEY (`id_novedad`);

--
-- Indices de la tabla `inventario_hwi_umb`
--
ALTER TABLE `inventario_hwi_umb`
  ADD PRIMARY KEY (`id_umb`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `inventario_hwi_almacenes_clasificaciones_almacenes`
--
ALTER TABLE `inventario_hwi_almacenes_clasificaciones_almacenes`
  MODIFY `id_almacenes_clasificaciones_almacenes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `inventario_hwi_almacenes_localizaciones`
--
ALTER TABLE `inventario_hwi_almacenes_localizaciones`
  MODIFY `id_localizaciones_almacenes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT de la tabla `inventario_hwi_clasificacion_almacenes`
--
ALTER TABLE `inventario_hwi_clasificacion_almacenes`
  MODIFY `id_clasificacion_almacenes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `inventario_hwi_conteos`
--
ALTER TABLE `inventario_hwi_conteos`
  MODIFY `id_conteo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `inventario_hwi_cronograma`
--
ALTER TABLE `inventario_hwi_cronograma`
  MODIFY `id_cronograma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `inventario_hwi_estados`
--
ALTER TABLE `inventario_hwi_estados`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `inventario_hwi_exactitud`
--
ALTER TABLE `inventario_hwi_exactitud`
  MODIFY `id_exactitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28857;

--
-- AUTO_INCREMENT de la tabla `inventario_hwi_historico_cronograma`
--
ALTER TABLE `inventario_hwi_historico_cronograma`
  MODIFY `id_historico_cronograma` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventario_hwi_historico_mb52`
--
ALTER TABLE `inventario_hwi_historico_mb52`
  MODIFY `id_historico_mb52` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de la tabla `inventario_hwi_historico_stock`
--
ALTER TABLE `inventario_hwi_historico_stock`
  MODIFY `id_historico_stock` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `inventario_hwi_historico_wm`
--
ALTER TABLE `inventario_hwi_historico_wm`
  MODIFY `id_historico_wm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=947;

--
-- AUTO_INCREMENT de la tabla `inventario_hwi_informacion_sap_wm`
--
ALTER TABLE `inventario_hwi_informacion_sap_wm`
  MODIFY `id_informacion_sap_wm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2091;

--
-- AUTO_INCREMENT de la tabla `inventario_hwi_localizaciones`
--
ALTER TABLE `inventario_hwi_localizaciones`
  MODIFY `id_localizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT de la tabla `inventario_hwi_partnumbers`
--
ALTER TABLE `inventario_hwi_partnumbers`
  MODIFY `id_partnumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `inventario_hwi_permisos`
--
ALTER TABLE `inventario_hwi_permisos`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `inventario_hwi_permisos_administradores`
--
ALTER TABLE `inventario_hwi_permisos_administradores`
  MODIFY `id_permisos_administradores` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `inventario_hwi_plataforma`
--
ALTER TABLE `inventario_hwi_plataforma`
  MODIFY `id_plataforma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `inventario_hwi_stock`
--
ALTER TABLE `inventario_hwi_stock`
  MODIFY `id_stock` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `inventario_hwi_tipo_almacenamientos`
--
ALTER TABLE `inventario_hwi_tipo_almacenamientos`
  MODIFY `id_tipo_almacenamiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `inventario_hwi_tipo_localizaciones`
--
ALTER TABLE `inventario_hwi_tipo_localizaciones`
  MODIFY `id_tipo_localizacion` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `inventario_hwi_tipo_novedades`
--
ALTER TABLE `inventario_hwi_tipo_novedades`
  MODIFY `id_novedad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `inventario_hwi_umb`
--
ALTER TABLE `inventario_hwi_umb`
  MODIFY `id_umb` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `inventario_hwi_almacenes_clasificaciones_almacenes`
--
ALTER TABLE `inventario_hwi_almacenes_clasificaciones_almacenes`
  ADD CONSTRAINT `relacion_almacenes_clasificaciones_intermedia` FOREIGN KEY (`id_almacen_almacenes_clasificaciones_almacenes`) REFERENCES `inventario_hwi_almacenes` (`id_almacen`) ON DELETE CASCADE,
  ADD CONSTRAINT `relacion_clasificacion_almacenes` FOREIGN KEY (`id_clasificacion_almacenes_almacenes_clasificaciones_almacenes`) REFERENCES `inventario_hwi_clasificacion_almacenes` (`id_clasificacion_almacenes`);

--
-- Filtros para la tabla `inventario_hwi_almacenes_localizaciones`
--
ALTER TABLE `inventario_hwi_almacenes_localizaciones`
  ADD CONSTRAINT `inventario_hwi_almacenes_localizaciones_ibfk_2` FOREIGN KEY (`id_localizacion_localizaciones`) REFERENCES `inventario_hwi_localizaciones` (`id_localizacion`) ON DELETE CASCADE,
  ADD CONSTRAINT `relacion_almacenes_almecenes_localizaciones` FOREIGN KEY (`id_almacen`) REFERENCES `inventario_hwi_almacenes` (`id_almacen`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inventario_hwi_cronograma`
--
ALTER TABLE `inventario_hwi_cronograma`
  ADD CONSTRAINT `relacion_administradores_cronograma` FOREIGN KEY (`id_administrador_cronograma`) REFERENCES `inventario_hwi_administradores` (`id_administrador`),
  ADD CONSTRAINT `relacion_estados_cronograma` FOREIGN KEY (`id_estado_cronograma`) REFERENCES `inventario_hwi_estados` (`id_estado`);

--
-- Filtros para la tabla `inventario_hwi_historico_cronograma`
--
ALTER TABLE `inventario_hwi_historico_cronograma`
  ADD CONSTRAINT `relacion_administradores_historico_cronograma` FOREIGN KEY (`id_administrador_historico_cronograma`) REFERENCES `inventario_hwi_administradores` (`id_administrador`),
  ADD CONSTRAINT `relacion_grupos_historico_cronograma` FOREIGN KEY (`id_grupo_historico_cronograma`) REFERENCES `inventario_hwi_grupos` (`id_grupo`);

--
-- Filtros para la tabla `inventario_hwi_historico_mb52`
--
ALTER TABLE `inventario_hwi_historico_mb52`
  ADD CONSTRAINT `relacion_almacen_historico_mb52` FOREIGN KEY (`id_almacen_historico_mb52`) REFERENCES `inventario_hwi_almacenes` (`id_almacen`),
  ADD CONSTRAINT `relacion_grupos_historico_mb52` FOREIGN KEY (`id_grupo_historico_mb52`) REFERENCES `inventario_hwi_grupos` (`id_grupo`),
  ADD CONSTRAINT `relacion_partnumbers_historico_mb52` FOREIGN KEY (`id_part_number_historico_mb52`) REFERENCES `inventario_hwi_partnumbers` (`id_partnumber`);

--
-- Filtros para la tabla `inventario_hwi_historico_stock`
--
ALTER TABLE `inventario_hwi_historico_stock`
  ADD CONSTRAINT `relacion_almacenes_historico_stock` FOREIGN KEY (`id_almacen_historico_stock`) REFERENCES `inventario_hwi_almacenes` (`id_almacen`),
  ADD CONSTRAINT `relacion_grupo_historico_stock` FOREIGN KEY (`id_grupo_historico_stock`) REFERENCES `inventario_hwi_grupos` (`id_grupo`),
  ADD CONSTRAINT `relacion_informacionSapMb52_historico_stock` FOREIGN KEY (`id_informacion_sap_mb52_historico_stock`) REFERENCES `inventario_hwi_informacion_sap_mb52` (`id_informacion_sap_mb52`),
  ADD CONSTRAINT `relacion_localizaciones_historico_stock` FOREIGN KEY (`id_localizacion_historico_stock`) REFERENCES `inventario_hwi_localizaciones` (`id_localizacion`),
  ADD CONSTRAINT `relacion_novedad_historico_stock` FOREIGN KEY (`id_novedad_historico_stock`) REFERENCES `inventario_hwi_tipo_novedades` (`id_novedad`),
  ADD CONSTRAINT `relacion_partnumbers_historico_stock` FOREIGN KEY (`id_partnumber_historico_stock`) REFERENCES `inventario_hwi_partnumbers` (`id_partnumber`);

--
-- Filtros para la tabla `inventario_hwi_historico_wm`
--
ALTER TABLE `inventario_hwi_historico_wm`
  ADD CONSTRAINT `relacion_idgrupo_historico_wm` FOREIGN KEY (`id_grupo_historico_wm`) REFERENCES `inventario_hwi_grupos` (`id_grupo`),
  ADD CONSTRAINT `relacion_localizaciones_historico_wm` FOREIGN KEY (`id_localizacion_historico_wm`) REFERENCES `inventario_hwi_localizaciones` (`id_localizacion`),
  ADD CONSTRAINT `relacion_mb52_historico_wm` FOREIGN KEY (`id_informacion_sap_mb52_historico_wm`) REFERENCES `inventario_hwi_informacion_sap_mb52` (`id_informacion_sap_mb52`),
  ADD CONSTRAINT `relacion_partnumbers-historico_wm` FOREIGN KEY (`id_partnumber_historico_wm`) REFERENCES `inventario_hwi_partnumbers` (`id_partnumber`);

--
-- Filtros para la tabla `inventario_hwi_informacion_sap_mb52`
--
ALTER TABLE `inventario_hwi_informacion_sap_mb52`
  ADD CONSTRAINT `relacion_almacenes_mb52` FOREIGN KEY (`id_almacen_informacion_sap_mb52`) REFERENCES `inventario_hwi_almacenes` (`id_almacen`) ON DELETE CASCADE,
  ADD CONSTRAINT `relacion_grupos_mb52` FOREIGN KEY (`id_grupo_informacion_sap_mb52`) REFERENCES `inventario_hwi_grupos` (`id_grupo`) ON DELETE CASCADE,
  ADD CONSTRAINT `relacion_pn_mb52` FOREIGN KEY (`id_part_number_informacion_sap_mb52`) REFERENCES `inventario_hwi_partnumbers` (`id_partnumber`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inventario_hwi_informacion_sap_wm`
--
ALTER TABLE `inventario_hwi_informacion_sap_wm`
  ADD CONSTRAINT `relacion_grupo` FOREIGN KEY (`id_grupo_informacion_sap_wm`) REFERENCES `inventario_hwi_grupos` (`id_grupo`),
  ADD CONSTRAINT `relacion_localizaciones_wm` FOREIGN KEY (`id_localizacion_informacion_sap_wm`) REFERENCES `inventario_hwi_localizaciones` (`id_localizacion`),
  ADD CONSTRAINT `relacion_mb52_wm` FOREIGN KEY (`id_informacion_sap_mb52_informacion_sap_wm`) REFERENCES `inventario_hwi_informacion_sap_mb52` (`id_informacion_sap_mb52`) ON DELETE CASCADE,
  ADD CONSTRAINT `relacion_pn_wm` FOREIGN KEY (`id_part_number_informacion_sap_wm`) REFERENCES `inventario_hwi_partnumbers` (`id_partnumber`);

--
-- Filtros para la tabla `inventario_hwi_localizaciones`
--
ALTER TABLE `inventario_hwi_localizaciones`
  ADD CONSTRAINT `relacion_localizaciones_tipo_almacenamiento` FOREIGN KEY (`id_tipo_almacenamientos_localizaciones`) REFERENCES `inventario_hwi_tipo_almacenamientos` (`id_tipo_almacenamiento`),
  ADD CONSTRAINT `relacion_tipo_localizaciones` FOREIGN KEY (`id_tipo_localizacion_localizaciones`) REFERENCES `inventario_hwi_tipo_localizaciones` (`id_tipo_localizacion`);

--
-- Filtros para la tabla `inventario_hwi_partnumbers`
--
ALTER TABLE `inventario_hwi_partnumbers`
  ADD CONSTRAINT `inventario_hwi_partnumbers_ibfk_1` FOREIGN KEY (`id_umb_partnumber`) REFERENCES `inventario_hwi_umb` (`id_umb`),
  ADD CONSTRAINT `relacion_plataformas_pn` FOREIGN KEY (`id_plataforma_partnumber`) REFERENCES `inventario_hwi_plataforma` (`id_plataforma`);

--
-- Filtros para la tabla `inventario_hwi_permisos_administradores`
--
ALTER TABLE `inventario_hwi_permisos_administradores`
  ADD CONSTRAINT `inventario_hwi_permisos_administradores_ibfk_1` FOREIGN KEY (`id_permiso_permisos`) REFERENCES `inventario_hwi_permisos` (`id_permiso`),
  ADD CONSTRAINT `inventario_hwi_permisos_administradores_ibfk_2` FOREIGN KEY (`id_administrador_permisos`) REFERENCES `inventario_hwi_administradores` (`id_administrador`);

--
-- Filtros para la tabla `inventario_hwi_stock`
--
ALTER TABLE `inventario_hwi_stock`
  ADD CONSTRAINT `PARTNUMBER` FOREIGN KEY (`id_partnumber_stock`) REFERENCES `inventario_hwi_partnumbers` (`id_partnumber`),
  ADD CONSTRAINT `inventario_hwi_stock_ibfk_3` FOREIGN KEY (`id_localizacion_stock`) REFERENCES `inventario_hwi_localizaciones` (`id_localizacion`),
  ADD CONSTRAINT `relacion_almacen_conteo` FOREIGN KEY (`id_almacen_stock`) REFERENCES `inventario_hwi_almacenes` (`id_almacen`),
  ADD CONSTRAINT `relacion_grupo_stock` FOREIGN KEY (`id_grupo_stock`) REFERENCES `inventario_hwi_grupos` (`id_grupo`),
  ADD CONSTRAINT `relacion_mb52_conteo` FOREIGN KEY (`id_informacion_sap_mb52_stock`) REFERENCES `inventario_hwi_informacion_sap_mb52` (`id_informacion_sap_mb52`),
  ADD CONSTRAINT `relacion_novedad_stock` FOREIGN KEY (`id_novedad_stock`) REFERENCES `inventario_hwi_tipo_novedades` (`id_novedad`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
