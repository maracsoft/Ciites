-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-02-2023 a las 21:37:22
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
-- Estructura de tabla para la tabla `contacto_financiera`
--

CREATE TABLE `contacto_financiera` (
  `codContacto` int(11) NOT NULL,
  `nombres` varchar(200) NOT NULL,
  `apellidos` varchar(200) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `correo` varchar(200) NOT NULL,
  `documentoIdentidad` varchar(200) NOT NULL,
  `codNacionalidad` int(11) NOT NULL,
  `codEntidadFinanciera` int(11) NOT NULL,
  `fechaDeBaja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inv-activo_inventario`
--

CREATE TABLE `inv-activo_inventario` (
  `codActivo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `caracteristicas` varchar(500) NOT NULL,
  `placa` varchar(20) NOT NULL,
  `codCategoriaActivo` int(11) NOT NULL,
  `codProyecto` int(11) NOT NULL,
  `codEstado` int(11) NOT NULL,
  `codEmpleadoResponsable` int(11) NOT NULL,
  `codSede` int(11) NOT NULL,
  `codRazonBaja` int(11) DEFAULT NULL,
  `codigoAparente` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `inv-activo_inventario`
--

INSERT INTO `inv-activo_inventario` (`codActivo`, `nombre`, `caracteristicas`, `placa`, `codCategoriaActivo`, `codProyecto`, `codEstado`, `codEmpleadoResponsable`, `codSede`, `codRazonBaja`, `codigoAparente`) VALUES
(1, 'Camara fotografía', 'marca cannon 52121', '-', 4, 5, 1, 1, 1, NULL, 'EA4-723472zs'),
(2, 'Moto lineal', 'Marca fenix', '252-ASDA', 3, 5, 1, 15, 1, NULL, 'EA936993A-5221'),
(3, 'Proyector Cannon', 'Marca cannon 50lumenes', '-', 2, 2, 1, 13, 4, NULL, 'CAN2511'),
(4, 'Interfaz de audio', 'Interfaz de audio marca behringer 202 UMC', '-', 4, 3, 99, 6, 5, NULL, 'INT25121'),
(5, 'Camara fotográfica', 'Marca cannon, costo 6000 dolares', '-', 4, 14, 1, 1, 1, NULL, 'EA-9793571-2'),
(6, 'Parlante Sonyx', '5 pulgadas 200', '-', 1, 3, 99, 1, 1, NULL, 'PS15-112'),
(7, 'Camara web', 'adsdsa', '251251 2', 1, 3, 1, 1, 1, NULL, 'EA-979A523'),
(8, 'Parante de microfono', 'Marca phoenix', '-', 1, 3, 1, 1, 1, NULL, 'PAR52-12ax'),
(9, 'Celular XIAOMI E-15', 'Marca xiaomi comprado en saga falabella', '-', 1, 3, 1, 1, 1, NULL, 'ESAJ25A-A5A'),
(10, 'Computadora I5', 'Computadora I5 8gb de RAM comprada en saga fallabella', '-', 4, 3, 1, 1, 1, NULL, 'PCI5A22021'),
(11, 'Computadora mac', '8gb ram', '-', 4, 2, 1, 99999, 2, NULL, 'MAC27171JFJ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inv-categoria_activo_inventario`
--

CREATE TABLE `inv-categoria_activo_inventario` (
  `codCategoriaActivo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `inv-categoria_activo_inventario`
--

INSERT INTO `inv-categoria_activo_inventario` (`codCategoriaActivo`, `nombre`) VALUES
(1, 'Carro'),
(2, 'Camioneta'),
(3, 'Motocicleta'),
(4, 'Equipo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inv-detalle_revision`
--

CREATE TABLE `inv-detalle_revision` (
  `codDetalleRevision` int(11) NOT NULL,
  `codActivo` int(11) NOT NULL,
  `codRevision` int(11) NOT NULL,
  `codEstado` int(11) NOT NULL,
  `fechaHoraUltimoCambio` datetime DEFAULT NULL,
  `codEmpleadoQueReviso` int(11) DEFAULT NULL,
  `codRazonBaja` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `inv-detalle_revision`
--

INSERT INTO `inv-detalle_revision` (`codDetalleRevision`, `codActivo`, `codRevision`, `codEstado`, `fechaHoraUltimoCambio`, `codEmpleadoQueReviso`, `codRazonBaja`) VALUES
(35, 2, 2, 1, '2022-01-31 13:15:09', NULL, NULL),
(36, 1, 2, 0, '2022-01-26 02:34:16', NULL, NULL),
(37, 3, 2, 1, '2022-01-31 13:15:09', NULL, NULL),
(38, 5, 2, 0, '2022-01-26 02:17:34', NULL, NULL),
(39, 7, 2, 0, '2022-01-26 02:54:46', NULL, NULL),
(40, 8, 2, 0, '2022-01-26 02:17:34', NULL, NULL),
(41, 9, 2, 0, '2022-01-26 02:17:34', NULL, NULL),
(42, 10, 2, 1, '2022-01-26 09:34:06', NULL, NULL),
(43, 11, 2, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inv-empleado_revisador`
--

CREATE TABLE `inv-empleado_revisador` (
  `codEmpleadoRevisador` int(11) NOT NULL,
  `codRevision` int(11) NOT NULL,
  `codEmpleado` int(11) NOT NULL,
  `codSede` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `inv-empleado_revisador`
--

INSERT INTO `inv-empleado_revisador` (`codEmpleadoRevisador`, `codRevision`, `codEmpleado`, `codSede`) VALUES
(6, 1, 50, 6),
(8, 1, 7, 5),
(10, 1, 43, 1),
(12, 1, 45, 1),
(13, 1, 8, 4),
(14, 1, 6, 4),
(15, 2, 53, 1),
(16, 2, 54, 1),
(17, 2, 43, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inv-estado_activo_inventario`
--

CREATE TABLE `inv-estado_activo_inventario` (
  `codEstado` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `inv-estado_activo_inventario`
--

INSERT INTO `inv-estado_activo_inventario` (`codEstado`, `nombre`) VALUES
(1, 'Habido'),
(2, 'De Baja'),
(99, 'No Revisado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inv-razon_baja_activo`
--

CREATE TABLE `inv-razon_baja_activo` (
  `codRazonBaja` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `inv-razon_baja_activo`
--

INSERT INTO `inv-razon_baja_activo` (`codRazonBaja`, `nombre`) VALUES
(1, 'Deterioro'),
(2, 'Pérdida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inv-revision_inventario`
--

CREATE TABLE `inv-revision_inventario` (
  `codRevision` int(11) NOT NULL,
  `fechaHoraInicio` datetime NOT NULL,
  `fechaHoraCierre` datetime DEFAULT NULL,
  `descripcion` varchar(500) NOT NULL,
  `codEmpleadoResponsable` int(11) NOT NULL,
  `año` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `inv-revision_inventario`
--

INSERT INTO `inv-revision_inventario` (`codRevision`, `fechaHoraInicio`, `fechaHoraCierre`, `descripcion`, `codEmpleadoResponsable`, `año`) VALUES
(1, '2021-12-18 18:49:52', '2021-12-23 16:28:12', 'Primera revisión correspondiente al año 2021', 99999, 2021),
(2, '2022-01-23 18:19:19', NULL, 'Segunda revisión, correspondiente al 2022', 6, 2022);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(3, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(4, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(5, '2016_06_01_000004_create_oauth_clients_table', 1),
(6, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(7, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0280ea1b5d5ff47daa94210293e89399c3b160c5889826711dbe83f47974fa6aa95a3416e2f498dc', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 03:38:33', '2022-01-26 03:38:33', '2023-01-25 22:38:33'),
('0600c07e53af10e0053306a48f89866cf2a96b39f64a7a98a7d9f3afbd50b8e20572c408ddabed63', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-12 04:17:22', '2022-01-12 04:17:22', '2023-01-11 23:17:22'),
('061df950b586dc37227ccbf89791f7a6017f930a98b3afb06b881677c9c772d8a896def091bd3e68', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 14:18:28', '2022-01-26 14:18:28', '2023-01-26 09:18:28'),
('09cc9ba52164704596e5bd10f39684a1680cf5f3699bd60c10ea689c5b97875427c6a8719888b34b', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-16 17:35:13', '2021-10-16 17:35:13', '2022-10-16 12:35:13'),
('0b1c22adb0c5b2c679c96c3f8f9aef641633a82f773a96a4b15f98b4e8f0688f36016936316f27d8', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 06:41:29', '2022-01-26 06:41:29', '2023-01-26 01:41:29'),
('0b5ae2e9561a1ee310b9934e29a0d5fd7d1ff15b109ef28391adca11264f96c065ec3cf89ae03177', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 06:15:06', '2022-01-26 06:15:06', '2023-01-26 01:15:06'),
('0bca5636952eab035faa2925b8155f4b04257fa5faa4d3adc1232de73094df19d89a473711730848', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-16 00:22:20', '2021-10-16 00:22:20', '2022-10-15 19:22:20'),
('0e9f3407a1ac14169f418b619dc3c43bd1e039762e24e46e494f7547d6b8363a87f39b7d928658ad', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 00:56:09', '2022-01-25 00:56:09', '2023-01-24 19:56:09'),
('0ee3932ea50157652903908efca9d6b1bb1f7999dcf727dc8c950d8a3cf057619bec59fa5c1cfb2c', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 06:26:55', '2022-01-26 06:26:55', '2023-01-26 01:26:55'),
('0f2d670191072964a604abdeadc055c0e04d4611a7e81712cd35986a4ad4e002fada2c04ca02675b', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 07:49:24', '2022-01-26 07:49:24', '2023-01-26 02:49:24'),
('0f77b35ef874b54ed196dbc15e5d3c2b09143b517425e7b08cd53faea39955433029f8056ef1c353', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-15 18:19:38', '2021-10-15 18:19:38', '2022-10-15 13:19:38'),
('0fe6efe425cd19c26838c49d41d6bcfad9201003df7323392f6b512ee879b27dbbac44a1cf043e08', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 00:32:04', '2022-01-25 00:32:04', '2023-01-24 19:32:04'),
('11ee97f9ed50b9443418e0217ed556c37ceda2a434103c666c8ef230aebc4180fd1bc24fd00d5783', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 03:07:01', '2022-01-25 03:07:01', '2023-01-24 22:07:01'),
('1233f8d43fb746d1d102fefd1e247cbb5fc26921ef5c10a00f3a74675e3a913ccbc5966fe570a814', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-24 22:36:12', '2022-01-24 22:36:12', '2023-01-24 17:36:12'),
('154520012a9b74739a9ca2e406d052f7478489fcf4eac0b4d0ad5ce081559a7068bf3db0f3361e10', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-20 00:21:09', '2021-10-20 00:21:09', '2022-10-19 19:21:09'),
('15dd9e77e6c190b421de056aab3843adec4d75646241f890efea0320ae9e21a78862a0f1280873df', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-15 18:19:21', '2021-10-15 18:19:21', '2022-10-15 13:19:21'),
('1a519ff9248ad295f39bb40ad3d618dccd43384627bb285f2f34976db50d95cc1e8287140e42f89e', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-20 00:17:31', '2021-10-20 00:17:31', '2022-10-19 19:17:31'),
('1a7b9723599ccb51f2b1480698b17d4f14c0d00a0981ec444110062b68a9aa05012f38ab41cb27fc', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-24 22:44:52', '2022-01-24 22:44:52', '2023-01-24 17:44:52'),
('1b1d51c27cea0a647864d26075e5dcd2c6dc8a53338e1c066f1aa81c889c2c2b91d9613a0ff7e2b2', 2, 1, 'Personal Access Token', '[]', 0, '2022-01-26 08:01:52', '2022-01-26 08:01:52', '2023-01-26 03:01:52'),
('1fcdc91666fe7a5823e669e80ba9cbfef5d2c5e43d608ed5f5c505a584cabe12c87c8ff035304fb4', 2, 1, 'Personal Access Token', '[]', 0, '2022-01-26 14:07:20', '2022-01-26 14:07:20', '2023-01-26 09:07:20'),
('218c6a06cdbae52435f1f72b7519519fb5d2d3189516979947095a4d42d77a41b8599f0d7c5cfc85', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-15 18:19:26', '2021-10-15 18:19:26', '2022-10-15 13:19:26'),
('2246ae3524fd4444042686d86d2dd35b1d291ba55d281e5e44b95e591d16c06a4a381048172f1d6a', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-15 18:05:07', '2021-10-15 18:05:07', '2022-10-15 13:05:07'),
('228cc969fd761ba216d8354b78e6bc9d07937d7a2f166acf20677385532e941c7820ea47c6ed4923', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-15 18:05:04', '2021-10-15 18:05:04', '2022-10-15 13:05:04'),
('23e15fccd9e4c5b1ba95430a4452743f36457220a19416e96797da86a34199ee8ebbe32bca21a223', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-20 00:18:27', '2021-10-20 00:18:27', '2022-10-19 19:18:27'),
('248ed184028d77d6d9d6369470726e2a8848b0b772bbc125227129c4e01e38e3d3b8c076e77da365', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 07:29:12', '2022-01-26 07:29:12', '2023-01-26 02:29:12'),
('249b9a5f63156a37c2337d9711b69f3835a245b78256175cf01f1faaa2c7fd7b2a23d949ca0b049a', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-16 00:24:25', '2021-10-16 00:24:25', '2022-10-15 19:24:25'),
('27c1eae72278024b4ea64f25597606725660071e7fada9c91732752da5cd5542270281c16b0cb4ec', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-24 22:38:12', '2022-01-24 22:38:12', '2023-01-24 17:38:12'),
('2944fffa5905b2255dbb3acf440e42ceeeab5389328aafb5b1766578ce6f4ff7ed8afd7fe8b0c740', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 06:36:59', '2022-01-26 06:36:59', '2023-01-26 01:36:59'),
('29d81a720ae14f37cc0990a73365605fe2d250d3e51d35085ee4d30a409375e7af6f84f5e5140622', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 18:43:25', '2022-01-25 18:43:25', '2023-01-25 13:43:25'),
('2eed38241edc2a2912f3b2fe513f0580361ce015cef6f913225ea3e7c921f0627f20de0b980d9fda', 2, 1, 'Personal Access Token', '[]', 0, '2022-02-04 18:45:13', '2022-02-04 18:45:13', '2023-02-04 13:45:13'),
('2f5bdfc5bae92bfdb436e25f644c8a6bc5b687e6d0abf31ae14569421e5a090caab6683766215fa8', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-15 18:05:12', '2021-10-15 18:05:12', '2022-10-15 13:05:12'),
('2f62ecb2d3c5a8726903543c6fa6f9fe3a54c698e3c68b7e641868cc4efd999e9ca990e6f21fb7c5', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 03:34:35', '2022-01-25 03:34:35', '2023-01-24 22:34:35'),
('308e48459305c7663a6911653da89774f85d129ddb1adab858f72323ea7a2da82c8cb69c333a1a4b', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 07:33:26', '2022-01-26 07:33:26', '2023-01-26 02:33:26'),
('30e9cab93520c9ce1dbc82e8fad9e3153c4b711850f3d0096074d89739a19206445124669c6df9fe', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-15 18:05:11', '2021-10-15 18:05:11', '2022-10-15 13:05:11'),
('3151d91f823c3d43942a1514d90cc8eae1a0124b155ba73b55c12b194a5ebea67b1f111cf228c359', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-15 18:05:10', '2021-10-15 18:05:10', '2022-10-15 13:05:10'),
('32f3d4cd0b19e37483b795be3ead299df72a0b12640445179fc74dea2e8ef9d72b60c1d56abf9062', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-24 22:36:13', '2022-01-24 22:36:13', '2023-01-24 17:36:13'),
('33c9218f72b7c21442a7316c94ca7af6a0a036d3010015fd215284344ecc73a61b6dac4ec06fbc53', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-16 00:17:01', '2021-10-16 00:17:01', '2022-10-15 19:17:01'),
('344e08657935756492f20c54f2aa7ebf082d4e0e99c775a7617890f1c5f4cbadbf87b931b24c3c27', 2, 1, 'Personal Access Token', '[]', 0, '2022-02-04 19:39:15', '2022-02-04 19:39:15', '2023-02-04 14:39:15'),
('36593a0a38049ef3c9445f19512a46013cf45728b8b8488e646dd3b498855e7e4606601690888e37', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-19 23:47:21', '2021-10-19 23:47:21', '2022-10-19 18:47:21'),
('38d962b445aa200a2217bbe6e5a4f4b19362b97b0f712f68fba355606a6e4615e06cffa6f633749f', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 06:37:57', '2022-01-26 06:37:57', '2023-01-26 01:37:57'),
('3968a598717bb0e444b6b0e93970c6956d4f94fccdf3199cfe4292cc436b66fe7343a8d6f55c3fb3', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-19 23:36:47', '2021-10-19 23:36:47', '2022-10-19 18:36:47'),
('3aadf65aecde5c6d4413806a3879496583b9041cd6290be639bd200aa54e8bc9fe5eff426d3caf6b', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 07:25:52', '2022-01-26 07:25:52', '2023-01-26 02:25:52'),
('41b0586d0e1fbeccf8bae7c26df625e1461643c215722e74824558b878d50a45e3b52a02af042169', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 07:49:42', '2022-01-26 07:49:42', '2023-01-26 02:49:42'),
('423dc31f07ef1fa020f9ef700e4113a8f5c95af02a5a1f8354e437021a04a6d1244f0549c83c61fb', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 03:22:54', '2022-01-26 03:22:54', '2023-01-25 22:22:54'),
('4246f5d51ff0273103a684d71da56bee25197a3749f5399d5aea4474bc9bd543e1bd413f53c1bc99', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 05:55:58', '2022-01-26 05:55:58', '2023-01-26 00:55:58'),
('46349fa8b309978c5641512b543103b06f6d4dd3da7486200425f7f618e41c50cb66a31ea597ce08', 2, 1, 'Personal Access Token', '[]', 0, '2022-01-26 07:33:38', '2022-01-26 07:33:38', '2023-01-26 02:33:38'),
('488aafc234289ca3b11514cba23fc9d054d2efa1c19f4669f56e3c5984d28b20d4e562cf6e48017e', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 06:41:30', '2022-01-26 06:41:30', '2023-01-26 01:41:30'),
('4939b86e2cb14a8f05b51fff6c6c7d19ddc4b66451c11b2a505120de9e6958575f64aa2a9537a567', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-15 18:05:12', '2021-10-15 18:05:12', '2022-10-15 13:05:12'),
('4a8922486aedf2ded0373bd68e61de0c1db309708286fe42e6da13462f58985295b186358361a10f', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 07:05:13', '2022-01-26 07:05:13', '2023-01-26 02:05:13'),
('4ae45436a88ac3ca7405c4f33338ee0d52e7a872814268b5cc9abba6fc3f95f0c5d0956115d6a214', 2, 1, 'Personal Access Token', '[]', 0, '2022-02-04 18:45:14', '2022-02-04 18:45:14', '2023-02-04 13:45:14'),
('4b4ffe7a21ffd5020bfc5cc36248c386d2eb94e9f371028ecb025dde158df211fdebe1cd1bc41a40', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-15 18:19:25', '2021-10-15 18:19:25', '2022-10-15 13:19:25'),
('4d3042bf39588e8243a1e8f56dbd3676eae1396e5d9d9689c2d27f4a2e82599e2596a07b30a48d38', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 04:54:19', '2022-01-26 04:54:19', '2023-01-25 23:54:19'),
('504aa9713a603b5c74fcb941f391d84b3c44b01c93f6f23e7d7acb98af5c05d95cc8123c0c1ae497', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-15 18:05:09', '2021-10-15 18:05:09', '2022-10-15 13:05:09'),
('505ff9598d9123562236a82dbaf249d4edd26905f8574a150a29e18945d8a89492dcb1ac8a185521', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 17:09:04', '2022-01-25 17:09:04', '2023-01-25 12:09:04'),
('509b7b7a295186dd5c3c11c0260851ec0733548c5b396e5508593e823ed98d57bc6d35ba499df9b6', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 18:31:26', '2022-01-25 18:31:26', '2023-01-25 13:31:26'),
('51e083d5f1c6dd373e71a3043739fa6b7a8ec1f870a4bb300a1c4e26f3b44755688ddb83ffea18a3', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-16 17:34:45', '2021-10-16 17:34:45', '2022-10-16 12:34:45'),
('51f24d96fc425d4cc6013cc2b0a9882c0efc9da00af65875d6a3426b96382b20f60166a7521873dc', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 18:25:14', '2022-01-25 18:25:14', '2023-01-25 13:25:14'),
('5282207e8d302129f1362ef6fe21b70cff4981b1b5145dec840c3057d450882343a675fab1fbaa5b', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-16 01:47:35', '2021-10-16 01:47:35', '2022-10-15 20:47:35'),
('52fc84acf7d4c01e99f5d01933abe2665f34b4a69c1fd9e91762a7305ee04fb9fe86e8696d26de96', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 06:04:41', '2022-01-26 06:04:41', '2023-01-26 01:04:41'),
('530ddb02303d519e75a9c49e8ad13e787fd84893b8709ee1e23511b3d2e3129a1e6811f0a0ba4b8c', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 17:09:03', '2022-01-25 17:09:03', '2023-01-25 12:09:03'),
('532a7cff1757be5e9d688ea9dec4968e5dac8a7b6643dc8b82b692f922fa31c8663bd4c40dde6506', 9, 1, 'Personal Access Token', '[]', 0, '2021-10-16 04:53:19', '2021-10-16 04:53:19', '2022-10-15 23:53:19'),
('55d5167aa83aa6cb550cf437dd2be243a8f15583453c1d1042a71a3a7e67983c6d92a23d460d3a90', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 18:28:40', '2022-01-25 18:28:40', '2023-01-25 13:28:40'),
('57923c9b27c41f0ea2d76f3e4df318a828d9abc5dc0398b11cddefff2a62531b4bdbd3ec5cdf0142', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-19 23:14:19', '2021-10-19 23:14:19', '2022-10-19 18:14:19'),
('59f9ecd97696422656a934ff9c6474753af2e5833e90ba92d990420b20966319d72d0a8ef0071da7', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 00:29:28', '2022-01-25 00:29:28', '2023-01-24 19:29:28'),
('614ddce68d65e6144838d0534e92e09e3db7af28fff7d28bfadb4902e4145a92ea7bdc0c1485634a', 9, 1, 'Personal Access Token', '[]', 0, '2021-10-16 04:07:41', '2021-10-16 04:07:41', '2022-10-15 23:07:41'),
('6193e1651629827aeb7a2337238e7e516612b5ae6c1a493063e3b0911783714b153d761633626774', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-16 01:58:21', '2021-10-16 01:58:21', '2022-10-15 20:58:21'),
('627465b897e85f508028fc2cdbe665d964e556d8a7e5e3f0bdccb1f37220372e4a4b233d71f2ae88', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-15 19:40:26', '2021-10-15 19:40:26', '2022-10-15 14:40:26'),
('64575163d9ae14bb9da4f5de37adb0d4a4d7ac34fce74dfa06a0a4465b98372018d2b2fafb7df3ca', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-16 05:57:15', '2021-10-16 05:57:15', '2022-10-16 00:57:15'),
('667e39dab82a462e75dedee9cb8056dab6a7e0d33b47a51cf1a51ab9ea9c9dda7fd41d9660a23f48', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-31 17:49:44', '2022-01-31 17:49:44', '2023-01-31 12:49:44'),
('68c15ec39c2e3fa6ac46f962b5e8f1e43b001e2a17af30afa25a812e3882102f1e1e6e1bb4204641', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-31 17:22:38', '2022-01-31 17:22:38', '2023-01-31 12:22:38'),
('6ab44fb24ef7800aaa58bef311f580b52b959a3001d918afb6a07886b1200465b0c7d89be77a8e50', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-24 22:48:41', '2022-01-24 22:48:41', '2023-01-24 17:48:41'),
('70a10ef34a716d74d098bdd4c3035a9f67037e239c596e5f5d522f97207174e23ef5a07bab942ff8', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 04:25:17', '2022-01-25 04:25:17', '2023-01-24 23:25:17'),
('71417cf705a584fed6dc3e25d8f2ac76e1c956635628184af32b1d2867ef3a838421408f874bd12d', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 03:38:19', '2022-01-25 03:38:19', '2023-01-24 22:38:19'),
('7451e8adaebe4ea8f215f3f9c195b6a8fd828547104cccff4bd3d503b3c3ce13ab36cf905006ccab', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 06:10:22', '2022-01-26 06:10:22', '2023-01-26 01:10:22'),
('755ddcd683d19f8a41f287be8e841acc20a66b0ad10360365d901b5b96b8e3d2b4c8b7a78db47419', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 18:14:50', '2022-01-25 18:14:50', '2023-01-25 13:14:50'),
('76e0c5db6766fbd06d817cb722b2a98b85363320f207eae2c3b52a0c0da23d4b9c2d08fdbb45037b', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 18:25:08', '2022-01-25 18:25:08', '2023-01-25 13:25:08'),
('7af2d3e3e2c186421dc760f06dd0c259557b2f111cc420d72c4d3fac475f93969b595749bd41bd9a', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-20 00:28:21', '2021-10-20 00:28:21', '2022-10-19 19:28:21'),
('7cd395ad0e04f2c9c3b58c4b6d5ebfa922507c5b82644d13a3a8d04278b498e47201f5977cdbb2c3', 2, 1, 'Personal Access Token', '[]', 0, '2022-01-26 07:28:07', '2022-01-26 07:28:07', '2023-01-26 02:28:07'),
('7dc9818a58dd4a233ed1ebb7733df7cb80e16e28a6b81a4dfa1034cf4ed1a9143cc79af2b51bfcf2', 2, 1, 'Personal Access Token', '[]', 0, '2022-02-03 23:15:33', '2022-02-03 23:15:33', '2023-02-03 18:15:33'),
('7fedc82e54c7dbd32292ad6037b0096103adf34c7ab26b7ac91717e870cd8ea7c787935663a8d814', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 14:28:04', '2022-01-26 14:28:04', '2023-01-26 09:28:04'),
('81b4ad57a64db144526104ea157f25e5ae609cda2680810de756119250dcaa978a1309ff54f36862', 0, 1, 'Personal Access Token', '[]', 0, '2022-02-04 18:45:02', '2022-02-04 18:45:02', '2023-02-04 13:45:02'),
('831d3cf7d6e83dde5ea484e22bb82d7dbe82eeb8e8a5b62a8a10ecc8ee3030a1311f06f44d97350a', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-24 21:34:40', '2022-01-24 21:34:40', '2023-01-24 16:34:40'),
('844879c3417516dfe6ec38ae6d7c4403f7fed69532435549dc3c230973c5fd2b58362f1ff4f65474', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 08:01:27', '2022-01-26 08:01:27', '2023-01-26 03:01:27'),
('8482099c9cd4b6261d1e2bfa706113c855c9fd762287fe4b795a81792625b4859c51a6cfbcd9d033', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 18:15:02', '2022-01-25 18:15:02', '2023-01-25 13:15:02'),
('85690a8250d6179811fa24df5d88ad92bd58e51df55a584afb9ca2ba3caf1f360d66089791e772c2', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 00:08:20', '2022-01-25 00:08:20', '2023-01-24 19:08:20'),
('85936217875a9ad98f62866d102491053a61560f7bcd5f6cd3a07716cc8cec45214278a1b70f9b4c', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-16 00:25:29', '2021-10-16 00:25:29', '2022-10-15 19:25:29'),
('862f55bc74debbd4dbba1c2b78f8fcdc0bd90c649c06555f9e92009e99e3130373c702eeb3979d6a', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-16 04:07:12', '2021-10-16 04:07:12', '2022-10-15 23:07:12'),
('8712b7cdc9d830b1c2a524cea8e6858da0db7ac7f86210d8c5e6d567a0ac6c40eb55fa6cd1375ff0', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-19 23:33:24', '2021-10-19 23:33:24', '2022-10-19 18:33:24'),
('8751fac0d7cce62bbf6d6a569a5855136881cb9c7b11b8e30746aae11f0f82724770664320e9a781', 2, 1, 'Personal Access Token', '[]', 0, '2022-01-26 14:28:23', '2022-01-26 14:28:23', '2023-01-26 09:28:23'),
('877b7d4a80d719e0960ed885003c918bcafa335dff79ea8b21a1afefd20d7628d614c793c828f25c', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 06:26:56', '2022-01-26 06:26:56', '2023-01-26 01:26:56'),
('87980c8ef7fab952f0920ee8554bc69986ad0c18c95255fac93a3158f26363a757ca3b6e48984914', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-16 04:42:00', '2021-10-16 04:42:00', '2022-10-15 23:42:00'),
('89a6d9d054c9d1fd4192d66bff8d384c589aee191390139e61478981a2559715f37217e6fb6c24c4', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-16 03:58:09', '2021-10-16 03:58:09', '2022-10-15 22:58:09'),
('8ca5759bf5278d15ec95c7e2c49b52f8cbaa3c2a6ca4294e19a5ef8d4b7fc5147571a4d75cb6a811', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 04:22:55', '2022-01-26 04:22:55', '2023-01-25 23:22:55'),
('8cda992925d3bcdfc8760eb976651ff691e698dd1d30ef2d304043c10704348b6741f47f4898bbd6', 2, 1, 'Personal Access Token', '[]', 0, '2022-01-26 07:27:08', '2022-01-26 07:27:08', '2023-01-26 02:27:08'),
('8d24572ab44ee52c99e6bc87e2047235fb6759c075ef9b26a68f240fb6b4bdbd5db4dce1a432da32', 2, 1, 'Personal Access Token', '[]', 0, '2022-02-04 19:39:15', '2022-02-04 19:39:15', '2023-02-04 14:39:15'),
('8e9f22b8a4a919a2e09ba35007970a923b0ff3299a62d8a36ab61a60480d38283f47a5d71251f645', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-20 00:29:55', '2021-10-20 00:29:55', '2022-10-19 19:29:55'),
('8eeabeda74896fa5744917af9f647e5fa77ec039e751b38a18eb3e1675602d698ca33a647f99e736', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-31 17:37:06', '2022-01-31 17:37:06', '2023-01-31 12:37:06'),
('8f25601a2018963676910973e2bbdc8a202858dbb514d2f2faca613ee14aa2d481af5ea84966acc4', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 05:35:07', '2022-01-26 05:35:07', '2023-01-26 00:35:07'),
('9132dcbbfe703d317627a406b237420a7c595f7920fc27c23b8ee3376d325fb2c3db22accc73003c', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-24 21:34:41', '2022-01-24 21:34:41', '2023-01-24 16:34:41'),
('91d33560713829bfa645d966a4eaf64c35acfd924e431a7e2a9397b39a6bf15b223b770b632aee95', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-20 00:21:30', '2021-10-20 00:21:30', '2022-10-19 19:21:30'),
('91ff68109cc4877c261b1d425f8853a330ba897d7f532e34ba1cc63cbb2bb97d4dc72e8c0fdae7d9', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 05:34:07', '2022-01-25 05:34:07', '2023-01-25 00:34:07'),
('92385f854462b978da81ebd0a566c8d1a099e5076d356890b36990fa7dd34153a041bf8f0f0c752b', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-12 00:51:08', '2022-01-12 00:51:08', '2023-01-11 19:51:08'),
('927c19364e834a59a57f8d73c86c2f8f73166d97b2cfc0b92f5843fadd419091c4da414338eb4e49', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-19 23:58:55', '2021-10-19 23:58:55', '2022-10-19 18:58:55'),
('9724122b0b3b9610520849dd9fd5a78dac749c1e303598a6665bb4e181b7fb0fafa15de4575bd3e4', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 06:24:52', '2022-01-25 06:24:52', '2023-01-25 01:24:52'),
('9cbb735debfaa6de0b3f9d4222b18a8115f66a09f1feb34d047e0b1639304b8cb0bec013581ad617', 2, 1, 'Personal Access Token', '[]', 0, '2022-01-26 14:19:45', '2022-01-26 14:19:45', '2023-01-26 09:19:45'),
('9d38770acc40af6f70df6edc5d3a386a13ad4bb833690f08b9bc31a802c7a9efa56e53704b9d1a45', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 18:16:32', '2022-01-25 18:16:32', '2023-01-25 13:16:32'),
('9d69085a15a29b664774196f0fbfce7d2e234497de1853654a6126419b881e3ac0bf5bbc8432d754', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-20 00:21:29', '2021-10-20 00:21:29', '2022-10-19 19:21:29'),
('9faab178e39d2d9cdb3ce6162d074f01e9a1bd41d14f83c0597d8be69a6dda456c4deb3b38bd5921', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-24 22:53:03', '2022-01-24 22:53:03', '2023-01-24 17:53:03'),
('9fe83614bf6ddac132c648172dc827addcd55ebaa479fa808300afcabfbbe31d15ccd1e14e54a809', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 18:25:10', '2022-01-25 18:25:10', '2023-01-25 13:25:10'),
('a0000848b56a8b64dc2309b973f2ee3c158ebcce973e6dc0bdca9afa7e8c69496f05d1c0f88705ce', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 06:52:53', '2022-01-26 06:52:53', '2023-01-26 01:52:53'),
('a0737ef6e74e5d8ce45568f8fb3f54f8e41665239374cf0855d2fd145a0954e7afb4c4b93ab87e5e', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 00:34:26', '2022-01-25 00:34:26', '2023-01-24 19:34:26'),
('a097cf5937f3763080a0ee0d2dde5d11d857b09d8685769ac47c49064ba79af9000a651cafd24c82', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-15 19:30:59', '2021-10-15 19:30:59', '2022-10-15 14:30:59'),
('a0bd3d6df341def0f89b5c0e13e6685efeccad29b21e7359541f935112c631cdcde4c30b60440c95', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-20 00:31:58', '2021-10-20 00:31:58', '2022-10-19 19:31:58'),
('a0bfe4b7de647ccc0e44628d6f8884dee1c1200ee91688702d7ebc38f2151ddd5a00ff5aeb71565b', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-19 23:59:36', '2021-10-19 23:59:36', '2022-10-19 18:59:36'),
('a0ff6d82cbe710546792c3c0b65ce1dadd8112d123ddfa2450c2690494f724207d64aabb67d229ff', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-20 00:15:19', '2021-10-20 00:15:19', '2022-10-19 19:15:19'),
('a53fcd6521130dea2cfad37665e3e87125fc7f3d36e28f1cf1f21a7adf2ed82da0a7a5fd33d9a862', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 04:41:19', '2022-01-25 04:41:19', '2023-01-24 23:41:19'),
('a75d1fd08bcef4be6bc5bc93bc079254be8bf57ea28366723587136a16ce037ae27aca95a426291d', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-24 22:57:15', '2022-01-24 22:57:15', '2023-01-24 17:57:15'),
('a9761fc566aa8fa73488da0a52c285553af76758c7aacdf44d43d7554ffce522d9d62a46ed9bec75', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-20 00:23:39', '2021-10-20 00:23:39', '2022-10-19 19:23:39'),
('a991bdb698054d046fbebaa2fbab01ae4df06da6b723e2b6f21a92e05f36f81b6c61b98c0cdfcc2e', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 02:19:54', '2022-01-26 02:19:54', '2023-01-25 21:19:54'),
('abfd5bc6945d6115b0dabe01372471d9386772aaa4fa63b6acc388e8577ace72f7af9cbd58a260d0', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 06:44:27', '2022-01-26 06:44:27', '2023-01-26 01:44:27'),
('ad5e1d12ae44c3f377de26f06538bc317416346b276f3f817ca9405142afdb72d788a754eabdf83f', 2, 1, 'Personal Access Token', '[]', 0, '2022-01-26 14:03:41', '2022-01-26 14:03:41', '2023-01-26 09:03:41'),
('ad68897b89f3aecf85faf381c8311980422fec5ace40522525924ebad8f3b245227ba69f5f0fdeb1', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-19 23:29:41', '2021-10-19 23:29:41', '2022-10-19 18:29:41'),
('b008e129d5f13f4a07844c4e7f6f77911ff7d814af52f0f98e63b6b2cc6d0b913f762805a20153df', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 00:49:44', '2022-01-25 00:49:44', '2023-01-24 19:49:44'),
('b1334326e25938c634e668f6da302636fa9af2f4c43da3a8784b029ac6c0d65056837cb06062b11f', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-15 18:24:46', '2021-10-15 18:24:46', '2022-10-15 13:24:46'),
('b23e54cc0880eb0c5c1cafea37cb2462661c19a4e9e1734fef08ad3c6291d9d9021f46857435cfe5', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-15 18:05:08', '2021-10-15 18:05:08', '2022-10-15 13:05:08'),
('b487b17fe1987134c5bc3423f7560b0e3dd3ba2cb196058bf731c2d400c6840e370efb0264b96c8a', 2, 1, 'Personal Access Token', '[]', 0, '2022-02-04 18:45:13', '2022-02-04 18:45:13', '2023-02-04 13:45:13'),
('b664d6ee37330e4f6d8c6aca75f49994eabacd5e32c248e3751d9b922a418728e106025e9bc54ddd', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-20 00:17:26', '2021-10-20 00:17:26', '2022-10-19 19:17:26'),
('bb208e4cbbc924ae39966cf9609112eb5025e21adb3c72e086afc34ea1315809c671368fca75ee57', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-20 00:17:16', '2021-10-20 00:17:16', '2022-10-19 19:17:16'),
('bc99805bb2070969e072cdbb7ef929ebd81dba7da01cac89acb7590aad8d34fae2b7e474824c3339', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-24 21:24:33', '2022-01-24 21:24:33', '2023-01-24 16:24:33'),
('bd4773fffd5b17d68f0897b35363a32e268f465386cab14ccb13c95761846d15474620b774c71c54', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 02:17:36', '2022-01-26 02:17:36', '2023-01-25 21:17:36'),
('bd7e5e1c29e2f4de3de72bd69927a32ac911695dc88f249f42385606854b2aa5bd7dc984a1b345a4', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 05:54:06', '2022-01-26 05:54:06', '2023-01-26 00:54:06'),
('bed6f4268a9487085a71396ec1984f744a791c26cc534a1918562ff250a90de89b8cae7af968b46e', 2, 1, 'Personal Access Token', '[]', 0, '2022-01-31 17:50:48', '2022-01-31 17:50:48', '2023-01-31 12:50:48'),
('bfe7907649ff01fd5acb9d84b8a92dbd63c9616d4ea76635c2cf1f651fc03f91cb3be86c3c98a418', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 06:35:53', '2022-01-26 06:35:53', '2023-01-26 01:35:53'),
('c2f8b9cc196d42d0739c256cdfa686880ab3cf3e783245cc821ced366acf2fc71238ad6e8ca39e0f', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 06:11:45', '2022-01-25 06:11:45', '2023-01-25 01:11:45'),
('c57b2440d18327b63db972968732c934c58f675ad3a829711ea117fb3e430e8995d9ffc92057ef75', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 17:43:42', '2022-01-25 17:43:42', '2023-01-25 12:43:42'),
('c5844d7684455b3dc49fef14202607408c2748f55f57027694aa8ccae0a26775c52023232c725833', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-15 18:18:57', '2021-10-15 18:18:57', '2022-10-15 13:18:57'),
('c80fe702a27c9aa965a2c6c088729e348a6d7d674d2b7af902a9a2eea5136fa102b110a90cdfc18f', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 06:09:18', '2022-01-25 06:09:18', '2023-01-25 01:09:18'),
('c84b5304c9a0d5c6a7e96a650a8fc6123529a40b893b85f035ba8d0df74f1519ad4cc694b96a8876', 2, 1, 'Personal Access Token', '[]', 0, '2022-02-03 23:14:59', '2022-02-03 23:14:59', '2023-02-03 18:14:59'),
('cd9a480e79ba4194563621c2f627dd3404f135c7b50005dde9aa0179e50bd5db944a5a121073b1dc', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 07:49:25', '2022-01-26 07:49:25', '2023-01-26 02:49:25'),
('ce44c4a6257c7f2327b1f2937c13cb903fc2c69b7e0139936f61ba066574a8f1361d2142f72a042c', 2, 1, 'Personal Access Token', '[]', 0, '2022-01-31 18:12:31', '2022-01-31 18:12:31', '2023-01-31 13:12:31'),
('cec4b401a369e6cad6f4a376c246feedcb617e87fe0da014c795e660e917191de105bb2003b3cc96', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 18:28:19', '2022-01-25 18:28:19', '2023-01-25 13:28:19'),
('cf29ed9b146c9427ffab5cc4f2f9437adb387dc62e9e104eb7a029d7b8b7f3e23345aa934ec87d37', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-24 21:24:32', '2022-01-24 21:24:32', '2023-01-24 16:24:32'),
('cf478b73f550011d5dfd4451de070cf0459a411743713d5dcdfe10cf201aab5900c10c64ba7f1492', 23, 1, 'Personal Access Token', '[]', 0, '2022-01-31 17:29:21', '2022-01-31 17:29:21', '2023-01-31 12:29:21'),
('d118a480adc3db6fbdaccddbfe2d8e9614e720ea873733577b4404db93810a34606cbdd308103c51', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 05:29:34', '2022-01-26 05:29:34', '2023-01-26 00:29:34'),
('d259bf520d1b16494658bd33f55b6cab8a4e007bf1dbd420794d20a86c0961a9bcae9b1ff1ea3325', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 08:01:28', '2022-01-26 08:01:28', '2023-01-26 03:01:28'),
('d7b3f05d345fa90dd68c692e9a237ee1cfca2793d242bfab3ff9120541b67ff50b6deb88a1515e21', 2, 1, 'Personal Access Token', '[]', 0, '2022-01-26 07:30:22', '2022-01-26 07:30:22', '2023-01-26 02:30:22'),
('d8267954d600da2da88deab634686c7b1eb355bf2cd7d41e2bb9aa4a650c04ab74577d55a0986f2c', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-16 00:23:47', '2021-10-16 00:23:47', '2022-10-15 19:23:47'),
('d9b989887a6d215c79ac7045b3553da00b828acf41d7ef4859e723cfcd2bcba0b9474958ac3bd91e', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-19 23:46:40', '2021-10-19 23:46:40', '2022-10-19 18:46:40'),
('db6ba69691b350baf92861ea8ff372e4d23532d4250b7e4595032bbed9520598a87cc7c3a3a48dc6', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 05:54:05', '2022-01-26 05:54:05', '2023-01-26 00:54:05'),
('df7a82d3ec90c17eddb116e5154d07fe0aae7c24230902775b0974aa4dc5a6e7840209588916205f', 2, 1, 'Personal Access Token', '[]', 0, '2022-01-26 07:29:26', '2022-01-26 07:29:26', '2023-01-26 02:29:26'),
('e331bd85455422fe50f528e8c2e1830b0ec726315f14a7e755740165858a3a3a70e9b248f91cfdb5', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-15 18:19:23', '2021-10-15 18:19:23', '2022-10-15 13:19:23'),
('e4d8308eb7c6d0742145df08a252af67fcb5cb7b0dc9f0e7be038c3e0f1f0fac42c122338459a4ea', 2, 1, 'Personal Access Token', '[]', 0, '2022-01-26 07:51:22', '2022-01-26 07:51:22', '2023-01-26 02:51:22'),
('e56218dbc93352e27ec30fecf4fb4e4d69711c145119e04c50905ab6061d657bfcc3ecaa8247fa2d', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-31 17:31:35', '2022-01-31 17:31:35', '2023-01-31 12:31:35'),
('e63367b75ff6c473d463f00a87b5c5286ddf79258b54e65e1182f2b38170b78f5349205e31f972dc', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 18:38:23', '2022-01-25 18:38:23', '2023-01-25 13:38:23'),
('e8d03788e23586c8bc73fd6e3fba94f6be064451c382ca9eb48811e18b69d1ede36dc591b608ed11', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 06:50:06', '2022-01-26 06:50:06', '2023-01-26 01:50:06'),
('ebde291ed8d594206fd2a898a28803990668259794251fa7473cca3f23e780883c4abbd6e275c99d', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-16 00:12:26', '2021-10-16 00:12:26', '2022-10-15 19:12:26'),
('ef30522aad18ea7efb3c85c544c913a459a4a9be2bd19834208788074cea9576ab109c1cfa669d73', 2, 1, 'Personal Access Token', '[]', 0, '2022-01-26 07:50:23', '2022-01-26 07:50:23', '2023-01-26 02:50:23'),
('f04f2848d19be85524b967a2b366f92fb04777949f38d377e60d1a18f69a2a46cc1af265e51f718f', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-15 18:05:13', '2021-10-15 18:05:13', '2022-10-15 13:05:13'),
('f282fffab5ae64f3e3482743dffb2b1daffa4ae1bd8159533d8ec974b17e22141d415d3a10a9a117', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-25 01:00:08', '2022-01-25 01:00:08', '2023-01-24 20:00:08'),
('f419b02e2227b6fd7801fd58abfff0bb6c1f945a52d8aceb7908b165f9e4c0805670b031f8df292c', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-16 01:57:59', '2021-10-16 01:57:59', '2022-10-15 20:57:59'),
('f479ba08601b90883becdf022badceba550db51c899341cc5b172e2c873d32572a77e8268ae87a61', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-24 22:41:54', '2022-01-24 22:41:54', '2023-01-24 17:41:54'),
('f48302c17abe4f2a904217607cae87e6099781f8344dd80d1bf87a940c4d75248420c2aa09fe0014', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 03:18:57', '2022-01-26 03:18:57', '2023-01-25 22:18:57'),
('f54dc70ee3798ef9433af49cbb23a21f36b5365ff71d443e1a2687ee72625afbd015132da7566c3a', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-16 01:47:51', '2021-10-16 01:47:51', '2022-10-15 20:47:51'),
('f6ec5f789878cc616d79fb76104006cedb797923698a913275ea6337ead70e65f18c2cc1e9b45ab8', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-31 17:43:20', '2022-01-31 17:43:20', '2023-01-31 12:43:20'),
('fd452ea26c95d27b739f3ef3455a56720706ef4598a759f8b53b7fd749034ebbde4f97ed08e36a86', 0, 1, 'Personal Access Token', '[]', 0, '2022-01-26 05:35:07', '2022-01-26 05:35:07', '2023-01-26 00:35:07'),
('fed3fa4c54e712c3deb1e6aafcdea7ed72652cce0ff1ca37001463bf11419599b6d4146f1428e1f5', 0, 1, 'Personal Access Token', '[]', 0, '2021-10-20 00:28:06', '2021-10-20 00:28:06', '2022-10-19 19:28:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'yUnMadC8XpgGEIwziGzlJVbYLTA9kzgy2tJv2wu1', NULL, 'http://localhost', 1, 0, 0, '2021-10-15 04:38:10', '2021-10-15 04:38:10'),
(2, NULL, 'Laravel Password Grant Client', 'Ie9DdpDudkXjW87Xjy6DXWZPCxcJrfgxoGqkEdgv', 'users', 'http://localhost', 0, 1, 0, '2021-10-15 04:38:10', '2021-10-15 04:38:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-10-15 04:38:10', '2021-10-15 04:38:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phinxlog`
--

CREATE TABLE `phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `phinxlog`
--

INSERT INTO `phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20230127212844, 'InitialDb', '2023-01-28 03:28:44', '2023-01-28 03:28:44', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contacto_financiera`
--
ALTER TABLE `contacto_financiera`
  ADD PRIMARY KEY (`codContacto`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inv-activo_inventario`
--
ALTER TABLE `inv-activo_inventario`
  ADD PRIMARY KEY (`codActivo`);

--
-- Indices de la tabla `inv-categoria_activo_inventario`
--
ALTER TABLE `inv-categoria_activo_inventario`
  ADD PRIMARY KEY (`codCategoriaActivo`);

--
-- Indices de la tabla `inv-detalle_revision`
--
ALTER TABLE `inv-detalle_revision`
  ADD PRIMARY KEY (`codDetalleRevision`);

--
-- Indices de la tabla `inv-empleado_revisador`
--
ALTER TABLE `inv-empleado_revisador`
  ADD PRIMARY KEY (`codEmpleadoRevisador`);

--
-- Indices de la tabla `inv-estado_activo_inventario`
--
ALTER TABLE `inv-estado_activo_inventario`
  ADD PRIMARY KEY (`codEstado`);

--
-- Indices de la tabla `inv-razon_baja_activo`
--
ALTER TABLE `inv-razon_baja_activo`
  ADD PRIMARY KEY (`codRazonBaja`);

--
-- Indices de la tabla `inv-revision_inventario`
--
ALTER TABLE `inv-revision_inventario`
  ADD PRIMARY KEY (`codRevision`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indices de la tabla `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indices de la tabla `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indices de la tabla `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indices de la tabla `phinxlog`
--
ALTER TABLE `phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contacto_financiera`
--
ALTER TABLE `contacto_financiera`
  MODIFY `codContacto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inv-activo_inventario`
--
ALTER TABLE `inv-activo_inventario`
  MODIFY `codActivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `inv-categoria_activo_inventario`
--
ALTER TABLE `inv-categoria_activo_inventario`
  MODIFY `codCategoriaActivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `inv-detalle_revision`
--
ALTER TABLE `inv-detalle_revision`
  MODIFY `codDetalleRevision` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `inv-empleado_revisador`
--
ALTER TABLE `inv-empleado_revisador`
  MODIFY `codEmpleadoRevisador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `inv-estado_activo_inventario`
--
ALTER TABLE `inv-estado_activo_inventario`
  MODIFY `codEstado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `inv-razon_baja_activo`
--
ALTER TABLE `inv-razon_baja_activo`
  MODIFY `codRazonBaja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `inv-revision_inventario`
--
ALTER TABLE `inv-revision_inventario`
  MODIFY `codRevision` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
