-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-06-2024 a las 20:27:55
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
-- Base de datos: `salidaeducativa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anexo_iv`
--

CREATE TABLE `anexo_iv` (
  `id` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `nombre_del_proyecto` varchar(100) NOT NULL,
  `denominacion_proyecto` varchar(100) NOT NULL,
  `lugar_a_visitar` varchar(100) NOT NULL,
  `fecha1` date NOT NULL,
  `lugar1` varchar(100) NOT NULL,
  `fecha2` date NOT NULL,
  `lugar2` varchar(100) NOT NULL,
  `intenerario` varchar(100) NOT NULL,
  `actividades` varchar(100) NOT NULL,
  `dni_encargado` int(11) NOT NULL,
  `apellido_y_nombre` varchar(100) NOT NULL,
  `cargo` int(11) NOT NULL,
  `cantidad_de_alumnos` int(100) NOT NULL,
  `cantidad_de_docentes_acompañantes` int(100) NOT NULL,
  `cantidad_de_no_docentes_acompañantes` int(100) NOT NULL,
  `total_de_personas` int(100) NOT NULL,
  `hospedaje` varchar(100) NOT NULL,
  `domicilio_del_hospedaje` varchar(100) NOT NULL,
  `telefono_del_hospedaje` int(100) NOT NULL,
  `localidad_del_hospedaje` varchar(100) NOT NULL,
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `anexo_iv`
--

INSERT INTO `anexo_iv` (`id`, `estado`, `nombre_del_proyecto`, `denominacion_proyecto`, `lugar_a_visitar`, `fecha1`, `lugar1`, `fecha2`, `lugar2`, `intenerario`, `actividades`, `dni_encargado`, `apellido_y_nombre`, `cargo`, `cantidad_de_alumnos`, `cantidad_de_docentes_acompañantes`, `cantidad_de_no_docentes_acompañantes`, `total_de_personas`, `hospedaje`, `domicilio_del_hospedaje`, `telefono_del_hospedaje`, `localidad_del_hospedaje`, `fecha_modificacion`) VALUES
(13, 1, 'A', 'A', 'A', '0123-03-12', 'A', '4121-12-04', 'A', 'A', 'A', 18892329, 'Paola Noemi Arrua Sosa', 2, 1, 1, 1, 1, 'A', 'A', 1, 'A', '2024-05-17 20:32:49'),
(14, 1, 'Villa la Angostura', 'XD', 'XD', '0000-00-00', 'XD', '0123-03-12', 'XD', 'XD', 'XD', 18892329, 'Paola Noemi Arrua Sosa', 2, 1, 1, 1, 1, 'XD', 'XD', 1, 'XD', '2024-06-10 03:21:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anexo_ix`
--

CREATE TABLE `anexo_ix` (
  `fk_anexoIV` int(11) NOT NULL,
  `Nombre_de_la_persona_o_razon_social_de_la_empresa` varchar(50) NOT NULL,
  `Domicilio_del_propietario_o_la_empresa` varchar(50) NOT NULL,
  `Telefono_del_propietario_o_la_empresa` int(50) NOT NULL,
  `Domicilio_del_gerente_o_responsable` varchar(50) NOT NULL,
  `Telefono` int(50) NOT NULL,
  `Telefono_movil` int(50) NOT NULL,
  `Titularidad_del_vehiculo` varchar(50) NOT NULL,
  `Compania_aseguradora` varchar(50) NOT NULL,
  `Numero_de_poliza` int(50) NOT NULL,
  `Tipo_de_seguro` varchar(50) NOT NULL,
  `Nombre_del_conductor1` varchar(50) NOT NULL,
  `DNI_conductor1` int(50) NOT NULL,
  `Licencia_N1` varchar(50) NOT NULL,
  `Vigencia1` varchar(50) NOT NULL,
  `Nombre_del_conductor2` varchar(50) NOT NULL,
  `DNI_del_conductor2` int(50) NOT NULL,
  `Licencia_N2` varchar(50) NOT NULL,
  `Vigencia2` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `anexo_ix`
--

INSERT INTO `anexo_ix` (`fk_anexoIV`, `Nombre_de_la_persona_o_razon_social_de_la_empresa`, `Domicilio_del_propietario_o_la_empresa`, `Telefono_del_propietario_o_la_empresa`, `Domicilio_del_gerente_o_responsable`, `Telefono`, `Telefono_movil`, `Titularidad_del_vehiculo`, `Compania_aseguradora`, `Numero_de_poliza`, `Tipo_de_seguro`, `Nombre_del_conductor1`, `DNI_conductor1`, `Licencia_N1`, `Vigencia1`, `Nombre_del_conductor2`, `DNI_del_conductor2`, `Licencia_N2`, `Vigencia2`) VALUES
(0, 'dfghjk', 'sdfgh', 0, 'sdfgh', 0, 0, 'sdfg', '', 0, 'dfgh', 'dfg', 0, 'ghdfgh', 'dfg', 'hdf', 0, 'dfgh', 'drftgyh'),
(0, 'sdfghj', 'sdfghjk', 0, 'sdf', 0, 0, 'hjf', '', 0, 'ghdfg', 'hjd', 0, 'dfgh', 'dfgh', 'dfgh', 0, 'dfg', 'hd'),
(0, 'dfghjk', 'dfghj', 0, 'dfghj', 0, 0, 'dfghj', '', 0, 'dfghj', 'dfghj', 0, 'jdfghj', 'dfghj', 'dfgh', 0, 'jdfg', 'hjdfgh');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anexo_v`
--

CREATE TABLE `anexo_v` (
  `fk_anexoIV` int(11) NOT NULL,
  `documento` int(8) NOT NULL,
  `apellido_y_nombre` varchar(255) NOT NULL,
  `edad` int(3) NOT NULL,
  `cargo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `anexo_v`
--

INSERT INTO `anexo_v` (`fk_anexoIV`, `documento`, `apellido_y_nombre`, `edad`, `cargo`) VALUES
(13, 18892329, 'Paola Noemi Arrua Sosa', 0, 2),
(13, 12121212, 'Exposito Santiago', 33, 3),
(13, 47950839, 'AAA', 15, 3),
(14, 18892329, 'Paola Noemi Arrua Sosa', 0, 2),
(14, 47950839, 'AXD', 15, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anexo_vi`
--

CREATE TABLE `anexo_vi` (
  `alumno` varchar(50) NOT NULL,
  `DNI` int(20) NOT NULL,
  `domicilio` varchar(50) NOT NULL,
  `num` int(10) NOT NULL,
  `localidad` varchar(50) NOT NULL,
  `telefono` int(20) NOT NULL,
  `lugar` varchar(35) NOT NULL,
  `fecha` date NOT NULL,
  `DNI_padre` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `anexo_vi`
--

INSERT INTO `anexo_vi` (`alumno`, `DNI`, `domicilio`, `num`, `localidad`, `telefono`, `lugar`, `fecha`, `DNI_padre`) VALUES
('Lorenzo Joaquin', 45822343, 'Calle 93', 756, 'Mar del Tuyú', 1173652393, 'Mi casa', '2024-04-09', 46822343),
('HELENA FERNANDEZ ARRUA', 47950839, 'jacaranda 648 ', 0, 'tu mama', 1, 'mi casa', '1111-11-11', 18892329);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anexo_vii`
--

CREATE TABLE `anexo_vii` (
  `id` int(20) NOT NULL,
  `fecha` date NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `nombre_padre` varchar(30) NOT NULL,
  `direccion` varchar(20) NOT NULL,
  `telefono` int(15) NOT NULL,
  `es_alergico` varchar(30) NOT NULL,
  `ha_sufrido` varchar(300) NOT NULL,
  `medicacion` varchar(30) NOT NULL,
  `obra_social` varchar(2) NOT NULL,
  `institucion` varchar(20) NOT NULL,
  `profesor` varchar(15) NOT NULL,
  `mes` varchar(20) NOT NULL,
  `id_salida` int(11) NOT NULL,
  `alergico_a` varchar(30) NOT NULL,
  `otro_malestar` varchar(30) NOT NULL,
  `su_medicacion` varchar(30) NOT NULL,
  `constancia` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anexo_viii`
--

CREATE TABLE `anexo_viii` (
  `institucion` varchar(50) NOT NULL,
  `fk_anexoIV` int(11) NOT NULL,
  `año` varchar(50) NOT NULL,
  `division` varchar(50) NOT NULL,
  `area` varchar(50) NOT NULL,
  `docente` varchar(50) NOT NULL,
  `objetivo` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `lugares` varchar(50) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `responsables` varchar(50) NOT NULL,
  `observaciones` varchar(50) NOT NULL,
  `descripcion2` varchar(50) NOT NULL,
  `responsables2` varchar(50) NOT NULL,
  `observaciones2` varchar(50) NOT NULL,
  `descripcion3` varchar(50) NOT NULL,
  `responsables3` varchar(50) NOT NULL,
  `observaciones3` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anexo_x`
--

CREATE TABLE `anexo_x` (
  `fk_anexoIV` int(11) NOT NULL,
  `empresa` varchar(30) NOT NULL,
  `localidad` varchar(30) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `telefono` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `anexo_x`
--

INSERT INTO `anexo_x` (`fk_anexoIV`, `empresa`, `localidad`, `direccion`, `telefono`) VALUES
(0, 'hvjhv', 'bn b nb', 'vgcgc', 4545);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivo_transporte`
--

CREATE TABLE `archivo_transporte` (
  `id` int(100) NOT NULL,
  `fk_anexoIV` int(11) NOT NULL,
  `id_salida` varchar(100) NOT NULL,
  `archivo` varchar(10000) NOT NULL,
  `tipo` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `id_cargo` int(11) NOT NULL,
  `Cargo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`id_cargo`, `Cargo`) VALUES
(1, 'Director'),
(2, 'Profesor'),
(3, 'Alumno'),
(4, 'Acompañante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_archivo`
--

CREATE TABLE `tipo_archivo` (
  `id_archivo` int(10) NOT NULL,
  `datos` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_archivo`
--

INSERT INTO `tipo_archivo` (`id_archivo`, `datos`) VALUES
(1, 'Cedula'),
(2, 'Certificado de aptitud tecnica'),
(3, 'CRNT'),
(4, 'VTV Nación'),
(5, 'VTV Provincia'),
(6, 'Documentación de los conductores');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anexo_iv`
--
ALTER TABLE `anexo_iv`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cargo` (`cargo`);

--
-- Indices de la tabla `anexo_v`
--
ALTER TABLE `anexo_v`
  ADD KEY `fk_anexoIV` (`fk_anexoIV`),
  ADD KEY `documento` (`documento`),
  ADD KEY `cargo` (`cargo`);

--
-- Indices de la tabla `anexo_vi`
--
ALTER TABLE `anexo_vi`
  ADD PRIMARY KEY (`DNI`);

--
-- Indices de la tabla `anexo_vii`
--
ALTER TABLE `anexo_vii`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `archivo_transporte`
--
ALTER TABLE `archivo_transporte`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id_cargo`);

--
-- Indices de la tabla `tipo_archivo`
--
ALTER TABLE `tipo_archivo`
  ADD PRIMARY KEY (`id_archivo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anexo_iv`
--
ALTER TABLE `anexo_iv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `anexo_vii`
--
ALTER TABLE `anexo_vii`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `archivo_transporte`
--
ALTER TABLE `archivo_transporte`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `anexo_iv`
--
ALTER TABLE `anexo_iv`
  ADD CONSTRAINT `anexo_iv_ibfk_1` FOREIGN KEY (`cargo`) REFERENCES `cargo` (`id_cargo`);

--
-- Filtros para la tabla `anexo_v`
--
ALTER TABLE `anexo_v`
  ADD CONSTRAINT `anexo_v_ibfk_1` FOREIGN KEY (`fk_anexoIV`) REFERENCES `anexo_iv` (`id`),
  ADD CONSTRAINT `anexo_v_ibfk_3` FOREIGN KEY (`cargo`) REFERENCES `cargo` (`id_cargo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
