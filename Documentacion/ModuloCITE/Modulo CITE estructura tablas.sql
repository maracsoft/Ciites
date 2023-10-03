-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-05-2022 a las 17:27:03
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
-- Estructura de tabla para la tabla `cite-archivo_servicio`
--

CREATE TABLE `cite-archivo_servicio` (
  `codArchivoServicio` int(11) NOT NULL,
  `codArchivo` int(11) NOT NULL,
  `codServicio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cite-clasificacion_rango_ventas`
--

CREATE TABLE `cite-clasificacion_rango_ventas` (
  `codClasificacion` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `minimo` float NOT NULL,
  `maximo` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cite-cliente`
--

CREATE TABLE `cite-cliente` (
  `codUnidadProductiva` int(11) NOT NULL,
  `ruc` varchar(20) DEFAULT NULL,
  `razonSocial` varchar(300) DEFAULT NULL,
  `dni` varchar(20) DEFAULT NULL,
  `nombrePersona` varchar(200) DEFAULT NULL,
  `codTipoPersoneria` int(11) NOT NULL,
  `fechaHoraCreacion` datetime NOT NULL,
  `direccion` varchar(500) DEFAULT NULL,
  `codDistrito` int(11) NOT NULL,
  `codClasificacion` int(11) NOT NULL,
  `nroServiciosHistorico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cite-modalidad_servicio`
--

CREATE TABLE `cite-modalidad_servicio` (
  `codModalidad` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cite-servicio`
--

CREATE TABLE `cite-servicio` (
  `codServicio` int(11) NOT NULL,
  `codUnidadProductiva` int(11) NOT NULL,
  `codTipoServicio` int(11) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `codMes` int(11) NOT NULL,
  `cantidadServicio` int(11) NOT NULL,
  `totalParticipantes` int(11) NOT NULL,
  `nroHorasEfectivas` float NOT NULL,
  `fechaInicio` varchar(50) NOT NULL,
  `fechaTermino` varchar(50) NOT NULL,
  `codTipoAcceso` int(11) NOT NULL,
  `codDistrito` int(11) NOT NULL,
  `codModalidad` int(11) NOT NULL,
  `fechaHoraCreacion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cite-tipo_acceso`
--

CREATE TABLE `cite-tipo_acceso` (
  `codTipoAcceso` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cite-tipo_personeria`
--

CREATE TABLE `cite-tipo_personeria` (
  `codTipoPersoneria` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `usaDni` tinyint(1) NOT NULL,
  `usaRuc` tinyint(1) NOT NULL,
  `letra` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cite-tipo_servicio`
--

CREATE TABLE `cite-tipo_servicio` (
  `codTipoServicio` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cite-usuario`
--

CREATE TABLE `cite-usuario` (
  `codUsuario` int(11) NOT NULL,
  `dni` varchar(10) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidoPaterno` varchar(100) NOT NULL,
  `apellidoMaterno` varchar(100) NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `fechaHoraCreacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cite-usuario_servicio`
--

CREATE TABLE `cite-usuario_servicio` (
  `codAsistenciaServicio` int(11) NOT NULL,
  `codUsuario` int(11) NOT NULL,
  `codServicio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cite-archivo_servicio`
--
ALTER TABLE `cite-archivo_servicio`
  ADD PRIMARY KEY (`codArchivoServicio`);

--
-- Indices de la tabla `cite-clasificacion_rango_ventas`
--
ALTER TABLE `cite-clasificacion_rango_ventas`
  ADD PRIMARY KEY (`codClasificacion`);

--
-- Indices de la tabla `cite-cliente`
--
ALTER TABLE `cite-cliente`
  ADD PRIMARY KEY (`codUnidadProductiva`);

--
-- Indices de la tabla `cite-modalidad_servicio`
--
ALTER TABLE `cite-modalidad_servicio`
  ADD PRIMARY KEY (`codModalidad`);

--
-- Indices de la tabla `cite-servicio`
--
ALTER TABLE `cite-servicio`
  ADD PRIMARY KEY (`codServicio`);

--
-- Indices de la tabla `cite-tipo_acceso`
--
ALTER TABLE `cite-tipo_acceso`
  ADD PRIMARY KEY (`codTipoAcceso`);

--
-- Indices de la tabla `cite-tipo_personeria`
--
ALTER TABLE `cite-tipo_personeria`
  ADD PRIMARY KEY (`codTipoPersoneria`);

--
-- Indices de la tabla `cite-tipo_servicio`
--
ALTER TABLE `cite-tipo_servicio`
  ADD PRIMARY KEY (`codTipoServicio`);

--
-- Indices de la tabla `cite-usuario`
--
ALTER TABLE `cite-usuario`
  ADD PRIMARY KEY (`codUsuario`);

--
-- Indices de la tabla `cite-usuario_servicio`
--
ALTER TABLE `cite-usuario_servicio`
  ADD PRIMARY KEY (`codAsistenciaServicio`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cite-archivo_servicio`
--
ALTER TABLE `cite-archivo_servicio`
  MODIFY `codArchivoServicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cite-clasificacion_rango_ventas`
--
ALTER TABLE `cite-clasificacion_rango_ventas`
  MODIFY `codClasificacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cite-cliente`
--
ALTER TABLE `cite-cliente`
  MODIFY `codUnidadProductiva` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cite-modalidad_servicio`
--
ALTER TABLE `cite-modalidad_servicio`
  MODIFY `codModalidad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cite-servicio`
--
ALTER TABLE `cite-servicio`
  MODIFY `codServicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cite-tipo_acceso`
--
ALTER TABLE `cite-tipo_acceso`
  MODIFY `codTipoAcceso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cite-tipo_personeria`
--
ALTER TABLE `cite-tipo_personeria`
  MODIFY `codTipoPersoneria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cite-tipo_servicio`
--
ALTER TABLE `cite-tipo_servicio`
  MODIFY `codTipoServicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cite-usuario`
--
ALTER TABLE `cite-usuario`
  MODIFY `codUsuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cite-usuario_servicio`
--
ALTER TABLE `cite-usuario_servicio`
  MODIFY `codAsistenciaServicio` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
