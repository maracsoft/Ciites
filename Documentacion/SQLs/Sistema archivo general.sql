-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-05-2022 a las 01:19:37
-- Versión del servidor: 5.7.32-log
-- Versión de PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `maracsof_cedepas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivo_general`
--

CREATE TABLE `archivo_general` (
  `codArchivo` int(11) NOT NULL,
  `nombreAparente` varchar(300) NOT NULL,
  `nombreGuardado` varchar(300) NOT NULL,
  `codTipoArchivo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_archivo_general`
--

CREATE TABLE `tipo_archivo_general` (
  `codTipoArchivo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_archivo_general`
--

INSERT INTO `tipo_archivo_general` (`codTipoArchivo`, `nombre`) VALUES
(1, 'ServicioCite');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivo_general`
--
ALTER TABLE `archivo_general`
  ADD PRIMARY KEY (`codArchivo`);

--
-- Indices de la tabla `tipo_archivo_general`
--
ALTER TABLE `tipo_archivo_general`
  ADD PRIMARY KEY (`codTipoArchivo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivo_general`
--
ALTER TABLE `archivo_general`
  MODIFY `codArchivo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_archivo_general`
--
ALTER TABLE `tipo_archivo_general`
  MODIFY `codTipoArchivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
