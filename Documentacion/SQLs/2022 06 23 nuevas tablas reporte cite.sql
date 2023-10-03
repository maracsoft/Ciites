-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-06-2022 a las 06:41:19
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
-- Estructura de tabla para la tabla `cite-estado_reporte_mensual`
--

CREATE TABLE `cite-estado_reporte_mensual` (
  `codEstado` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `explicacion` varchar(200) NOT NULL,
  `icono` varchar(50) NOT NULL,
  `claseBoton` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cite-reporte_mensual`
--

CREATE TABLE `cite-reporte_mensual` (
  `codReporte` int(11) NOT NULL,
  `año` int(11) NOT NULL,
  `codMes` int(11) NOT NULL,
  `codEmpleado` int(11) NOT NULL,
  `comentario` varchar(100) DEFAULT NULL,
  `fechaHoraMarcacion` datetime DEFAULT NULL,
  `debeReportar` int(11) NOT NULL,
  `codEstado` int(11) NOT NULL,
  `observacion` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion`
--

CREATE TABLE `notificacion` (
  `codNotificacion` int(11) NOT NULL,
  `codTipoNotificacion` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `visto` tinyint(4) NOT NULL,
  `link` varchar(200) NOT NULL,
  `descripcionAbreviada` varchar(200) NOT NULL,
  `codEmpleado` int(11) NOT NULL,
  `fechaHoraCreacion` datetime NOT NULL,
  `fechaHoraVisto` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_notificacion`
--

CREATE TABLE `tipo_notificacion` (
  `codTipoNotificacion` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cite-estado_reporte_mensual`
--
ALTER TABLE `cite-estado_reporte_mensual`
  ADD PRIMARY KEY (`codEstado`);

--
-- Indices de la tabla `cite-reporte_mensual`
--
ALTER TABLE `cite-reporte_mensual`
  ADD PRIMARY KEY (`codReporte`);

--
-- Indices de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD PRIMARY KEY (`codNotificacion`);

--
-- Indices de la tabla `tipo_notificacion`
--
ALTER TABLE `tipo_notificacion`
  ADD PRIMARY KEY (`codTipoNotificacion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cite-estado_reporte_mensual`
--
ALTER TABLE `cite-estado_reporte_mensual`
  MODIFY `codEstado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cite-reporte_mensual`
--
ALTER TABLE `cite-reporte_mensual`
  MODIFY `codReporte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  MODIFY `codNotificacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_notificacion`
--
ALTER TABLE `tipo_notificacion`
  MODIFY `codTipoNotificacion` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
