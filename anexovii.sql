-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 02-11-2024 a las 20:33:33
-- Versión del servidor: 8.2.0
-- Versión de PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `escuela`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anexovii`
--

DROP TABLE IF EXISTS `anexovii`;
CREATE TABLE IF NOT EXISTS `anexovii` (
  `fkAnexoIV` int NOT NULL,
  `dniEstudiante` int NOT NULL,
  `domicilio` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `altura` int NOT NULL,
  `localidad` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `observaciones` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `obraSocial` tinyint(1) NOT NULL,
  `nombreObraSocial` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `numeroAfiliado` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `telefonos` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  KEY `fkAnexoIV` (`fkAnexoIV`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `anexovii`
--
ALTER TABLE `anexovii`
  ADD CONSTRAINT `anexovii_ibfk_1` FOREIGN KEY (`fkAnexoIV`) REFERENCES `anexoiv` (`idAnexoIV`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
