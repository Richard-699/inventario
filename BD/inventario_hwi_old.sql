-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-10-2025 a las 04:33:00
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
(18, '393f7b1e-6db1-4cf3-af2f-0350b5bb6436', 4),
(19, '486836be-8808-4368-a680-b7cb09126041', 4),
(20, 'fbcdeabb-5c8c-4353-a78f-53e26223d0c1', 4),
(21, 'd6070b12-c723-49ed-b08a-0ba09a37936d', 4),
(22, '8202686d-6d50-4419-9e0f-95a735e33bef', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_hwi_almacenes_localizaciones`
--

CREATE TABLE `inventario_hwi_almacenes_localizaciones` (
  `id_localizaciones_almacenes` int(11) NOT NULL,
  `id_almacen` varchar(300) NOT NULL,
  `id_localizacion_localizaciones` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario_hwi_almacenes_localizaciones`
--

INSERT INTO `inventario_hwi_almacenes_localizaciones` (`id_localizaciones_almacenes`, `id_almacen`, `id_localizacion_localizaciones`) VALUES
(46, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 15),
(47, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 19),
(48, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 20),
(49, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 21),
(50, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 22),
(51, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 23),
(52, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 24),
(53, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 25),
(54, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 26),
(55, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 27),
(56, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 28),
(57, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 29),
(58, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 30),
(59, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 31),
(60, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 32),
(61, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 33),
(62, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 34),
(63, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 35),
(64, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 36),
(65, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 37),
(66, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 38),
(67, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 39),
(68, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 40),
(69, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 41),
(70, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 42),
(71, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 43),
(72, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 44),
(73, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 45),
(74, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 46),
(75, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 47),
(76, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 48),
(77, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 49),
(78, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 50),
(79, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 51),
(80, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 52),
(81, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 53),
(82, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 54),
(83, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 55),
(84, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 56),
(85, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 57),
(86, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 58),
(87, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 59),
(88, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 60),
(89, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 61),
(90, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 62),
(91, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 63),
(92, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 64),
(93, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 65),
(94, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 66),
(95, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 67),
(96, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 68),
(97, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 69),
(98, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 70),
(99, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 71),
(100, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 72),
(101, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 73),
(102, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 74),
(103, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 75),
(104, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 76),
(105, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 77),
(106, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 78),
(107, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 79),
(108, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 80),
(109, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 81),
(110, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 82),
(111, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 83),
(112, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 84),
(113, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 85),
(114, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 86),
(115, '393f7b1e-6db1-4cf3-af2f-0350b5bb6436', 88),
(116, '486836be-8808-4368-a680-b7cb09126041', 89),
(117, 'fbcdeabb-5c8c-4353-a78f-53e26223d0c1', 90),
(118, 'd6070b12-c723-49ed-b08a-0ba09a37936d', 16),
(119, 'd6070b12-c723-49ed-b08a-0ba09a37936d', 17),
(120, 'd6070b12-c723-49ed-b08a-0ba09a37936d', 18),
(121, 'd6070b12-c723-49ed-b08a-0ba09a37936d', 87),
(122, '8202686d-6d50-4419-9e0f-95a735e33bef', 91);

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
  `estado_conteo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario_hwi_conteos`
--

INSERT INTO `inventario_hwi_conteos` (`id_conteo`, `id_grupo_conteo`, `id_encargado_conteo`, `fecha_hora_inicio_conteo`, `fecha_hora_final_conteo`, `observaciones_conteo`, `estado_conteo`) VALUES
(15, '083f6734-b14b-44e7-8003-be8b4feb7c29', '51d0d540-2777-49ef-9de3-a08dda914ca7', '2025-10-09 15:23:04', '2025-10-10 22:29:03', 'Todo bien en este conteo, sin inconvenientes', NULL);

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

--
-- Volcado de datos para la tabla `inventario_hwi_cronograma`
--

INSERT INTO `inventario_hwi_cronograma` (`id_cronograma`, `fecha_cronograma`, `id_grupo_cronograma`, `id_estado_cronograma`, `id_administrador_cronograma`) VALUES
(6, '2026-01', '083f6734-b14b-44e7-8003-be8b4feb7c29', 3, NULL),
(7, '2025-11', '6bc9f10f-ee27-4e0e-9256-ece2cf502091', 1, NULL);

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

--
-- Volcado de datos para la tabla `inventario_hwi_exactitud`
--

INSERT INTO `inventario_hwi_exactitud` (`id_exactitud`, `partnumber_exactitud`, `descripcion_partnumber_exactitud`, `tipo_almacen_exactitud`, `area_almacenamiento_exactitud`, `localizacion_exactitud`, `coincide_exactitud`, `novedad_exactitud`, `descripcion_novedad_exactitud`, `fecha_hora_migracion_exactitud`, `id_administrador`) VALUES
(27098, '<< vacías >>', 'Partnumber no registrado en el sistema', '901', '001', 'GFI-ZONE', NULL, NULL, NULL, '2025-10-07 14:57:03', '51d0d540-2777-49ef-9de3-a08dda914ca7'),
(27099, '<< vacías >>', 'Partnumber no registrado en el sistema', '901', '001', 'WE-ZONE', NULL, NULL, NULL, '2025-10-07 14:57:03', '51d0d540-2777-49ef-9de3-a08dda914ca7'),
(28440, 'W10638603', 'Partnumber no registrado en el sistema', '902', '001', 'GR-ZONE', NULL, NULL, NULL, '2025-10-08 13:23:18', '51d0d540-2777-49ef-9de3-a08dda914ca7'),
(28441, 'W11195522', 'Partnumber no registrado en el sistema', '902', '001', 'GR-ZONE', NULL, NULL, NULL, '2025-10-08 13:23:18', '51d0d540-2777-49ef-9de3-a08dda914ca7'),
(28442, 'W11428263', 'Partnumber no registrado en el sistema', '902', '001', 'GR-ZONE', NULL, NULL, NULL, '2025-10-08 13:23:18', '51d0d540-2777-49ef-9de3-a08dda914ca7'),
(28443, 'W11486068', 'Partnumber no registrado en el sistema', '902', '001', 'GR-ZONE', NULL, NULL, NULL, '2025-10-08 13:23:18', '51d0d540-2777-49ef-9de3-a08dda914ca7'),
(28444, 'W11496616', 'Partnumber no registrado en el sistema', '902', '001', 'GR-ZONE', NULL, NULL, NULL, '2025-10-08 13:23:18', '51d0d540-2777-49ef-9de3-a08dda914ca7'),
(28445, 'W11642310', 'Partnumber no registrado en el sistema', '902', '001', 'GR-ZONE', NULL, NULL, NULL, '2025-10-08 13:23:18', '51d0d540-2777-49ef-9de3-a08dda914ca7'),
(28446, 'W11667598', 'CAJA ENGRENAJE COPA 2.0 QIJING', '902', '001', 'GR-ZONE', 'Si', 'Sin Novedad', 'SIN NOVEDADES', '2025-10-08 13:23:18', '51d0d540-2777-49ef-9de3-a08dda914ca7'),
(28447, 'W11733713', 'Partnumber no registrado en el sistema', '902', '001', 'GR-ZONE', NULL, NULL, NULL, '2025-10-08 13:23:18', '51d0d540-2777-49ef-9de3-a08dda914ca7'),
(28448, 'W11733727', 'Partnumber no registrado en el sistema', '902', '001', 'GR-ZONE', NULL, NULL, NULL, '2025-10-08 13:23:18', '51d0d540-2777-49ef-9de3-a08dda914ca7'),
(28449, '<< vacías >>', 'Partnumber no registrado en el sistema', '902', '001', 'WE-ZONE', NULL, NULL, NULL, '2025-10-08 13:23:18', '51d0d540-2777-49ef-9de3-a08dda914ca7');

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

--
-- Volcado de datos para la tabla `inventario_hwi_grupos`
--

INSERT INTO `inventario_hwi_grupos` (`id_grupo`, `descripcion_grupo`, `fecha_programacion_grupo`, `informacion_migrada_sap_grupo`) VALUES
('083f6734-b14b-44e7-8003-be8b4feb7c29', 'GRUPO PRUEBA', '2026-01', 0),
('6bc9f10f-ee27-4e0e-9256-ece2cf502091', 'GRUPO PRUEBA 2', '2025-11', 0);

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

--
-- Volcado de datos para la tabla `inventario_hwi_historico_mb52`
--

INSERT INTO `inventario_hwi_historico_mb52` (`id_historico_mb52`, `id_informacion_sap_mb52_historico_mb52`, `fecha_historico_mb52`, `cantidad_historico_mb52`, `fechaRegistro_historico_mb52`, `id_part_number_historico_mb52`, `id_almacen_historico_mb52`, `id_grupo_historico_mb52`) VALUES
(66, '0c480f1e-10e3-4e20-affb-6be26035c3fd', '2025-10-10', 4704.000, '2025-10-09', 12, '393f7b1e-6db1-4cf3-af2f-0350b5bb6436', '083f6734-b14b-44e7-8003-be8b4feb7c29'),
(67, '376bb3b5-716e-4fcd-a45d-236ea02912ba', '2025-10-10', 1000.000, '2025-10-09', 12, 'd6070b12-c723-49ed-b08a-0ba09a37936d', '083f6734-b14b-44e7-8003-be8b4feb7c29'),
(68, '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06', '2025-10-10', 21560.000, '2025-10-09', 12, 'cff383c1-6c34-4c11-868c-57f4850abc7d', '083f6734-b14b-44e7-8003-be8b4feb7c29'),
(69, '92320fd1-5a46-4483-8d1c-a5f948e61035', '2025-10-10', 15680.000, '2025-10-09', 12, '8202686d-6d50-4419-9e0f-95a735e33bef', '083f6734-b14b-44e7-8003-be8b4feb7c29'),
(70, 'a58a9d47-5237-4551-aa72-24c9773150d3', '2025-10-10', 1323.000, '2025-10-09', 13, 'cff383c1-6c34-4c11-868c-57f4850abc7d', '083f6734-b14b-44e7-8003-be8b4feb7c29'),
(71, 'c0cda7e7-ff6f-4b66-82fa-189bd27de100', '2025-10-10', 7366.000, '2025-10-09', 13, '393f7b1e-6db1-4cf3-af2f-0350b5bb6436', '083f6734-b14b-44e7-8003-be8b4feb7c29'),
(72, 'e2143e67-1f7d-47a9-a5e8-c52e7bac6793', '2025-10-10', 405.200, '2025-10-09', 12, '486836be-8808-4368-a680-b7cb09126041', '083f6734-b14b-44e7-8003-be8b4feb7c29'),
(73, 'f41e54e0-4eef-426e-a4f1-7f021f8dde0c', '2025-10-10', 354.000, '2025-10-09', 13, '486836be-8808-4368-a680-b7cb09126041', '083f6734-b14b-44e7-8003-be8b4feb7c29');

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

--
-- Volcado de datos para la tabla `inventario_hwi_historico_wm`
--

INSERT INTO `inventario_hwi_historico_wm` (`id_historico_wm`, `fecha_historico_wm`, `stock_disponible_historico_wm`, `stock_entrada_historico_wm`, `stock_salida_historico_wm`, `id_localizacion_historico_wm`, `id_partnumber_historico_wm`, `id_grupo_historico_wm`, `id_informacion_sap_mb52_historico_wm`) VALUES
(826, '2025-10-10', 196.000, 0.000, 0.000, 15, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(827, '2025-10-10', 196.000, 0.000, 0.000, 15, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(828, '2025-10-10', 196.000, 0.000, 0.000, 17, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(829, '2025-10-10', 196.000, 0.000, 0.000, 18, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(830, '2025-10-10', 0.000, 0.000, 196.000, 19, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(831, '2025-10-10', 196.000, 0.000, 0.000, 20, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(832, '2025-10-10', 196.000, 0.000, 0.000, 21, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(833, '2025-10-10', 196.000, 0.000, 0.000, 21, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(834, '2025-10-10', 147.000, 0.000, 0.000, 22, 13, '083f6734-b14b-44e7-8003-be8b4feb7c29', 'a58a9d47-5237-4551-aa72-24c9773150d3'),
(835, '2025-10-10', 147.000, 0.000, 0.000, 22, 13, '083f6734-b14b-44e7-8003-be8b4feb7c29', 'a58a9d47-5237-4551-aa72-24c9773150d3'),
(836, '2025-10-10', 147.000, 0.000, 0.000, 23, 13, '083f6734-b14b-44e7-8003-be8b4feb7c29', 'a58a9d47-5237-4551-aa72-24c9773150d3'),
(837, '2025-10-10', 147.000, 0.000, 0.000, 23, 13, '083f6734-b14b-44e7-8003-be8b4feb7c29', 'a58a9d47-5237-4551-aa72-24c9773150d3'),
(838, '2025-10-10', 196.000, 0.000, 0.000, 24, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(839, '2025-10-10', 196.000, 0.000, 0.000, 24, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(840, '2025-10-10', 196.000, 0.000, 0.000, 25, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(841, '2025-10-10', 196.000, 0.000, 0.000, 25, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(842, '2025-10-10', 196.000, 0.000, 0.000, 26, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(843, '2025-10-10', 196.000, 0.000, 0.000, 26, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(844, '2025-10-10', 196.000, 0.000, 0.000, 27, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(845, '2025-10-10', 196.000, 0.000, 0.000, 27, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(846, '2025-10-10', 196.000, 0.000, 0.000, 28, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(847, '2025-10-10', 196.000, 0.000, 0.000, 28, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(848, '2025-10-10', 196.000, 0.000, 0.000, 29, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(849, '2025-10-10', 196.000, 0.000, 0.000, 29, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(850, '2025-10-10', 196.000, 0.000, 0.000, 30, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(851, '2025-10-10', 196.000, 0.000, 0.000, 30, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(852, '2025-10-10', 196.000, 0.000, 0.000, 31, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(853, '2025-10-10', 196.000, 0.000, 0.000, 31, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(854, '2025-10-10', 196.000, 0.000, 0.000, 32, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(855, '2025-10-10', 196.000, 0.000, 0.000, 32, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(856, '2025-10-10', 196.000, 0.000, 0.000, 33, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(857, '2025-10-10', 196.000, 0.000, 0.000, 34, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(858, '2025-10-10', 196.000, 0.000, 0.000, 35, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(859, '2025-10-10', 196.000, 0.000, 0.000, 36, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(860, '2025-10-10', 196.000, 0.000, 0.000, 37, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(861, '2025-10-10', 196.000, 0.000, 0.000, 38, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(862, '2025-10-10', 147.000, 0.000, 0.000, 39, 13, '083f6734-b14b-44e7-8003-be8b4feb7c29', 'a58a9d47-5237-4551-aa72-24c9773150d3'),
(863, '2025-10-10', 196.000, 0.000, 0.000, 40, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(864, '2025-10-10', 196.000, 0.000, 0.000, 41, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(865, '2025-10-10', 196.000, 0.000, 0.000, 41, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(866, '2025-10-10', 196.000, 0.000, 0.000, 42, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(867, '2025-10-10', 196.000, 0.000, 0.000, 42, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(868, '2025-10-10', 196.000, 0.000, 0.000, 43, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(869, '2025-10-10', 196.000, 0.000, 0.000, 43, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(870, '2025-10-10', 0.000, 196.000, 0.000, 44, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(871, '2025-10-10', 196.000, 0.000, 0.000, 44, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(872, '2025-10-10', 196.000, 0.000, 0.000, 45, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(873, '2025-10-10', 196.000, 0.000, 0.000, 45, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(874, '2025-10-10', 196.000, 0.000, 0.000, 46, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(875, '2025-10-10', 196.000, 0.000, 0.000, 46, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(876, '2025-10-10', 196.000, 0.000, 0.000, 47, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(877, '2025-10-10', 196.000, 0.000, 0.000, 47, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(878, '2025-10-10', 196.000, 0.000, 0.000, 48, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(879, '2025-10-10', 196.000, 0.000, 0.000, 48, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(880, '2025-10-10', 147.000, 0.000, 0.000, 49, 13, '083f6734-b14b-44e7-8003-be8b4feb7c29', 'a58a9d47-5237-4551-aa72-24c9773150d3'),
(881, '2025-10-10', 147.000, 0.000, 0.000, 49, 13, '083f6734-b14b-44e7-8003-be8b4feb7c29', 'a58a9d47-5237-4551-aa72-24c9773150d3'),
(882, '2025-10-10', 196.000, 0.000, 0.000, 50, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(883, '2025-10-10', 196.000, 0.000, 0.000, 50, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(884, '2025-10-10', 196.000, 0.000, 0.000, 51, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(885, '2025-10-10', 196.000, 0.000, 0.000, 51, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(886, '2025-10-10', 196.000, 0.000, 0.000, 52, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(887, '2025-10-10', 196.000, 0.000, 0.000, 52, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(888, '2025-10-10', 196.000, 0.000, 0.000, 53, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(889, '2025-10-10', 196.000, 0.000, 0.000, 53, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(890, '2025-10-10', 0.000, 0.000, 196.000, 54, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(891, '2025-10-10', 196.000, 0.000, 0.000, 55, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(892, '2025-10-10', 196.000, 0.000, 0.000, 56, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(893, '2025-10-10', 196.000, 0.000, 0.000, 57, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(894, '2025-10-10', 196.000, 0.000, 0.000, 58, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(895, '2025-10-10', 196.000, 0.000, 0.000, 59, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(896, '2025-10-10', 196.000, 0.000, 0.000, 60, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(897, '2025-10-10', 147.000, 0.000, 0.000, 61, 13, '083f6734-b14b-44e7-8003-be8b4feb7c29', 'a58a9d47-5237-4551-aa72-24c9773150d3'),
(898, '2025-10-10', 196.000, 0.000, 0.000, 62, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(899, '2025-10-10', 196.000, 0.000, 0.000, 62, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(900, '2025-10-10', 196.000, 0.000, 0.000, 63, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(901, '2025-10-10', 196.000, 0.000, 0.000, 63, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(902, '2025-10-10', 196.000, 0.000, 0.000, 64, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(903, '2025-10-10', 196.000, 0.000, 0.000, 64, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(904, '2025-10-10', 196.000, 0.000, 0.000, 65, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(905, '2025-10-10', 196.000, 0.000, 0.000, 65, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(906, '2025-10-10', 196.000, 0.000, 0.000, 66, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(907, '2025-10-10', 196.000, 0.000, 0.000, 66, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(908, '2025-10-10', 196.000, 0.000, 0.000, 67, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(909, '2025-10-10', 196.000, 0.000, 0.000, 67, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(910, '2025-10-10', 196.000, 0.000, 0.000, 68, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(911, '2025-10-10', 196.000, 0.000, 0.000, 68, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(912, '2025-10-10', 196.000, 0.000, 0.000, 69, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(913, '2025-10-10', 196.000, 0.000, 0.000, 69, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(914, '2025-10-10', 196.000, 0.000, 0.000, 70, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(915, '2025-10-10', 196.000, 0.000, 0.000, 70, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(916, '2025-10-10', 196.000, 0.000, 0.000, 71, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(917, '2025-10-10', 196.000, 0.000, 0.000, 71, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(918, '2025-10-10', 196.000, 0.000, 0.000, 72, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(919, '2025-10-10', 196.000, 0.000, 0.000, 72, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(920, '2025-10-10', 196.000, 0.000, 0.000, 73, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(921, '2025-10-10', 196.000, 0.000, 0.000, 73, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(922, '2025-10-10', 196.000, 0.000, 0.000, 74, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(923, '2025-10-10', 196.000, 0.000, 0.000, 74, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(924, '2025-10-10', 196.000, 0.000, 0.000, 75, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(925, '2025-10-10', 196.000, 0.000, 0.000, 75, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(926, '2025-10-10', 196.000, 0.000, 0.000, 76, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(927, '2025-10-10', 196.000, 0.000, 0.000, 76, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(928, '2025-10-10', 196.000, 0.000, 0.000, 77, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(929, '2025-10-10', 196.000, 0.000, 0.000, 77, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(930, '2025-10-10', 196.000, 0.000, 0.000, 78, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(931, '2025-10-10', 196.000, 0.000, 0.000, 78, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(932, '2025-10-10', 196.000, 0.000, 0.000, 79, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(933, '2025-10-10', 196.000, 0.000, 0.000, 79, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(934, '2025-10-10', 196.000, 0.000, 0.000, 80, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(935, '2025-10-10', 196.000, 0.000, 0.000, 80, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(936, '2025-10-10', 196.000, 0.000, 0.000, 81, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(937, '2025-10-10', 196.000, 0.000, 0.000, 81, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(938, '2025-10-10', 196.000, 0.000, 0.000, 82, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(939, '2025-10-10', 196.000, 0.000, 0.000, 82, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(940, '2025-10-10', 196.000, 0.000, 0.000, 83, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(941, '2025-10-10', 196.000, 0.000, 0.000, 83, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(942, '2025-10-10', 196.000, 0.000, 0.000, 84, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(943, '2025-10-10', 196.000, 0.000, 0.000, 84, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(944, '2025-10-10', 147.000, 0.000, 0.000, 85, 13, '083f6734-b14b-44e7-8003-be8b4feb7c29', 'a58a9d47-5237-4551-aa72-24c9773150d3'),
(945, '2025-10-10', 196.000, 196.000, 0.000, 86, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06'),
(946, '2025-10-10', 1000.000, 0.000, 0.000, 87, 12, '083f6734-b14b-44e7-8003-be8b4feb7c29', '376bb3b5-716e-4fcd-a45d-236ea02912ba');

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

--
-- Volcado de datos para la tabla `inventario_hwi_informacion_sap_mb52`
--

INSERT INTO `inventario_hwi_informacion_sap_mb52` (`id_informacion_sap_mb52`, `fecha_registro_informacion_sap_mb52`, `id_part_number_informacion_sap_mb52`, `cantidad_informacion_sap_mb52`, `id_almacen_informacion_sap_mb52`, `id_grupo_informacion_sap_mb52`) VALUES
('0c480f1e-10e3-4e20-affb-6be26035c3fd', '2025-10-09', 12, 4704.000, '393f7b1e-6db1-4cf3-af2f-0350b5bb6436', '083f6734-b14b-44e7-8003-be8b4feb7c29'),
('30c5f247-acca-4832-9433-c6e791493132', '2025-10-09', 14, 392.000, 'cff383c1-6c34-4c11-868c-57f4850abc7d', '6bc9f10f-ee27-4e0e-9256-ece2cf502091'),
('31b9d379-3b10-49c8-9bed-1427e3081fbb', '2025-10-09', 14, 12936.000, '393f7b1e-6db1-4cf3-af2f-0350b5bb6436', '6bc9f10f-ee27-4e0e-9256-ece2cf502091'),
('376bb3b5-716e-4fcd-a45d-236ea02912ba', '2025-10-09', 12, 1000.000, 'd6070b12-c723-49ed-b08a-0ba09a37936d', '083f6734-b14b-44e7-8003-be8b4feb7c29'),
('3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06', '2025-10-09', 12, 21560.000, 'cff383c1-6c34-4c11-868c-57f4850abc7d', '083f6734-b14b-44e7-8003-be8b4feb7c29'),
('46c0477e-66c1-4145-807e-16446f35d696', '2025-10-09', 15, 73.919, 'fbcdeabb-5c8c-4353-a78f-53e26223d0c1', '6bc9f10f-ee27-4e0e-9256-ece2cf502091'),
('92320fd1-5a46-4483-8d1c-a5f948e61035', '2025-10-09', 12, 15680.000, '8202686d-6d50-4419-9e0f-95a735e33bef', '083f6734-b14b-44e7-8003-be8b4feb7c29'),
('a58a9d47-5237-4551-aa72-24c9773150d3', '2025-10-09', 13, 1323.000, 'cff383c1-6c34-4c11-868c-57f4850abc7d', '083f6734-b14b-44e7-8003-be8b4feb7c29'),
('c0cda7e7-ff6f-4b66-82fa-189bd27de100', '2025-10-09', 13, 7366.000, '393f7b1e-6db1-4cf3-af2f-0350b5bb6436', '083f6734-b14b-44e7-8003-be8b4feb7c29'),
('ca58ef3b-bc09-479f-b4bc-0c830ab362c6', '2025-10-09', 15, 1194.800, '486836be-8808-4368-a680-b7cb09126041', '6bc9f10f-ee27-4e0e-9256-ece2cf502091'),
('cb14606d-9800-4a28-ae20-fb112bb3cb13', '2025-10-09', 14, 359.000, '486836be-8808-4368-a680-b7cb09126041', '6bc9f10f-ee27-4e0e-9256-ece2cf502091'),
('e2143e67-1f7d-47a9-a5e8-c52e7bac6793', '2025-10-09', 12, 405.200, '486836be-8808-4368-a680-b7cb09126041', '083f6734-b14b-44e7-8003-be8b4feb7c29'),
('f41e54e0-4eef-426e-a4f1-7f021f8dde0c', '2025-10-09', 13, 354.000, '486836be-8808-4368-a680-b7cb09126041', '083f6734-b14b-44e7-8003-be8b4feb7c29'),
('fd2207e5-6ca4-48ba-a599-efc1075a79fc', '2025-10-09', 15, 98.000, '393f7b1e-6db1-4cf3-af2f-0350b5bb6436', '6bc9f10f-ee27-4e0e-9256-ece2cf502091');

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

--
-- Volcado de datos para la tabla `inventario_hwi_informacion_sap_wm`
--

INSERT INTO `inventario_hwi_informacion_sap_wm` (`id_informacion_sap_wm`, `id_part_number_informacion_sap_wm`, `id_localizacion_informacion_sap_wm`, `id_grupo_informacion_sap_wm`, `id_informacion_sap_mb52_informacion_sap_wm`, `stock_disponible_sap_informacion_sap_wm`, `stock_entrada_sap_informacion_sap_wm`, `stock_salida_sap_informacion_sap_wm`) VALUES
(1970, 14, 16, '6bc9f10f-ee27-4e0e-9256-ece2cf502091', '30c5f247-acca-4832-9433-c6e791493132', 196.000, 0.000, 0.000),
(2088, 14, 85, '6bc9f10f-ee27-4e0e-9256-ece2cf502091', '30c5f247-acca-4832-9433-c6e791493132', 196.000, 0.000, 0.000);

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

--
-- Volcado de datos para la tabla `inventario_hwi_partnumbers`
--

INSERT INTO `inventario_hwi_partnumbers` (`id_partnumber`, `partnumber`, `descripcion_breve`, `id_umb_partnumber`, `nombre_interno`, `id_grupo_partnumber`, `id_plataforma_partnumber`) VALUES
(12, 'W11667598', 'CAJA ENGRENAJE COPA 2.0 QIJING', 7, 'CAJA ENGRENAJE COPA 2.0 QIJING', '083f6734-b14b-44e7-8003-be8b4feb7c29', 4),
(13, 'W10777493', 'CJ MECANISMO', 7, 'CJ MECANISMO', '083f6734-b14b-44e7-8003-be8b4feb7c29', 5),
(14, 'W11667597', 'CAJA ENGRANAJE COPA 1.0 QIJING', 7, 'CAJA ENGRANAJE COPA 1.0 QIJING', '6bc9f10f-ee27-4e0e-9256-ece2cf502091', 3),
(15, 'W11499432', 'CJ MECANISMO', 3, 'CJ MECANISMO', '6bc9f10f-ee27-4e0e-9256-ece2cf502091', 4);

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

--
-- Volcado de datos para la tabla `inventario_hwi_stock`
--

INSERT INTO `inventario_hwi_stock` (`id_stock`, `id_partnumber_stock`, `id_almacen_stock`, `id_localizacion_stock`, `cantidad_stock`, `id_informacion_sap_mb52_stock`, `id_novedad_stock`, `observaciones_novedad_stock`, `id_grupo_stock`, `id_conteo_stock`, `fecha_hora_stock`, `id_administrador_stock`) VALUES
(66, 12, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 15, 20.000, '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06', NULL, 'Sin novedades', '083f6734-b14b-44e7-8003-be8b4feb7c29', 15, '2025-10-09 16:23:33', '51d0d540-2777-49ef-9de3-a08dda914ca7'),
(67, 12, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 17, 300.000, '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06', NULL, 'Sin novedades', '083f6734-b14b-44e7-8003-be8b4feb7c29', 15, '2025-10-09 16:32:52', '51d0d540-2777-49ef-9de3-a08dda914ca7'),
(68, 12, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 18, 90.000, '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06', NULL, 'Sin novedades', '083f6734-b14b-44e7-8003-be8b4feb7c29', 15, '2025-10-10 10:43:05', '51d0d540-2777-49ef-9de3-a08dda914ca7'),
(69, 12, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 19, 100.000, '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06', NULL, 'Todo en orden', '083f6734-b14b-44e7-8003-be8b4feb7c29', 15, '2025-10-10 10:45:41', '51d0d540-2777-49ef-9de3-a08dda914ca7'),
(70, 12, 'cff383c1-6c34-4c11-868c-57f4850abc7d', 20, 200.000, '3bbf77d2-52d3-4bb4-9aa7-fc8c46d24b06', NULL, 'Se encuentra novedad ya que se utiliza cierta cantidad para la producción xxxxxxxxxxx', '083f6734-b14b-44e7-8003-be8b4feb7c29', 15, '2025-10-10 11:19:54', '51d0d540-2777-49ef-9de3-a08dda914ca7'),
(71, 12, '393f7b1e-6db1-4cf3-af2f-0350b5bb6436', 88, 4800.000, '0c480f1e-10e3-4e20-affb-6be26035c3fd', NULL, 'Se encuentran algunas unidades de mas', '083f6734-b14b-44e7-8003-be8b4feb7c29', 15, '2025-10-10 12:26:56', '51d0d540-2777-49ef-9de3-a08dda914ca7'),
(72, 12, 'd6070b12-c723-49ed-b08a-0ba09a37936d', 87, 999.000, '376bb3b5-716e-4fcd-a45d-236ea02912ba', NULL, 'Todo en orden', '083f6734-b14b-44e7-8003-be8b4feb7c29', 15, '2025-10-10 12:28:37', '51d0d540-2777-49ef-9de3-a08dda914ca7');

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
  MODIFY `id_almacenes_clasificaciones_almacenes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
  MODIFY `id_exactitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28450;

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
