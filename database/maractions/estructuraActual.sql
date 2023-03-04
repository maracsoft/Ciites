 -- Backup de estructura generada el 2023-03-01 21:05:48 
 -- ESTE BACKUP SOLO SIRVE PARA HACER SEGUIMIENTO DE CAMBIOS DE MANERA LEGIBLE 
 -- PARA HACER CAMBIOS DE VERDAD YA SE IMPLEMENTÓ EL SISTEMA DE MIGRACIONES PHINX 
 -- Generado por OperacionesController/backup_tables_structure 
 -- Tamaño de la estructura: 48833  


CREATE TABLE `actividad_principal` (
  `codActividadPrincipal` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) NOT NULL,
  PRIMARY KEY (`codActividadPrincipal`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `actividad_res` (
  `codActividad` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(600) NOT NULL,
  `codResultadoEsperado` int(11) NOT NULL,
  PRIMARY KEY (`codActividad`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `archivo_general` (
  `codArchivo` int(11) NOT NULL AUTO_INCREMENT,
  `nombreAparente` varchar(300) NOT NULL,
  `nombreGuardado` varchar(300) NOT NULL,
  `codTipoArchivo` int(11) NOT NULL,
  PRIMARY KEY (`codArchivo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `archivo_orden` (
  `codArchivoOrden` int(11) NOT NULL AUTO_INCREMENT,
  `nombreGuardado` varchar(100) NOT NULL,
  `codOrdenCompra` int(11) NOT NULL,
  `nombreAparente` varchar(300) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`codArchivoOrden`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `archivo_proyecto` (
  `codArchivoProyecto` int(11) NOT NULL AUTO_INCREMENT,
  `nombreDeGuardado` varchar(100) NOT NULL,
  `codProyecto` int(11) NOT NULL,
  `fechaHoraSubida` datetime NOT NULL,
  `codTipoArchivoProyecto` int(11) NOT NULL,
  `nombreAparente` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`codArchivoProyecto`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `archivo_rend` (
  `codArchivoRend` int(11) NOT NULL AUTO_INCREMENT,
  `nombreDeGuardado` varchar(100) NOT NULL,
  `codRendicionGastos` int(11) NOT NULL,
  `nombreAparente` varchar(500) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`codArchivoRend`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `archivo_repo` (
  `codArchivoRepo` int(11) NOT NULL AUTO_INCREMENT,
  `nombreDeGuardado` varchar(100) NOT NULL,
  `codReposicionGastos` int(11) NOT NULL,
  `nombreAparente` varchar(500) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`codArchivoRepo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `archivo_req_admin` (
  `codArchivoReqAdmin` int(11) NOT NULL AUTO_INCREMENT,
  `nombreDeGuardado` varchar(100) NOT NULL,
  `codRequerimiento` int(11) NOT NULL,
  `nombreAparente` varchar(500) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`codArchivoReqAdmin`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `archivo_req_emp` (
  `codArchivoReqEmp` int(11) NOT NULL AUTO_INCREMENT,
  `nombreDeGuardado` varchar(100) NOT NULL,
  `codRequerimiento` int(11) NOT NULL,
  `nombreAparente` varchar(500) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`codArchivoReqEmp`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `archivo_solicitud` (
  `codArchivoSolicitud` int(11) NOT NULL AUTO_INCREMENT,
  `nombreDeGuardado` varchar(200) NOT NULL,
  `codSolicitud` int(11) NOT NULL,
  `nombreAparente` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`codArchivoSolicitud`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `avance_entregable` (
  `codAvance` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(300) NOT NULL,
  `fechaEntrega` date NOT NULL,
  `porcentaje` float NOT NULL,
  `monto` float NOT NULL,
  `codContratoLocacion` int(11) NOT NULL,
  PRIMARY KEY (`codAvance`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `banco` (
  `codBanco` int(11) NOT NULL AUTO_INCREMENT,
  `nombreBanco` varchar(200) NOT NULL,
  PRIMARY KEY (`codBanco`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `busqueda_repo` (
  `codBusqueda` int(11) NOT NULL AUTO_INCREMENT,
  `codEmpleado` int(11) NOT NULL,
  `fechaHoraInicioBuscar` datetime(3) NOT NULL,
  `fechaHoraVerPDF` datetime(3) DEFAULT NULL,
  PRIMARY KEY (`codBusqueda`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `cdp` (
  `codTipoCDP` int(11) NOT NULL AUTO_INCREMENT,
  `nombreCDP` varchar(200) NOT NULL,
  `codigoSUNAT` tinyint(4) NOT NULL,
  PRIMARY KEY (`codTipoCDP`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `cite-actividad` (
  `codActividad` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `codTipoServicio` int(11) NOT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `indice` varchar(20) NOT NULL,
  PRIMARY KEY (`codActividad`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `cite-archivo_servicio` (
  `codArchivoServicio` int(11) NOT NULL AUTO_INCREMENT,
  `codArchivo` int(11) NOT NULL,
  `codServicio` int(11) NOT NULL,
  PRIMARY KEY (`codArchivoServicio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `cite-asistencia_servicio` (
  `codAsistenciaServicio` int(11) NOT NULL AUTO_INCREMENT,
  `codUsuario` int(11) NOT NULL,
  `codServicio` int(11) NOT NULL,
  `externo` int(11) NOT NULL,
  PRIMARY KEY (`codAsistenciaServicio`),
  UNIQUE KEY `unique_asistencia_cite` (`codUsuario`,`codServicio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `cite-cadena` (
  `codCadena` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  PRIMARY KEY (`codCadena`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `cite-clasificacion_rango_ventas` (
  `codClasificacion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  `minimo` float NOT NULL,
  `maximo` float NOT NULL,
  PRIMARY KEY (`codClasificacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `cite-estado_documento` (
  `codEstadoDocumento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  PRIMARY KEY (`codEstadoDocumento`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `cite-estado_reporte_mensual` (
  `codEstado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `explicacion` varchar(200) NOT NULL,
  `icono` varchar(50) NOT NULL,
  `claseBoton` varchar(50) NOT NULL,
  PRIMARY KEY (`codEstado`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `cite-modalidad_servicio` (
  `codModalidad` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  PRIMARY KEY (`codModalidad`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `cite-relacion_usuario_unidad` (
  `codRelacionUsuarioUnidad` int(11) NOT NULL AUTO_INCREMENT,
  `codUsuario` int(11) NOT NULL,
  `codUnidadProductiva` int(11) NOT NULL,
  PRIMARY KEY (`codRelacionUsuarioUnidad`),
  UNIQUE KEY `unique_usuario_unidad_productiva_cite` (`codUsuario`,`codUnidadProductiva`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `cite-reporte_mensual` (
  `codReporte` int(11) NOT NULL AUTO_INCREMENT,
  `año` int(11) NOT NULL,
  `codMes` int(11) NOT NULL,
  `codEmpleado` int(11) NOT NULL,
  `comentario` varchar(100) DEFAULT NULL,
  `fechaHoraMarcacion` datetime DEFAULT NULL,
  `debeReportar` int(11) NOT NULL,
  `codEstado` int(11) NOT NULL,
  `observacion` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`codReporte`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `cite-servicio` (
  `codServicio` int(11) NOT NULL AUTO_INCREMENT,
  `codUnidadProductiva` int(11) NOT NULL,
  `codTipoServicio` int(11) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `codMesAño` int(11) NOT NULL,
  `cantidadServicio` int(11) NOT NULL,
  `totalParticipantes` int(11) NOT NULL,
  `nroHorasEfectivas` float NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaTermino` date NOT NULL,
  `codTipoAcceso` int(11) NOT NULL,
  `codDistrito` int(11) NOT NULL,
  `codModalidad` int(11) NOT NULL,
  `fechaHoraCreacion` varchar(50) NOT NULL,
  `codTipoCDP` int(11) DEFAULT NULL,
  `nroComprobante` varchar(100) DEFAULT NULL,
  `baseImponible` float DEFAULT NULL,
  `igv` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `codEmpleadoCreador` int(11) NOT NULL,
  `codActividad` int(11) NOT NULL,
  PRIMARY KEY (`codServicio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `cite-tipo_acceso` (
  `codTipoAcceso` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  PRIMARY KEY (`codTipoAcceso`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `cite-tipo_personeria` (
  `codTipoPersoneria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `letra` varchar(5) NOT NULL,
  PRIMARY KEY (`codTipoPersoneria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `cite-tipo_servicio` (
  `codTipoServicio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`codTipoServicio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `cite-unidad_productiva` (
  `codUnidadProductiva` int(11) NOT NULL AUTO_INCREMENT,
  `ruc` varchar(50) DEFAULT NULL,
  `razonSocial` varchar(300) DEFAULT NULL,
  `dni` varchar(20) DEFAULT NULL,
  `nombrePersona` varchar(200) DEFAULT NULL,
  `codTipoPersoneria` varchar(11) NOT NULL,
  `fechaHoraCreacion` datetime DEFAULT NULL,
  `direccion` varchar(500) DEFAULT NULL,
  `codDistrito` int(11) DEFAULT NULL,
  `codClasificacion` int(11) NOT NULL,
  `nroServiciosHistorico` int(11) DEFAULT NULL,
  `codCadena` int(11) DEFAULT NULL,
  `codEstadoDocumento` int(11) NOT NULL,
  `enTramite` tinyint(4) NOT NULL,
  `codEmpleadoCreador` int(11) NOT NULL,
  `tieneCadena` int(11) NOT NULL,
  `codUsuarioGerente` int(11) DEFAULT NULL,
  `codUsuarioPresidente` int(11) DEFAULT NULL,
  PRIMARY KEY (`codUnidadProductiva`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `cite-usuario` (
  `codUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `dni` varchar(20) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidoPaterno` varchar(100) NOT NULL,
  `apellidoMaterno` varchar(100) NOT NULL,
  `telefono` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `fechaHoraCreacion` datetime DEFAULT NULL,
  `fechaHoraActualizacion` datetime DEFAULT NULL,
  `codEmpleadoCreador` int(11) NOT NULL,
  PRIMARY KEY (`codUsuario`),
  UNIQUE KEY `unique_dni_cite_usuario` (`dni`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `contacto_financiera` (
  `codContacto` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(200) NOT NULL,
  `apellidos` varchar(200) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `correo` varchar(200) NOT NULL,
  `documentoIdentidad` varchar(200) NOT NULL,
  `codNacionalidad` int(11) NOT NULL,
  `codEntidadFinanciera` int(11) NOT NULL,
  `fechaDeBaja` datetime DEFAULT NULL,
  PRIMARY KEY (`codContacto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1


CREATE TABLE `contrato_locacion` (
  `codContratoLocacion` int(11) NOT NULL AUTO_INCREMENT,
  `codigoCedepas` varchar(30) NOT NULL,
  `nombres` varchar(300) NOT NULL,
  `apellidos` varchar(300) NOT NULL,
  `direccion` varchar(500) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `ruc` varchar(20) NOT NULL,
  `sexo` char(1) NOT NULL,
  `fechaHoraGeneracion` datetime NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFin` date NOT NULL,
  `retribucionTotal` float NOT NULL,
  `motivoContrato` varchar(1000) NOT NULL,
  `codEmpleadoCreador` int(11) NOT NULL,
  `codMoneda` int(11) NOT NULL,
  `codSede` int(11) NOT NULL,
  `provinciaYDepartamento` varchar(200) NOT NULL,
  `esDeCedepas` tinyint(4) NOT NULL,
  `esPersonaNatural` int(11) NOT NULL,
  `razonSocialPJ` varchar(200) DEFAULT NULL,
  `nombreDelCargoPJ` varchar(200) DEFAULT NULL,
  `nombreProyecto` varchar(300) NOT NULL,
  `nombreFinanciera` varchar(300) NOT NULL,
  `fechaHoraAnulacion` datetime DEFAULT NULL,
  PRIMARY KEY (`codContratoLocacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `contrato_plazo` (
  `codContratoPlazo` int(11) NOT NULL AUTO_INCREMENT,
  `codigoCedepas` varchar(30) NOT NULL,
  `nombres` varchar(30) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `direccion` varchar(500) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `sexo` char(1) NOT NULL,
  `asignacionFamiliar` tinyint(4) NOT NULL,
  `fechaHoraGeneracion` datetime NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFin` date NOT NULL,
  `sueldoBruto` float NOT NULL,
  `nombrePuesto` varchar(200) NOT NULL,
  `codMoneda` int(11) NOT NULL,
  `codSede` int(11) NOT NULL,
  `codTipoContrato` int(11) NOT NULL,
  `codEmpleadoCreador` int(11) NOT NULL,
  `nombreFinanciera` varchar(300) NOT NULL,
  `nombreProyecto` varchar(300) NOT NULL,
  `provinciaYDepartamento` varchar(500) NOT NULL,
  `fechaHoraAnulacion` datetime DEFAULT NULL,
  PRIMARY KEY (`codContratoPlazo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `departamento` (
  `codDepartamento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`codDepartamento`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `detalle_dj_gastosmovilidad` (
  `codDetalleMovilidad` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `lugar` varchar(200) NOT NULL,
  `detalle` varchar(200) NOT NULL,
  `importe` float NOT NULL,
  `codDJGastosMovilidad` int(11) NOT NULL,
  PRIMARY KEY (`codDetalleMovilidad`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `detalle_dj_gastosvarios` (
  `codDetalleVarios` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `concepto` varchar(200) NOT NULL,
  `importe` float NOT NULL,
  `codDJGastosVarios` int(11) NOT NULL,
  PRIMARY KEY (`codDetalleVarios`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `detalle_dj_gastosviaticos` (
  `codDetalleViaticos` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `lugar` varchar(200) NOT NULL,
  `montoDesayuno` float NOT NULL,
  `montoAlmuerzo` float NOT NULL,
  `montoCena` float NOT NULL,
  `totalDia` float NOT NULL,
  `codDJGastosViaticos` int(11) NOT NULL,
  PRIMARY KEY (`codDetalleViaticos`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `detalle_orden_compra` (
  `codDetalleOrdenCompra` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` float NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `valorDeVenta` float NOT NULL,
  `precioVenta` float NOT NULL,
  `subtotal` float NOT NULL,
  `codOrdenCompra` int(11) NOT NULL,
  `exoneradoIGV` tinyint(4) NOT NULL,
  `codUnidadMedida` int(11) NOT NULL,
  PRIMARY KEY (`codDetalleOrdenCompra`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `detalle_rendicion_gastos` (
  `codDetalleRendicion` int(11) NOT NULL AUTO_INCREMENT,
  `codRendicionGastos` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `nroComprobante` varchar(200) NOT NULL,
  `concepto` varchar(500) NOT NULL,
  `importe` float NOT NULL,
  `codigoPresupuestal` varchar(200) NOT NULL,
  `codTipoCDP` int(11) NOT NULL,
  `terminacionArchivo` varchar(10) DEFAULT NULL,
  `nroEnRendicion` int(11) NOT NULL,
  `contabilizado` tinyint(4) DEFAULT '0',
  `pendienteDeVer` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codDetalleRendicion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `detalle_reposicion_gastos` (
  `codDetalleReposicion` int(11) NOT NULL AUTO_INCREMENT,
  `codReposicionGastos` int(11) NOT NULL,
  `fechaComprobante` date NOT NULL,
  `nroComprobante` varchar(50) NOT NULL,
  `concepto` varchar(250) CHARACTER SET utf8mb4 NOT NULL,
  `importe` float NOT NULL,
  `codigoPresupuestal` varchar(50) NOT NULL,
  `nroEnReposicion` int(11) NOT NULL,
  `codTipoCDP` int(11) NOT NULL,
  `contabilizado` tinyint(4) DEFAULT '0',
  `pendienteDeVer` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codDetalleReposicion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `detalle_requerimiento_bs` (
  `codDetalleRequerimiento` int(11) NOT NULL AUTO_INCREMENT,
  `codRequerimiento` int(11) NOT NULL,
  `cantidad` float NOT NULL,
  `codUnidadMedida` int(11) NOT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `codigoPresupuestal` varchar(20) NOT NULL,
  PRIMARY KEY (`codDetalleRequerimiento`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `detalle_solicitud_fondos` (
  `codDetalleSolicitud` int(11) NOT NULL AUTO_INCREMENT,
  `codSolicitud` int(11) NOT NULL,
  `nroItem` int(11) NOT NULL,
  `concepto` varchar(200) NOT NULL,
  `importe` float NOT NULL,
  `codigoPresupuestal` varchar(200) NOT NULL,
  PRIMARY KEY (`codDetalleSolicitud`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `distrito` (
  `codDistrito` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `codProvincia` int(11) NOT NULL,
  PRIMARY KEY (`codDistrito`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1


CREATE TABLE `dj_gastosmovilidad` (
  `fechaHoraCreacion` datetime NOT NULL,
  `domicilio` varchar(200) NOT NULL,
  `importeTotal` float NOT NULL,
  `codMoneda` int(11) NOT NULL,
  `codEmpleado` int(11) NOT NULL,
  `codDJGastosMovilidad` int(11) NOT NULL AUTO_INCREMENT,
  `codigoCedepas` varchar(50) NOT NULL,
  PRIMARY KEY (`codDJGastosMovilidad`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `dj_gastosvarios` (
  `codDJGastosVarios` int(11) NOT NULL AUTO_INCREMENT,
  `fechaHoraCreacion` datetime NOT NULL,
  `domicilio` varchar(200) NOT NULL,
  `importeTotal` float NOT NULL,
  `codMoneda` int(11) NOT NULL,
  `codEmpleado` int(11) NOT NULL,
  `codigoCedepas` varchar(50) NOT NULL,
  PRIMARY KEY (`codDJGastosVarios`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `dj_gastosviaticos` (
  `codDJGastosViaticos` int(11) NOT NULL AUTO_INCREMENT,
  `fechaHoraCreacion` datetime NOT NULL,
  `domicilio` varchar(200) NOT NULL,
  `importeTotal` float NOT NULL,
  `codMoneda` int(11) NOT NULL,
  `codEmpleado` int(11) NOT NULL,
  `codigoCedepas` varchar(50) NOT NULL,
  PRIMARY KEY (`codDJGastosViaticos`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `empleado` (
  `codEmpleado` int(11) NOT NULL AUTO_INCREMENT,
  `codUsuario` int(11) NOT NULL,
  `codigoCedepas` varchar(50) NOT NULL,
  `nombres` varchar(300) NOT NULL,
  `apellidos` varchar(300) NOT NULL,
  `correo` varchar(60) NOT NULL,
  `dni` char(8) NOT NULL,
  `codPuesto` int(11) DEFAULT NULL,
  `activo` int(11) NOT NULL,
  `fechaRegistro` date NOT NULL,
  `fechaDeBaja` date DEFAULT NULL,
  `codSede` int(11) DEFAULT NULL,
  `sexo` char(1) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `nombreCargo` varchar(100) NOT NULL,
  `direccion` varchar(300) NOT NULL,
  `nroTelefono` varchar(20) NOT NULL,
  `codSedeContador` int(11) NOT NULL DEFAULT '0',
  `mostrarEnListas` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`codEmpleado`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `empleado_puesto` (
  `codEmpleadoPuesto` int(11) NOT NULL AUTO_INCREMENT,
  `codEmpleado` int(11) NOT NULL,
  `codPuesto` int(11) NOT NULL,
  PRIMARY KEY (`codEmpleadoPuesto`),
  UNIQUE KEY `emp_puesto_restriccion_unicidad` (`codEmpleado`,`codPuesto`),
  KEY `empleado_puesto-puesto` (`codPuesto`),
  CONSTRAINT `empleado_puesto-empleado` FOREIGN KEY (`codEmpleado`) REFERENCES `empleado` (`codEmpleado`),
  CONSTRAINT `empleado_puesto-puesto` FOREIGN KEY (`codPuesto`) REFERENCES `puesto` (`codPuesto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `entidad_financiera` (
  `codEntidadFinanciera` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  PRIMARY KEY (`codEntidadFinanciera`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `error_historial` (
  `codErrorHistorial` int(11) NOT NULL AUTO_INCREMENT,
  `codEmpleado` int(11) NOT NULL,
  `controllerDondeOcurrio` varchar(100) NOT NULL,
  `funcionDondeOcurrio` varchar(200) NOT NULL,
  `fechaHora` datetime NOT NULL,
  `ipEmpleado` varchar(40) NOT NULL,
  `descripcionError` varchar(25000) NOT NULL,
  `estadoError` tinyint(4) NOT NULL,
  `razon` varchar(200) DEFAULT NULL,
  `solucion` varchar(500) DEFAULT NULL,
  `formulario` varchar(3000) NOT NULL,
  `fechaHoraSolucion` datetime DEFAULT NULL,
  PRIMARY KEY (`codErrorHistorial`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `estado_proyecto` (
  `codEstadoProyecto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`codEstadoProyecto`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `estado_rendicion_gastos` (
  `codEstadoRendicion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `ordenListadoEmpleado` int(11) NOT NULL,
  `ordenListadoGerente` int(11) NOT NULL,
  `ordenListadoAdministrador` int(11) NOT NULL,
  `ordenListadoContador` int(11) NOT NULL,
  PRIMARY KEY (`codEstadoRendicion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `estado_reposicion_gastos` (
  `codEstadoReposicion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `ordenListadoEmpleado` int(11) NOT NULL,
  `ordenListadoGerente` int(11) NOT NULL,
  `ordenListadoAdministrador` int(11) NOT NULL,
  `ordenListadoContador` int(11) NOT NULL,
  PRIMARY KEY (`codEstadoReposicion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `estado_requerimiento_bs` (
  `codEstadoRequerimiento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `ordenListadoEmpleado` int(11) NOT NULL,
  `ordenListadoGerente` int(11) NOT NULL,
  `ordenListadoAdministrador` int(11) NOT NULL,
  `ordenListadoContador` int(11) NOT NULL,
  PRIMARY KEY (`codEstadoRequerimiento`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `estado_solicitud_fondos` (
  `codEstadoSolicitud` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `ordenListadoEmpleado` int(11) NOT NULL,
  `ordenListadoGerente` int(11) NOT NULL,
  `ordenListadoAdministrador` int(11) NOT NULL,
  `ordenListadoContador` int(11) NOT NULL,
  PRIMARY KEY (`codEstadoSolicitud`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci


CREATE TABLE `indicador_actividad` (
  `codIndicadorActividad` int(11) NOT NULL AUTO_INCREMENT,
  `codActividad` int(11) NOT NULL,
  `meta` float NOT NULL,
  `unidadMedida` varchar(200) NOT NULL,
  `saldoPendiente` float NOT NULL,
  PRIMARY KEY (`codIndicadorActividad`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `indicador_objespecifico` (
  `codIndicadorObj` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(500) NOT NULL,
  `codObjEspecifico` int(11) NOT NULL,
  PRIMARY KEY (`codIndicadorObj`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `indicador_resultado` (
  `codIndicadorResultado` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(500) NOT NULL,
  `codResultadoEsperado` int(11) NOT NULL,
  PRIMARY KEY (`codIndicadorResultado`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `inv-activo_inventario` (
  `codActivo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `caracteristicas` varchar(500) NOT NULL,
  `placa` varchar(20) NOT NULL,
  `codCategoriaActivo` int(11) NOT NULL,
  `codProyecto` int(11) NOT NULL,
  `codEstado` int(11) NOT NULL,
  `codEmpleadoResponsable` int(11) NOT NULL,
  `codSede` int(11) NOT NULL,
  `codRazonBaja` int(11) DEFAULT NULL,
  `codigoAparente` varchar(100) NOT NULL,
  PRIMARY KEY (`codActivo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `inv-categoria_activo_inventario` (
  `codCategoriaActivo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`codCategoriaActivo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `inv-detalle_revision` (
  `codDetalleRevision` int(11) NOT NULL AUTO_INCREMENT,
  `codActivo` int(11) NOT NULL,
  `codRevision` int(11) NOT NULL,
  `codEstado` int(11) NOT NULL,
  `fechaHoraUltimoCambio` datetime DEFAULT NULL,
  `codEmpleadoQueReviso` int(11) DEFAULT NULL,
  `codRazonBaja` int(11) DEFAULT NULL,
  PRIMARY KEY (`codDetalleRevision`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `inv-empleado_revisador` (
  `codEmpleadoRevisador` int(11) NOT NULL AUTO_INCREMENT,
  `codRevision` int(11) NOT NULL,
  `codEmpleado` int(11) NOT NULL,
  `codSede` int(11) NOT NULL,
  PRIMARY KEY (`codEmpleadoRevisador`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `inv-estado_activo_inventario` (
  `codEstado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`codEstado`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `inv-razon_baja_activo` (
  `codRazonBaja` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`codRazonBaja`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `inv-revision_inventario` (
  `codRevision` int(11) NOT NULL AUTO_INCREMENT,
  `fechaHoraInicio` datetime NOT NULL,
  `fechaHoraCierre` datetime DEFAULT NULL,
  `descripcion` varchar(500) NOT NULL,
  `codEmpleadoResponsable` int(11) NOT NULL,
  `año` int(11) NOT NULL,
  PRIMARY KEY (`codRevision`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `job` (
  `codJob` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `functionName` varchar(100) NOT NULL,
  `fechaHoraCreacion` datetime NOT NULL,
  `fechaHoraEjecucion` datetime DEFAULT NULL,
  `ejecutado` int(11) NOT NULL,
  PRIMARY KEY (`codJob`),
  UNIQUE KEY `nombre_unico` (`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `logeo_historial` (
  `codLogeoHistorial` int(11) NOT NULL AUTO_INCREMENT,
  `codEmpleado` int(11) NOT NULL,
  `fechaHoraLogeo` datetime NOT NULL,
  `ipLogeo` varchar(100) NOT NULL,
  PRIMARY KEY (`codLogeoHistorial`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `lugar_ejecucion` (
  `codLugarEjecucion` int(11) NOT NULL AUTO_INCREMENT,
  `codProyecto` int(11) NOT NULL,
  `codDistrito` int(11) NOT NULL,
  `zona` varchar(200) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`codLugarEjecucion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `medio_verificacion_meta` (
  `codMedioVerificacion` int(11) NOT NULL AUTO_INCREMENT,
  `nombreGuardado` varchar(100) NOT NULL,
  `nombreAparente` varchar(100) NOT NULL,
  `codMetaEjecutada` int(11) NOT NULL,
  PRIMARY KEY (`codMedioVerificacion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1


CREATE TABLE `medio_verificacion_resultado` (
  `codMedioVerificacion` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(600) NOT NULL,
  `nombreGuardado` varchar(100) NOT NULL,
  `nombreAparente` varchar(100) NOT NULL,
  `codIndicadorResultado` int(11) NOT NULL,
  PRIMARY KEY (`codMedioVerificacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `mes` (
  `codMes` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `abreviacion` varchar(30) NOT NULL,
  `codDosDig` varchar(2) NOT NULL,
  PRIMARY KEY (`codMes`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1


CREATE TABLE `mes_anio` (
  `codMesAño` int(11) NOT NULL AUTO_INCREMENT,
  `año` int(11) NOT NULL,
  `codMes` int(11) NOT NULL,
  PRIMARY KEY (`codMesAño`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `meta_ejecutada` (
  `codMetaEjecutada` int(11) NOT NULL AUTO_INCREMENT,
  `cantidadProgramada` float NOT NULL,
  `cantidadEjecutada` float DEFAULT NULL,
  `codEmpleado` int(11) NOT NULL,
  `fechaRegistroProgramacion` datetime NOT NULL,
  `mesAñoObjetivo` date NOT NULL,
  `codIndicadorActividad` int(11) NOT NULL,
  `desviacion` float DEFAULT NULL,
  `tasaEjecucion` float DEFAULT NULL,
  `fechaRegistroEjecucion` datetime DEFAULT NULL,
  `ejecutada` tinyint(4) NOT NULL,
  `esReprogramada` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codMetaEjecutada`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci


CREATE TABLE `moneda` (
  `codMoneda` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(10) NOT NULL,
  `abreviatura` varchar(10) NOT NULL,
  `simbolo` varchar(10) NOT NULL,
  PRIMARY KEY (`codMoneda`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `nacionalidad` (
  `codNacionalidad` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `pais` varchar(200) NOT NULL,
  `abreviacion` varchar(10) NOT NULL,
  PRIMARY KEY (`codNacionalidad`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `notificacion` (
  `codNotificacion` int(11) NOT NULL AUTO_INCREMENT,
  `codTipoNotificacion` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `visto` tinyint(4) NOT NULL,
  `link` varchar(200) NOT NULL,
  `descripcionAbreviada` varchar(200) NOT NULL,
  `codEmpleado` int(11) NOT NULL,
  `fechaHoraCreacion` datetime NOT NULL,
  `fechaHoraVisto` datetime DEFAULT NULL,
  PRIMARY KEY (`codNotificacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `numeracion` (
  `codNumeracion` int(11) NOT NULL AUTO_INCREMENT,
  `nombreDocumento` varchar(50) NOT NULL,
  `año` smallint(6) NOT NULL,
  `numeroLibreActual` int(11) NOT NULL,
  PRIMARY KEY (`codNumeracion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci


CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci


CREATE TABLE `oauth_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci


CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci


CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci


CREATE TABLE `objetivo_especifico` (
  `codObjEspecifico` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(600) NOT NULL,
  `codProyecto` int(11) NOT NULL,
  PRIMARY KEY (`codObjEspecifico`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `objetivo_estrategico_cedepas` (
  `codObjetivoEstrategico` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(1000) NOT NULL,
  `codPEI` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  PRIMARY KEY (`codObjetivoEstrategico`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `objetivo_milenio` (
  `codObjetivoMilenio` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(500) NOT NULL,
  `item` int(11) NOT NULL,
  PRIMARY KEY (`codObjetivoMilenio`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `operacion_documento` (
  `codOperacionDocumento` int(11) NOT NULL AUTO_INCREMENT,
  `codTipoDocumento` int(11) NOT NULL,
  `codTipoOperacion` int(11) NOT NULL,
  `codDocumento` int(11) NOT NULL,
  `fechaHora` datetime NOT NULL,
  `descripcionObservacion` varchar(500) DEFAULT NULL,
  `codPuesto` int(11) NOT NULL,
  `codEmpleado` int(11) NOT NULL,
  PRIMARY KEY (`codOperacionDocumento`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `orden_compra` (
  `codOrdenCompra` int(11) NOT NULL AUTO_INCREMENT,
  `señores` varchar(100) NOT NULL,
  `ruc` varchar(13) NOT NULL,
  `direccion` varchar(300) NOT NULL,
  `atencion` varchar(200) NOT NULL,
  `referencia` varchar(200) NOT NULL,
  `total` float NOT NULL,
  `partidaPresupuestal` varchar(50) NOT NULL,
  `observacion` varchar(350) NOT NULL,
  `codProyecto` int(11) NOT NULL,
  `codMoneda` int(11) NOT NULL,
  `codEmpleadoCreador` int(11) NOT NULL,
  `fechaHoraCreacion` datetime NOT NULL,
  `codigoCedepas` varchar(50) NOT NULL,
  `codSede` int(11) NOT NULL,
  PRIMARY KEY (`codOrdenCompra`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `parametro_sistema` (
  `codParametro` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(500) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `valor` varchar(1000) NOT NULL,
  `fechaHoraCreacion` datetime NOT NULL,
  `fechaHoraBaja` datetime DEFAULT NULL,
  `fechaHoraActualizacion` datetime DEFAULT NULL,
  `codTipoParametro` int(11) NOT NULL,
  `test` int(11) DEFAULT NULL,
  PRIMARY KEY (`codParametro`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `persona_juridica_poblacion` (
  `codPersonaJuridica` int(11) NOT NULL AUTO_INCREMENT,
  `ruc` varchar(15) NOT NULL,
  `razonSocial` varchar(100) NOT NULL,
  `direccion` varchar(300) NOT NULL,
  `numeroSociosHombres` int(11) NOT NULL,
  `numeroSociosMujeres` int(11) NOT NULL,
  `codTipoPersonaJuridica` int(11) NOT NULL,
  `representante` varchar(300) NOT NULL,
  PRIMARY KEY (`codPersonaJuridica`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `persona_natural_poblacion` (
  `codPersonaNatural` int(11) NOT NULL AUTO_INCREMENT,
  `dni` varchar(15) NOT NULL,
  `nombres` varchar(200) NOT NULL,
  `apellidos` varchar(200) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `edadMomentanea` int(11) NOT NULL,
  `sexo` char(1) DEFAULT NULL,
  `direccion` varchar(300) DEFAULT NULL,
  `nroTelefono` varchar(20) DEFAULT NULL,
  `codLugarEjecucion` int(11) NOT NULL,
  PRIMARY KEY (`codPersonaNatural`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci


CREATE TABLE `plan_estrategico_institucional` (
  `codPEI` int(11) NOT NULL AUTO_INCREMENT,
  `añoInicio` int(11) NOT NULL,
  `añoFin` int(11) NOT NULL,
  PRIMARY KEY (`codPEI`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `poblacion_beneficiaria` (
  `codPoblacionBeneficiaria` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(500) NOT NULL,
  `codProyecto` int(11) NOT NULL,
  PRIMARY KEY (`codPoblacionBeneficiaria`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `provincia` (
  `codProvincia` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `codDepartamento` int(11) NOT NULL,
  PRIMARY KEY (`codProvincia`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `proyecto` (
  `codProyecto` int(11) NOT NULL AUTO_INCREMENT,
  `codigoPresupuestal` varchar(5) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `codEmpleadoDirector` int(11) DEFAULT NULL,
  `codSedePrincipal` int(11) DEFAULT NULL,
  `nombreLargo` varchar(300) DEFAULT NULL,
  `codEntidadFinanciera` int(11) NOT NULL,
  `codPEI` int(11) NOT NULL,
  `objetivoGeneral` varchar(500) NOT NULL,
  `fechaInicio` date NOT NULL,
  `importePresupuestoTotal` float NOT NULL,
  `importeContrapartidaCedepas` float NOT NULL,
  `importeContrapartidaPoblacionBeneficiaria` float NOT NULL,
  `importeContrapartidaOtros` float NOT NULL,
  `codMoneda` int(11) NOT NULL,
  `codTipoFinanciamiento` int(11) NOT NULL,
  `codEstadoProyecto` int(11) NOT NULL,
  `fechaFinalizacion` date NOT NULL,
  `importeFinanciamiento` float NOT NULL,
  `contacto_nombres` varchar(200) DEFAULT NULL,
  `contacto_telefono` varchar(200) DEFAULT NULL,
  `contacto_correo` varchar(200) DEFAULT NULL,
  `contacto_cargo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`codProyecto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `proyecto_contador` (
  `codProyectoContador` int(11) NOT NULL AUTO_INCREMENT,
  `codEmpleadoContador` int(11) NOT NULL,
  `codProyecto` int(11) NOT NULL,
  PRIMARY KEY (`codProyectoContador`),
  UNIQUE KEY `proy_cont_restriccion_unica` (`codEmpleadoContador`,`codProyecto`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `proyecto_observador` (
  `codProyectoObservador` int(11) NOT NULL AUTO_INCREMENT,
  `codProyecto` int(11) NOT NULL,
  `codEmpleadoObservador` int(11) NOT NULL,
  PRIMARY KEY (`codProyectoObservador`),
  UNIQUE KEY `unicidadd` (`codProyecto`,`codEmpleadoObservador`),
  KEY `empleado` (`codEmpleadoObservador`),
  CONSTRAINT `empleado` FOREIGN KEY (`codEmpleadoObservador`) REFERENCES `empleado` (`codEmpleado`),
  CONSTRAINT `proyecto` FOREIGN KEY (`codProyecto`) REFERENCES `proyecto` (`codProyecto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `puesto` (
  `codPuesto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `estado` int(11) NOT NULL,
  `nombreAparente` varchar(100) NOT NULL,
  `descripcion` varchar(250) NOT NULL,
  `ordenListado` int(11) NOT NULL,
  PRIMARY KEY (`codPuesto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `relacion_personajur_poblacion` (
  `codRelacionJur` int(11) NOT NULL AUTO_INCREMENT,
  `codPoblacionBeneficiaria` int(11) NOT NULL,
  `codPersonaJuridica` int(11) NOT NULL,
  PRIMARY KEY (`codRelacionJur`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `relacion_personajuridica_actividad` (
  `codRelacion` int(11) NOT NULL AUTO_INCREMENT,
  `codActividadPrincipal` int(11) NOT NULL,
  `codPersonaJuridica` int(11) NOT NULL,
  PRIMARY KEY (`codRelacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `relacion_personanat_poblacion` (
  `codRelacionNat` int(11) NOT NULL AUTO_INCREMENT,
  `codPersonaNatural` int(11) NOT NULL,
  `codPoblacionBeneficiaria` int(11) NOT NULL,
  PRIMARY KEY (`codRelacionNat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `relacion_personanatural_actividad` (
  `codRelacion` int(11) NOT NULL AUTO_INCREMENT,
  `codActividadPrincipal` int(11) NOT NULL,
  `codPersonaNatural` int(11) NOT NULL,
  PRIMARY KEY (`codRelacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `relacion_proyecto_objestrategicos` (
  `codRelacion` int(11) NOT NULL AUTO_INCREMENT,
  `codObjetivoEstrategico` int(11) NOT NULL,
  `codProyecto` int(11) NOT NULL,
  `porcentajeDeAporte` float NOT NULL,
  PRIMARY KEY (`codRelacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `relacion_proyecto_objmilenio` (
  `codRelacion` int(11) NOT NULL AUTO_INCREMENT,
  `porcentaje` float NOT NULL,
  `codObjetivoMilenio` int(11) NOT NULL,
  `codProyecto` int(11) NOT NULL,
  PRIMARY KEY (`codRelacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `rendicion_gastos` (
  `codRendicionGastos` int(11) NOT NULL AUTO_INCREMENT,
  `codSolicitud` int(11) NOT NULL,
  `codMoneda` int(11) NOT NULL,
  `codigoCedepas` varchar(50) NOT NULL,
  `totalImporteRecibido` float DEFAULT NULL,
  `totalImporteRendido` float DEFAULT NULL,
  `saldoAFavorDeEmpleado` float DEFAULT NULL,
  `resumenDeActividad` varchar(350) NOT NULL,
  `codEstadoRendicion` int(11) NOT NULL,
  `fechaHoraRendicion` datetime DEFAULT NULL,
  `fechaHoraRevisado` datetime DEFAULT NULL,
  `observacion` varchar(500) DEFAULT NULL,
  `codEmpleadoSolicitante` int(11) NOT NULL,
  `codEmpleadoEvaluador` int(11) DEFAULT NULL,
  `codEmpleadoContador` int(11) DEFAULT NULL,
  `cantArchivos` int(11) DEFAULT NULL,
  `terminacionesArchivos` varchar(200) DEFAULT NULL,
  `codProyecto` int(11) NOT NULL,
  `codigoContrapartida` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`codRendicionGastos`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `reposicion_gastos` (
  `codReposicionGastos` int(11) NOT NULL AUTO_INCREMENT,
  `codEstadoReposicion` int(11) NOT NULL,
  `totalImporte` float DEFAULT NULL,
  `codProyecto` int(11) NOT NULL,
  `codMoneda` int(11) NOT NULL,
  `codigoCedepas` varchar(30) NOT NULL,
  `girarAOrdenDe` varchar(50) NOT NULL,
  `numeroCuentaBanco` varchar(100) NOT NULL,
  `codBanco` int(11) NOT NULL,
  `resumen` varchar(500) CHARACTER SET utf8mb4 NOT NULL,
  `fechaHoraEmision` datetime(3) NOT NULL,
  `codEmpleadoSolicitante` int(11) NOT NULL,
  `codEmpleadoEvaluador` int(11) DEFAULT NULL,
  `codEmpleadoAdmin` int(11) DEFAULT NULL,
  `codEmpleadoConta` int(11) DEFAULT NULL,
  `fechaHoraRevisionGerente` datetime DEFAULT NULL,
  `fechaHoraRevisionAdmin` datetime DEFAULT NULL,
  `fechaHoraRevisionConta` datetime DEFAULT NULL,
  `observacion` varchar(200) DEFAULT NULL,
  `cantArchivos` tinyint(4) DEFAULT NULL,
  `terminacionesArchivos` varchar(100) DEFAULT NULL,
  `fechaHoraRenderizadoVistaCrear` datetime(3) DEFAULT NULL,
  `codigoContrapartida` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`codReposicionGastos`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `requerimiento_bs` (
  `codRequerimiento` int(11) NOT NULL AUTO_INCREMENT,
  `codigoCedepas` varchar(30) NOT NULL,
  `fechaHoraEmision` datetime NOT NULL,
  `fechaHoraRevision` datetime DEFAULT NULL,
  `fechaHoraAtendido` datetime DEFAULT NULL,
  `fechaHoraConta` datetime DEFAULT NULL,
  `codEmpleadoSolicitante` int(11) NOT NULL,
  `codEmpleadoEvaluador` int(11) DEFAULT NULL,
  `codEmpleadoAdministrador` int(11) DEFAULT NULL,
  `codEmpleadoContador` int(11) DEFAULT NULL,
  `justificacion` varchar(350) CHARACTER SET utf8mb4 NOT NULL,
  `codEstadoRequerimiento` int(11) NOT NULL,
  `cantArchivosEmp` tinyint(4) DEFAULT NULL,
  `nombresArchivosEmp` varchar(500) DEFAULT NULL,
  `cantArchivosAdmin` tinyint(4) DEFAULT NULL,
  `nombresArchivosAdmin` varchar(500) DEFAULT NULL,
  `codProyecto` int(11) NOT NULL,
  `observacion` varchar(200) DEFAULT NULL,
  `cuentaBancariaProveedor` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `tieneFactura` tinyint(4) DEFAULT NULL,
  `facturaContabilizada` tinyint(4) DEFAULT '0',
  `codigoContrapartida` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`codRequerimiento`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `resultado_esperado` (
  `codResultadoEsperado` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(500) NOT NULL,
  `codProyecto` int(11) NOT NULL,
  PRIMARY KEY (`codResultadoEsperado`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `sede` (
  `codSede` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `esSedePrincipal` tinyint(4) NOT NULL,
  `codEmpleadoAdministrador` int(11) NOT NULL,
  PRIMARY KEY (`codSede`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `solicitud_fondos` (
  `codSolicitud` int(11) NOT NULL AUTO_INCREMENT,
  `codProyecto` int(11) NOT NULL,
  `codigoCedepas` varchar(200) NOT NULL,
  `codEmpleadoSolicitante` int(11) NOT NULL,
  `fechaHoraEmision` datetime NOT NULL,
  `totalSolicitado` float DEFAULT NULL,
  `girarAOrdenDe` varchar(200) NOT NULL,
  `numeroCuentaBanco` varchar(200) NOT NULL,
  `codBanco` int(11) NOT NULL,
  `justificacion` varchar(350) DEFAULT NULL,
  `codEmpleadoEvaluador` int(11) DEFAULT NULL,
  `fechaHoraRevisado` datetime DEFAULT NULL,
  `codEstadoSolicitud` int(11) NOT NULL,
  `fechaHoraAbonado` datetime DEFAULT NULL,
  `observacion` varchar(300) DEFAULT NULL,
  `terminacionArchivo` varchar(10) DEFAULT NULL,
  `codEmpleadoAbonador` int(11) DEFAULT NULL,
  `estaRendida` int(11) DEFAULT '0',
  `codEmpleadoContador` int(11) DEFAULT NULL,
  `codMoneda` int(11) NOT NULL,
  `codigoContrapartida` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`codSolicitud`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `tipo_archivo_general` (
  `codTipoArchivo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`codTipoArchivo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `tipo_archivo_proyecto` (
  `codTipoArchivoProyecto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(300) NOT NULL,
  PRIMARY KEY (`codTipoArchivoProyecto`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `tipo_contrato` (
  `codTipoContrato` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`codTipoContrato`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `tipo_documento` (
  `codTipoDocumento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `abreviacion` varchar(10) NOT NULL,
  PRIMARY KEY (`codTipoDocumento`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `tipo_financiamiento` (
  `codTipoFinanciamiento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`codTipoFinanciamiento`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `tipo_notificacion` (
  `codTipoNotificacion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`codTipoNotificacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `tipo_operacion` (
  `codTipoOperacion` int(11) NOT NULL AUTO_INCREMENT,
  `codTipoDocumento` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`codTipoOperacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `tipo_parametro_sistema` (
  `codTipoParametro` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `componente_frontend` varchar(100) NOT NULL,
  `comentario` varchar(200) NOT NULL,
  PRIMARY KEY (`codTipoParametro`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


CREATE TABLE `tipo_persona_juridica` (
  `codTipoPersonaJuridica` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `siglas` varchar(20) NOT NULL,
  PRIMARY KEY (`codTipoPersonaJuridica`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `unidad_medida` (
  `codUnidadMedida` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`codUnidadMedida`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1


CREATE TABLE `usuario` (
  `codUsuario` bigint(20) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `isAdmin` int(11) NOT NULL,
  PRIMARY KEY (`codUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4


