-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-06-2022 a las 06:52:25
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
-- Estructura de tabla para la tabla `cite-actividad`
--

CREATE TABLE `cite-actividad` (
  `codActividad` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `codTipoServicio` int(11) NOT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `indice` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cite-actividad`
--

INSERT INTO `cite-actividad` (`codActividad`, `nombre`, `codTipoServicio`, `descripcion`, `indice`) VALUES
(1, 'INVEST DESARR PROTOTIP', 1, 'Investigación para el desarrollo de prototipos de potenciales cadenas, priorizadas por el Gobierno Regional de Cajamarca, La Libertad Ancash o Lima', '1.2'),
(2, 'INVEST APLICADA DESARROLLO PROTOTIPOS', 1, 'Investigación aplicada para el desarrollo de prototipos de productos con valor agregado derivados de las líneas de negocio priorizadas y potenciales de unidades productivas', '1.3'),
(3, 'VALID MERCADO NUEVOS PRODUCTOS', 1, 'Validación en el mercado de nuevos productos elaborados por el CITE agropecuario CEDEPAS Norte.', '2.1'),
(4, 'ASIST TECNICA A UNID PRODUCT', 1, 'Asistencia técnica a unidades productivas para mejorar condiciones de producción e incrementar sus ingresos.', '2.3'),
(5, 'VISITAS ASISTEN TECNIC ESPECIAL', 1, 'Visitas de asistencia técnica especializada a las unidades productivas, para monitorear implementación de requisitos exigidos por certificadoras', '3.2'),
(6, 'ASESORÍA ESPECIALIZADA A UNID PRODUC', 1, 'Asesoría especializada a las unidades productivas para la implementación de herramientas de gestión y prácticas de funcionamiento desde un enfoque empresarial', '4.2'),
(7, 'ASESORIA ESPECIALIZADA EN ARTICULACION COMERCIAL', 1, 'Asesoría especializada en articulación comercial de las unidades productivas', '5.1'),
(8, 'CAPACITACIONES REALIZADAS A INTEGRANTES', 2, 'Capacitaciones realizadas a integrantes de las unidades productivas para mejorar condiciones de producción e incrementar sus ingresos', '2.2'),
(9, 'CAPACITACIONES PARA RESPONDER A EXIGENCIAS MERCADO', 2, 'Capacitaciones para responder a exigencias de mercados.', '3.1'),
(10, 'CAPACITACION PARA MEJORA DE GESTION EMPRESARIAL', 2, 'Capacitación para mejora de la gestión empresarial de las unidades productivas', '4.1'),
(11, 'DISEÑ PROY INNVACION QUE INVOL UNID PROD', 3, 'Diseño de proyecto de innovación, que involucren a Unidades Productivas para ser presentados a fuentes de financiamiento públicos y privados', '1.1'),
(12, 'EVENT INFORMATICOS INNOVACION DESARROLLO', 4, 'Eventos informativos en torno a la innovación y desarrollo de nuevos productos', '6.1'),
(13, 'Difusión de resultados', 4, 'Difusión de resultados', '6.2'),
(14, 'INTERC EXPERIENC PERMIT MOTIVAR ORG Y ESPEC', 4, 'Intercambios de experiencias que permita motivar a las organizaciones y especialistas en potenciales productos y servicios a implementar en su territorio.', '6.3'),
(15, 'PARTICIPACIÓN EN EVENTOS INFORMACION Y FORM', 5, 'Participación en eventos de información y formación por parte del equipo de CITE agropecuario.', '6.4'),
(16, 'ACCIONES DE ESTAB DE ALIANZAS Y ACCIONES', 5, 'Acciones de establecimiento de alianzas y acciones de articulación con unidades productivas, universidades, instituciones públicas o privadas, actores de ecosistemas de innovación para la implementación de servicios del CITE agropecuario.', '6.5');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cite-actividad`
--
ALTER TABLE `cite-actividad`
  ADD PRIMARY KEY (`codActividad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cite-actividad`
--
ALTER TABLE `cite-actividad`
  MODIFY `codActividad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
