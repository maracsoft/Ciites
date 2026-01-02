<?php


use App\Empleado;

use App\Routers\RouterConstanciaDeposito;
use App\Routers\RouterViajes;
use Illuminate\Support\Facades\Route;



Route::get('/PaginaEnMantenimiento/', 'UserController@paginaEnMantenimiento')->name('mantenimiento');

Route::group(['middleware' => "Mantenimiento"], function () {

  RouterConstanciaDeposito::RegisterRoutes();
  RouterViajes::RegisterRoutes();


  Route::get('/login', 'UserController@verLogin')->name('user.verLogin'); //para desplegar la vista del Login
  Route::post('/ingresar', 'UserController@logearse')->name('user.logearse');
  Route::get('/cerrarSesion', 'UserController@cerrarSesion')->name('user.cerrarSesion');

  Route::get('/redireccionamiento', function () {
    return view('MensajeRedireccion');
  });

  Route::get('/', 'UserController@home')->name('user.home');






  Route::get('/probandoCosas', function () {});






  Route::get('/Error', function () {

    $msj = session('datos');
    $datos = '';
    if ($msj != '')
      $datos = $msj;

    session(['datos' => '']);
    return view('ERROR', compact('datos'));
  })->name('error');


  /* RUTAS SERVICIOS */
  Route::get('/listarDetallesDeSolicitud/{id}', 'SolicitudFondosController@listarDetalles');
  Route::get('/listarDetallesDeRendicion/{id}', 'RendicionGastosController@listarDetalles');
  Route::get('/listarDetallesDeReposicion/{id}', 'ReposicionGastosController@listarDetalles');
  Route::get('/listarDetallesDeRequerimiento/{id}', 'RequerimientoBSController@listarDetalles');
  Route::get('/listarDetallesDeOrdenCompra/{id}', 'OrdenCompraController@listarDetalles');

  Route::get('/solicitudFondos/getNumeracionActual/', 'SolicitudFondosController@getNumeracionLibre');
  Route::get('/rendicionGastos/getNumeracionActual/', 'RendicionGastosController@getNumeracionLibre');
  Route::get('/reposicionGastos/getNumeracionActual/', 'ReposicionGastosController@getNumeracionLibre');
  Route::get('/obtenerCodigoPresupuestalDeProyecto/{id}', 'ProyectoController@getCodigoPresupuestal');

  Route::get('/listarProvinciasDeDepartamento/{id}', 'ProyectoController@listarProvinciasDeDepartamento');
  Route::get('/listarDistritosDeProvincia/{id}', 'ProyectoController@listarDistritosDeProvincia');



  Route::get('/ConsultarAPISunat/ruc/{ruc}', 'PersonaPoblacionController@ConsultarAPISunatRUC');
  Route::get('/ConsultarAPISunat/dni/{dni}', 'PersonaPoblacionController@ConsultarAPISunatDNI');


  Route::get('/Sede/cambiarAdministrador/{cadena}', 'SedeController@cambiarAdministrador');

  Route::get('/GestiónUsuarios/asignarProyectoAContador/{cadena}', 'EmpleadoController@asignarProyectoAContador');
  Route::get('/GestiónUsuarios/asignarContadorATodosProyectos/{codEmpleadoContador}', 'EmpleadoController@asignarContadorATodosProyectos');
  Route::get('/GestiónUsuarios/quitarContadorATodosProyectos/{codEmpleadoContador}', 'EmpleadoController@quitarContadorATodosProyectos');


  Route::get('/GestiónUsuarios/asignarProyectoAObservador/{cadena}', 'EmpleadoController@asignarProyectoAObservador');
  Route::get('/GestiónUsuarios/asignarObservadorATodosProyectos/{codEmpleadoContador}', 'EmpleadoController@asignarObservadorATodosProyectos');
  Route::get('/GestiónUsuarios/quitarObservadorATodosProyectos/{codEmpleadoContador}', 'EmpleadoController@quitarObservadorATodosProyectos');








  /* ESTE MIDDLEWARE VALIDA SI ES QUE ESTÁS LOGEADO, SI NO, TE MANDA AL LOGIN */
  Route::group(['middleware' => "ValidarSesion"], function () {



    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ----------------------------------------------        MODULO SOLICITUD DE FONDOS ---------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */



    /* AFUERA DEL MIDDLEWARE(no requieren validacion o hacerlas sería demasiado complejo xd) */
    Route::get('/SolicitudFondos/MASTERINDEX', 'SolicitudFondosController@listarSolicitudes')->name('solicitudFondos.ListarSolicitudes');








    Route::get('/SolicitudFondos/descargar/{id}', 'SolicitudFondosController@descargarPDF')->name('solicitudFondos.descargarPDF');
    Route::get('/SolicitudFondos/verPDF/{id}', 'SolicitudFondosController@verPDF')->name('solicitudFondos.verPDF');

    Route::get('/SolicitudFondos/descargarArchivo/{codArc}', 'SolicitudFondosController@descargarArchivo')->name('SolicitudFondos.descargarArchivo');

    Route::get('/SolicitudFondos/eliminarArchivo/{codArc}', 'SolicitudFondosController@eliminarArchivo')->name('SolicitudFondos.eliminarArchivo');


    /* EMPLEADO Cualquier user logeado puede hacer, no es necesario validar*/
    Route::get('/SolicitudFondos/Empleado/Crear', 'SolicitudFondosController@create')->name('SolicitudFondos.Empleado.Create');

    Route::get('/SolicitudFondos/Empleado/editar/{id}', 'SolicitudFondosController@edit')->name('SolicitudFondos.Empleado.Edit');


    Route::get('/SolicitudFondos/Empleado/delete/{id}', 'SolicitudFondosController@cancelar')->name('SolicitudFondos.Empleado.cancelar');

    Route::get('/SolicitudFondos/Empleado/listar/', 'SolicitudFondosController@listarSolicitudesDeEmpleado')->name('SolicitudFondos.Empleado.Listar');





    Route::get('/SolicitudFondos/{id}/Empleado/ver/', 'SolicitudFondosController@ver')
      ->name('SolicitudFondos.Empleado.Ver');

    Route::post('/SolicitudFondos/Empleado/guardar', 'SolicitudFondosController@store')
      ->name('SolicitudFondos.Empleado.Guardar');


    Route::get('/SolicitudFondos/Empleado/Rendir/{id}', 'SolicitudFondosController@rendir')
      ->name('SolicitudFondos.Empleado.Rendir');

    Route::post('/SolicitudFondos/{id}/Empleado/update/', 'SolicitudFondosController@update')
      ->name('SolicitudFondos.Empleado.update');



    /* GERENTE */


    Route::group(['middleware' => "ValidarSesionGerente"], function () {

      Route::get('/SolicitudFondos/{id}/Gerente/Revisar/', 'SolicitudFondosController@revisar')
        ->name('SolicitudFondos.Gerente.Revisar');

      Route::get('/SolicitudFondos/Gerente/listar', 'SolicitudFondosController@listarSolicitudesParaGerente')
        ->name('SolicitudFondos.Gerente.Listar');

      Route::Post('/SolicitudFondos/Gerente/Aprobar/', 'SolicitudFondosController@aprobar')
        ->name('SolicitudFondos.Gerente.Aprobar');


      Route::post('/SolicitudFondos/Gerente/Observar', 'SolicitudFondosController@observarGerente')->name('solicitudFondos.Gerente.observar');
      Route::get('/SolicitudFondos/Gerente/Rechazar/{id}', 'SolicitudFondosController@rechazarGerente')->name('SolicitudFondos.Gerente.Rechazar');
    });

    Route::group(['middleware' => "ValidarSesionAdministracion"], function () {

      /* ADMINSITRACION */
      Route::get('/SolicitudFondos/Administración/listar', 'SolicitudFondosController@listarSolicitudesParaJefe')->name('SolicitudFondos.Administracion.Listar');

      Route::get('/SolicitudFondos/{id}/Administracion/vistaAbonar/', 'SolicitudFondosController@vistaAbonar')->name('SolicitudFondos.Administracion.verAbonar');

      Route::post('/SolicitudFondos/Administracion/Abonar/', 'SolicitudFondosController@abonar')->name('SolicitudFondos.Administracion.Abonar');

      Route::post('/SolicitudFondos/Administrador/Observar', 'SolicitudFondosController@observarAdministrador')->name('solicitudFondos.Administrador.observar');
      Route::get('/SolicitudFondos/Administrador/Rechazar/{id}', 'SolicitudFondosController@rechazarAdministrador')->name('SolicitudFondos.Administrador.Rechazar');
    });

    Route::group(['middleware' => "ValidarSesionContador"], function () {

      /* CONTADOR */

      Route::get('/SolicitudFondos/Contador/listar', 'SolicitudFondosController@listarSolicitudesParaContador')->name('SolicitudFondos.Contador.Listar');
      Route::get('/SolicitudFondos/{id}/Contador/verContabilizar/', 'SolicitudFondosController@verContabilizar')->name('SolicitudFondos.Contador.verContabilizar');
      Route::get('/SolicitudFondos/Contador/Contabilizar/{id}', 'SolicitudFondosController@contabilizar')->name('SolicitudFondos.Contador.Contabilizar');
    });

    Route::group(['middleware' => "ValidarSesionObservador"], function () {
      Route::get('/SolicitudFondos/Observador/listar', 'SolicitudFondosController@listarSolicitudesParaObservador')->name('SolicitudFondos.Observador.Listar');
      Route::get('/SolicitudFondos/Observador/Ver/{codSolicitud}', 'SolicitudFondosController@VerSolicitudComoObservador')->name('SolicitudFondos.Observador.Ver');
    });












    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* -----------------------------------------------------MODULO RENDICIONES--------- ---------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */


    Route::post('/reportes/ver', 'RendicionGastosController@reportes')->name('rendicionGastos.reportes');


    Route::get('/reportes/descargar/{str}', 'RendicionGastosController@descargarReportes')->name('rendicionGastos.descargarReportes');


    Route::get('/rendicion/descargarCDP/{cadena}', 'RendicionGastosController@descargarCDP')->name('rendiciones.descargarCDP');

    //se consume desde JS
    Route::get('/RendicionGastos/eliminarArchivo/{codArchivoRend}', 'RendicionGastosController@eliminarArchivo');




    Route::get('/RendicionGastos//descargarPDF/{id}', 'RendicionGastosController@descargarPDF')->name('rendicionGastos.descargarPDF');

    Route::get('/RendicionGastos/verPDF/{id}', 'RendicionGastosController@verPDF')->name('rendicionGastos.verPDF');



    Route::post('/rendiciones/Gerente/observar', 'RendicionGastosController@observarComoGerente')->name('RendicionGastos.Gerente.Observar');
    Route::post('/rendiciones/Administrador/observar', 'RendicionGastosController@observarComoAdministrador')->name('RendicionGastos.Administrador.Observar');
    Route::post('/rendiciones/Contador/observar', 'RendicionGastosController@observarComoContador')->name('RendicionGastos.Contador.Observar');


    /* EMPLEADO */

    Route::post('/RendicionGastos/Empleado/guardar', 'RendicionGastosController@store')->name('RendicionGastos.Empleado.Store');

    Route::get('/RendicionGastos/{id}/Empleado/ver/', 'RendicionGastosController@ver')->name('RendicionGastos.Empleado.Ver');


    Route::get('RendicionGastos/{id}/Empleado/editar', 'RendicionGastosController@editar')->name('RendicionGastos.Empleado.Editar');

    Route::Post('/RendicionGastos/Empleado/update/', 'RendicionGastosController@update')->name('RendicionGastos.Empleado.Update');
    Route::get('/RendicionGastos/Empleado/Listar/', 'RendicionGastosController@listarEmpleado')->name('RendicionGastos.Empleado.Listar');


    Route::get('RendicionGastos/Empleado/verMisGastos', 'RendicionGastosController@listarMisGastosRendicion')
      ->name('RendicionGastos.Empleado.verMisGastos');


    Route::get('/RendicionGastos/{codDetalle}/Empleado/marcarComoVisto', 'RendicionGastosController@marcarDetalleComoVisto')
      ->name('RendicionGastos.Empleado.marcarComoVisto');


    Route::group(['middleware' => "ValidarSesionGerente"], function () {

      /* GERENTE */

      Route::get('/RendicionGastos/{id}/Gerente/ver', 'RendicionGastosController@verGerente')
        ->name('RendicionGastos.Gerente.Ver');

      Route::get('/RendicionGastos/{id}/Gerente/revisar', 'RendicionGastosController@revisar')
        ->name('RendicionGastos.Gerente.Revisar');

      Route::Post('/RendicionGastos/Gerente/aprobar', 'RendicionGastosController@aprobar')
        ->name('RendicionGastos.Gerente.Aprobar');

      Route::get('/RendicionGastos/Gerente/listar/', 'RendicionGastosController@listarDelGerente')
        ->name('RendicionGastos.Gerente.Listar');
    });
    Route::group(['middleware' => "ValidarSesionAdministracion"], function () {
      /* ADMINISTRACION */

      Route::get('/RendicionGastos/Administracion/listar/', 'RendicionGastosController@listarJefeAdmin')
        ->name('RendicionGastos.Administracion.Listar');

      Route::get('/RendicionGastos/{id}/Administracion/ver', 'RendicionGastosController@verAdmin')
        ->name('RendicionGastos.Administracion.Ver');
    });

    Route::group(['middleware' => "ValidarSesionContador"], function () {
      /* CONTADOR */

      Route::get('/RendicionGastos/{id}/Contador/verContabilizar/', 'RendicionGastosController@verContabilizar')
        ->name('RendicionGastos.Contador.verContabilizar');

      Route::get('/rendicion/contabilizar/{cad}', 'RendicionGastosController@contabilizar')
        ->name('RendicionGastos.Contador.Contabilizar');

      Route::get('/RendicionGastos/Contador/listar/', 'RendicionGastosController@listarContador')
        ->name('RendicionGastos.Contador.Listar');
    });


    Route::group(['middleware' => "ValidarSesionObservador"], function () {
      Route::get('/RendicionGastos/Observador/listar', 'RendicionGastosController@listarRendicionesParaObservador')->name('RendicionGastos.Observador.Listar');
      Route::get('/RendicionGastos/Observador/Ver/{codRendicion}', 'RendicionGastosController@VerRendicionComoObservador')->name('RendicionGastos.Observador.Ver');
    });



    //RUTA MAESTAR QUE REDIRIJE A LOS LISTADOS DE RENDICIONES DE LOS ACTORES EMP GER Y J.A
    Route::get('/RendicionGastos/MAESTRA/listar', 'RendicionGastosController@listarRendiciones')
      ->name('RendicionGastos.ListarRendiciones');







    /**PUEDE HACER EL EMPLEADO */

    Route::get('/GestiónUsuarios/misDatos', 'EmpleadoController@verMisDatos')->name('GestionUsuarios.verMisDatos');
    Route::get('/GestiónUsuarios/cambiarContraseña', 'EmpleadoController@cambiarContraseña')->name('GestionUsuarios.cambiarContraseña');
    Route::post('/ActualizarEstadoMenu', 'UserController@ActualizarEstadoMenu')->name('ActualizarEstadoMenu');



    Route::post('/GestiónUsuarios/updateContrasena', 'EmpleadoController@guardarContrasena')->name('GestionUsuarios.updateContrasena');
    Route::post('/GestiónUsuarios/updateDPersonales', 'EmpleadoController@guardarDPersonales')->name('GestionUsuarios.updateDPersonales');

    /* FUNCIONES PROPIAS DEL ADMINISTRADOR DEL SISTEMA */
    Route::group(['middleware' => "ValidarSesionAdminSistema"], function () {

      Route::get('/AdminPanel/Ver', 'AdminPanelController@VerPanel')->name('AdminPanel.VerPanel');
      Route::get('/AdminPanel/VerPhpInfo', 'AdminPanelController@VerPhpInfo')->name('AdminPanel.VerPhpInfo');


      /* *********************** MODULO DE JOBS ************************ */
      /* *********************** MODULO DE JOBS ************************ */
      /* *********************** MODULO DE JOBS ************************ */
      /* *********************** MODULO DE JOBS ************************ */
      /* *********************** MODULO DE JOBS ************************ */
      /* *********************** MODULO DE JOBS ************************ */
      /* *********************** MODULO DE JOBS ************************ */
      /* *********************** MODULO DE JOBS ************************ */
      /* *********************** MODULO DE JOBS ************************ */
      /* *********************** MODULO DE JOBS ************************ */
      /* *********************** MODULO DE JOBS ************************ */

      Route::get('/Jobs/Listar', 'JobsController@ListarJobs')->name('Jobs.Listar');
      Route::get('/Jobs/Crear', 'JobsController@Crear')->name('Jobs.Crear');
      Route::post('/Jobs/GuardarEditar', 'JobsController@GuardarEditar')->name('Jobs.GuardarEditar');
      Route::get('/Jobs/{codJob}/Editar', 'JobsController@Editar')->name('Jobs.Editar');

      Route::get('/Jobs/{codJob}/RunJob', 'JobsController@RunJob')->name('Jobs.RunJob');
      Route::get('/Jobs/{codJob}/UnRunJob', 'JobsController@UnRunJob')->name('Jobs.UnRunJob');


      Route::get('/Jobs/{codJob}/Eliminar', 'JobsController@Eliminar')->name('Jobs.Eliminar');

      /* *********************** MODULO DE MIGRACIONES ************************ */
      /* *********************** MODULO DE MIGRACIONES ************************ */
      /* *********************** MODULO DE MIGRACIONES ************************ */
      /* *********************** MODULO DE MIGRACIONES ************************ */
      /* *********************** MODULO DE MIGRACIONES ************************ */
      Route::get('/Migraciones/Listar', 'MigracionController@ListarMigraciones')->name('Migraciones.Listar');
      Route::get('/Migraciones/Inv_ListarMigraciones', 'MigracionController@Inv_ListarMigraciones')->name('Migraciones.Inv_Listar');


      /* Modulo de modificaciones de la bd */


      Route::get('/DB/GenerarBackup', 'OperacionesController@GenerarBackup');
      Route::get('/DB/CorrerMigraciones', 'MigracionController@CorrerMigraciones');

      Route::post('/testearPOST',     'OperacionesController@testearPOST')->name('TestearPost');




      Route::get('/TipoOperaciones/Listar', 'TipoOperacionController@listar')->name('TipoOperacion.Listar');

      Route::get('/Operaciones/Listar', 'OperacionesController@ListarOperaciones')->name('Operaciones.Listar');
      Route::get('/Operaciones/Eliminar/{codOperacion}', 'OperacionesController@EliminarOperacion')->name('Operaciones.EliminarOperacion');




      /* **************************** MODULO DE CONFIGURACIÓN DE PERIODOS ********************* */

      Route::get('/PeriodoDirector/Listar', 'PeriodoDirectorController@ListarPeriodos')->name('PeriodoDirector.Listar');
      Route::get('/PeriodoDirector/Inv_Listar', 'PeriodoDirectorController@Inv_ListarPeriodos')->name('PeriodoDirector.Inv_Listar');

      Route::get('/PeriodoDirector/GetFormInvocable/{codPeriodoDirector}', 'PeriodoDirectorController@GetFormInvocable')->name('PeriodoDirector.GetFormInvocable');

      Route::post('/PeriodoDirector/GuardarActualizar', 'PeriodoDirectorController@GuardarActualizar')->name('PeriodoDirector.GuardarActualizar');


      /* MODULO DE PARAMETROS DEL SISTEMA */


      Route::get('/ParametroSistema/Listar', 'ParametroSistemaController@listar')->name('ParametroSistema.Listar');

      Route::get('/ParametroSistema/Inv/TablaListar', 'ParametroSistemaController@inv_listado')->name('ParametroSistema.inv_listado');
      Route::get('/ParametroSistema/JSON/GetParametros', 'ParametroSistemaController@JSON_GetParametros')->name('ParametroSistema.JSON_GetParametros');

      Route::post('/ParametroSistema/guardarYActualizar', 'ParametroSistemaController@guardarYActualizar')->name('ParametroSistema.guardarYActualizar');
      Route::get('/ParametroSistema/darDeBaja/{codParametro}', 'ParametroSistemaController@darDeBaja')->name('ParametroSistema.darDeBaja');






      /* -----------------------------------------MODULO HISTORIAL DE ERRORES-------------------------- */

      //listar errores
      Route::get('/HistorialErrores', 'ErrorHistorialController@listarErrores')->name('HistorialErrores.Listar');
      Route::get('/HistorialErrores/{codError}/cambiarEstadoError', 'ErrorHistorialController@cambiarEstadoError')->name('HistorialErrores.cambiarEstadoError');
      Route::get('/HistorialErrores/ver/{id}', 'ErrorHistorialController@ver')->name('HistorialErrores.ver');
      Route::post('/HistorialErrores/guardarRazonSolucionError', 'ErrorHistorialController@guardarRazonSolucionError')->name('HistorialErrores.guardarRazonSolucionError');


      /* -----------------------------------------MODULO HISTORIAL DE LOGEOS-------------------------- */

      //listar logeos
      Route::get('/HistorialLogeos', 'LogeoHistorialController@listarLogeos')->name('HistorialLogeos.Listar');
      Route::post('/HistorialLogeos/getDataGrafico', 'LogeoHistorialController@getDataGrafico')->name('HistorialLogeos.getDataGrafico');





      /* Invocable */
      Route::get('/HistorialLogeos/OperacionesDeSesion/{codSesion}', 'LogeoHistorialController@inv_operacionesDeSesion')->name('HistorialLogeos.inv_operacionesDeSesion');


      /* ----------------------------------------------        MODULO GESTIÓN DE USUARIOS ---------------------------- */
      Route::get('/GestiónUsuarios/listar', 'EmpleadoController@listarEmpleados')->name('GestionUsuarios.Listar');

      Route::get('/GestiónUsuarios/crear', 'EmpleadoController@crearEmpleado')->name('GestionUsuarios.create');

      Route::post('/GestiónUsuarios/save', 'EmpleadoController@guardarCrearEmpleado')->name('GestionUsuarios.store');

      Route::get('/GestiónUsuarios/verProyectosContador/{codEmpleado}', 'EmpleadoController@verProyectosContador')->name('GestionUsuarios.verProyectosContador');
      Route::get('/GestiónUsuarios/verProyectosObservador/{codEmpleado}', 'EmpleadoController@verProyectosObservador')->name('GestionUsuarios.verProyectosObservador');


      Route::get('/GestiónUsuarios/{id}/editarUsuario', 'EmpleadoController@editarUsuario')->name('GestionUsuarios.editUsuario');
      Route::get('/GestiónUsuarios/{id}/editarEmpleado', 'EmpleadoController@editarEmpleado')->name('GestionUsuarios.editEmpleado');
      Route::post('/GestiónUsuarios/updateUsuario', 'EmpleadoController@guardarEditarUsuario')->name('GestionUsuarios.updateUsuario');
      Route::post('/GestiónUsuarios/updateEmpleado', 'EmpleadoController@guardarEditarEmpleado')->name('GestionUsuarios.updateEmpleado');

      Route::get('/GestiónUsuarios/{id}/cesar', 'EmpleadoController@cesarEmpleado')->name('GestionUsuarios.cesar');
      Route::get('/GestiónUsuarios/{id}/reactivar', 'EmpleadoController@reactivarEmpleado')->name('GestionUsuarios.reactivar');


      Route::get('/GestiónUsuarios/ActualizarSedeContador/{cadena}', 'EmpleadoController@cambiarSedeAContador')->name('GestionUsuarios.cambiarSedeAContador');






      /* ----------------------------------------------        MODULO PUESTOS           ------------------------------------------ */
      Route::get('/GestionPuestos/listar', 'PuestoController@listarPuestos')->name('GestionPuestos.Listar');

      Route::get('/GestionPuestos/crear', 'PuestoController@crearPuesto')->name('GestionPuestos.create');
      Route::post('/GestionPuestos/save', 'PuestoController@guardarCrearPuesto')->name('GestionPuestos.store');

      Route::get('/GestionPuestos/{id}/editar', 'PuestoController@editarPuesto')->name('GestionPuestos.edit');
      Route::post('/GestionPuestos/update', 'PuestoController@guardarEditarPuesto')->name('GestionPuestos.update');

      Route::get('/GestionPuestos/{id}/eliminar', 'PuestoController@eliminarPuesto')->name('GestionPuestos.delete');

      Route::get('/GestionPuestos/TogleEmpleadoPuesto', 'EmpleadoController@TogleEmpleadoPuesto')->name('GestionPuestos.TogleEmpleadoPuesto');





      /* ---------------------------------------------- MODULO UNIDAD DE MEDIDA -------------------------------------------- */
      Route::get('/GestiónUnidadMedida/listar', 'UnidadMedidaController@listarUnidades')->name('GestiónUnidadMedida.listar');

      Route::get('/GestiónUnidadMedida/crear', 'UnidadMedidaController@crearUnidad')->name('GestiónUnidadMedida.crear');
      Route::post('/GestiónUnidadMedida/store', 'UnidadMedidaController@store')->name('GestiónUnidadMedida.store');

      Route::get('/GestiónUnidadMedida/{id}/editar', 'UnidadMedidaController@editarUnidad')->name('GestiónUnidadMedida.editar');
      Route::post('/GestiónUnidadMedida/update', 'UnidadMedidaController@update')->name('GestiónUnidadMedida.update');

      Route::get('/GestiónUnidadMedida/{id}/eliminar', 'UnidadMedidaController@delete')->name('GestiónUnidadMedida.eliminar');


      /* CRUD OBJETIVOS ESTRATEGICOS */


      /* CRUD SEDE */

      Route::get('/Sede/listarSedes', 'SedeController@listarSedes')->name('Sede.ListarSedes');

      Route::post('/Sede/GuardarEditar', 'SedeController@GuardarEditar')->name('Sede.GuardarEditar');
    });




    /* ---------------------------------------------------------------------------------------------------------------- */
    /* ---------------------------------------------------------------------------------------------------------------- */
    /* ---------------------------------------------------------------------------------------------------------------- */
    /* ---------------------------------------------------------------------------------------------------------------- */
    /* ---------------------------------------------------------------------------------------------------------------- */
    /* ---------------------------------------------------------------------------------------------------------------- */
    /* ---------------------------------------------------------------------------------------------------------------- */
    /* ---------------------------------------------- MODULO PROYECTOS -------------------------------------------- */
    /* ---------------------------------------------------------------------------------------------------------------- */
    /* ---------------------------------------------------------------------------------------------------------------- */
    /* ---------------------------------------------------------------------------------------------------------------- */
    /* ---------------------------------------------------------------------------------------------------------------- */
    /* ---------------------------------------------------------------------------------------------------------------- */
    /* ---------------------------------------------------------------------------------------------------------------- */
    /* ---------------------------------------------------------------------------------------------------------------- */
    /* ---------------------------------------------------------------------------------------------------------------- */


    Route::get('/GestiónProyectos/getDashboardInfo', 'ProyectoController@getDashboardInfo')->name('GestiónProyectos.Gerente.getDashboardInfo');
    Route::get('/GestionProyectos/Dashboard', 'ProyectoController@VerDashboard')->name('GestionProyectos.VerDashboard');


    Route::group(['middleware' => "ValidarSesionGerenteOUGE"], function () {







      /* -------- PROYECTOS-> Archivos del proyecto */

      Route::get('/GestionProyectos/descargarArchivo/{codArchivoProyecto}', 'ProyectoController@descargarArchivo')->name('GestionProyectos.descargarArchivo');
      Route::post('/GestionProyectos/añadirArchivos/', 'ProyectoController@añadirArchivos')->name('GestionProyectos.añadirArchivos');

      //desde JS se ejecuta
      Route::get('/GestionProyectos/eliminarArchivo/{codArchivo}', 'ProyectoController@eliminarArchivo')->name('GestionProyectos.eliminarArchivo');
      Route::get('/GestionProyectos/PoblacionBeneficiaria/{id}/VerDetalle', 'PersonaPoblacionController@listar')->name('GestionProyectos.verPoblacionBeneficiaria');
    });







    Route::group(['middleware' => "ValidarSesionGerente"], function () {

      /* GERENTE */
      Route::get('/GestiónProyectos/Gerente/listar', 'ProyectoController@listarGerente')->name('GestiónProyectos.Gerente.Listar');
      Route::get('/GestionProyectos/Gerente/verProyecto/{id}', 'ProyectoController@editar')->name('GestionProyectos.Gerente.Ver');
    });




    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* ----------------------------------- MODULO REPOSICIONES ------------------------------ */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */




    /**RUTA MAESTRA PARA REPOSICION */
    Route::get('/indexReposicion', 'ReposicionGastosController@listarReposiciones')
      ->name('ReposicionGastos.Listar');
    /**RUTA MAESTRA PARA DESCARGAR CDP */
    Route::get('/reposicion/descargarCDP/{cadena}', 'ReposicionGastosController@descargarCDP')
      ->name('ReposicionGastos.descargarCDP');

    /* Esta se consume desde JS */
    Route::get('/ReposicionGastos/eliminarArchivo/{codArchivoRepo}', 'ReposicionGastosController@eliminarArchivo');


    /**EMPLEADO*/
    Route::get('/ReposicionGastos/Empleado/listar', 'ReposicionGastosController@listarOfEmpleado')
      ->name('ReposicionGastos.Empleado.Listar');

    Route::get('/ReposicionGastos/Empleado/ListarConFiltro', 'ReposicionGastosController@ListarConFiltroDeEmpleado')
      ->name('ReposicionGastos.Empleado.ListarConFiltro');



    Route::get('/ReposicionGastos/Empleado/crear', 'ReposicionGastosController@create')
      ->name('ReposicionGastos.Empleado.create');
    Route::post('/ReposicionGastos/Empleado/store', 'ReposicionGastosController@store')
      ->name('ReposicionGastos.Empleado.store');

    Route::post('/ReposicionGastos/Empleado/update', 'ReposicionGastosController@update')
      ->name('ReposicionGastos.Empleado.update');
    Route::get('/ReposicionGastos/{id}/Empleado/editar', 'ReposicionGastosController@editar')
      ->name('ReposicionGastos.Empleado.editar');

    Route::get('/ReposicionGastos/{id}/Empleado/view', 'ReposicionGastosController@view')
      ->name('ReposicionGastos.Empleado.ver');

    Route::get('/ReposicionGastos/Empleado/misGastos', 'ReposicionGastosController@verMisGastos')
      ->name('ReposicionGastos.Empleado.verMisGastos');

    Route::get('/ReposicionGastos/{codDetalle}/Empleado/marcarComoVisto', 'ReposicionGastosController@marcarDetalleComoVisto')
      ->name('ReposicionGastos.Empleado.marcarComoVisto');




    Route::group(['middleware' => "ValidarSesionGerente"], function () {
      /**GERENTE*/
      Route::get('/ReposicionGastos/Gerente/listar', 'ReposicionGastosController@listarOfGerente')
        ->name('ReposicionGastos.Gerente.Listar');
      Route::get('/ReposicionGastos/{id}/Gerente/view', 'ReposicionGastosController@viewGeren')
        ->name('ReposicionGastos.Gerente.ver');
      Route::Post('/ReposicionGastos/Gerente/Aprobar', 'ReposicionGastosController@aprobar')
        ->name('ReposicionGastos.Gerente.aprobar');

      Route::post('/ReposicionGastos/Gerente/Observar', 'ReposicionGastosController@observarComoGerente')->name('ReposicionGastos.Gerente.observar');
    });
    Route::group(['middleware' => "ValidarSesionAdministracion"], function () {

      /**ADMINISTRACION*/
      Route::get('/ReposicionGastos/Administracion/listar', 'ReposicionGastosController@listarOfJefe')->name('ReposicionGastos.Administracion.Listar');
      Route::get('/ReposicionGastos/{id}/Administracion/view', 'ReposicionGastosController@viewJefe')->name('ReposicionGastos.Administracion.ver');
      Route::get('/ReposicionGastos/{id}/Abonar', 'ReposicionGastosController@abonar')->name('ReposicionGastos.abonar');
      Route::post('/ReposicionGastos/Administrador/Observar', 'ReposicionGastosController@observarComoAdministrador')->name('ReposicionGastos.Administrador.observar');
    });
    Route::group(['middleware' => "ValidarSesionContador"], function () {


      Route::get('/ReposicionGastos/{id}/Contabilizar', 'ReposicionGastosController@contabilizar')
        ->name('ReposicionGastos.contabilizar'); //usa la ruta no el name

      /**CONTADOR*/
      Route::get('/ReposicionGastos/Contador/listar', 'ReposicionGastosController@listarOfConta')
        ->name('ReposicionGastos.Contador.Listar');
      Route::get('/ReposicionGastos/{id}/Contador/view', 'ReposicionGastosController@viewConta')
        ->name('ReposicionGastos.Contador.ver');
    });

    Route::group(['middleware' => "ValidarSesionObservador"], function () {
      Route::get('/ReposicionGastos/Observador/listar', 'ReposicionGastosController@listarReposicionesParaObservador')->name('ReposicionGastos.Observador.Listar');
      Route::get('/ReposicionGastos/Observador/Ver/{codRendicion}', 'ReposicionGastosController@VerReposicionComoObservador')->name('ReposicionGastos.Observador.Ver');
    });



    Route::get('/ReposicionGastos/{id}/Cancelar', 'ReposicionGastosController@cancelar')
      ->name('ReposicionGastos.cancelar');

    Route::get('/ReposicionGastos/{id}/Administrador/Rechazar', 'ReposicionGastosController@rechazarComoAdministrador')->name('ReposicionGastos.Administrador.rechazar');
    Route::get('/ReposicionGastos/{id}/Gerente/Rechazar', 'ReposicionGastosController@rechazarComoGerente')->name('ReposicionGastos.Gerente.rechazar');




    /**RUTA MAESTRA PARA DESCARGAR FORMULARIOS PDF */
    Route::get('/ReposicionGastos/{id}/PDF', 'ReposicionGastosController@descargarPDF')
      ->name('ReposicionGastos.exportarPDF');
    Route::get('/ReposicionGastos/{id}/verPDF', 'ReposicionGastosController@verPDF')
      ->name('ReposicionGastos.verPDF');





    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* --------------------------------MODULO REQUERIMIENTOS BS ----------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */

    /**RUTA MAESTRA PARA REPOSICION */
    Route::get('/indexRequerimiento', 'RequerimientoBSController@listarRequerimientos')->name('RequerimientoBS.Listar');

    /* EMPLEADO */
    Route::get('/RequerimientoBS/Empleado/listar', 'RequerimientoBSController@listarOfEmpleado')->name('RequerimientoBS.Empleado.Listar');

    Route::get('/RequerimientoBS/Empleado/crear', 'RequerimientoBSController@crear')->name('RequerimientoBS.Empleado.CrearRequerimientoBS');
    Route::post('/RequerimientoBS/Empleado/store', 'RequerimientoBSController@store')->name('RequerimientoBS.Empleado.store');

    Route::get('/RequerimientoBS/Empleado/{id}/ver', 'RequerimientoBSController@ver')->name('RequerimientoBS.Empleado.ver');

    Route::get('/RequerimientoBS/Empleado/{id}/editar', 'RequerimientoBSController@editar')->name('RequerimientoBS.Empleado.EditarRequerimientoBS');
    Route::post('/RequerimientoBS/Empleado/update', 'RequerimientoBSController@update')->name('RequerimientoBS.Empleado.update');


    Route::get('/RequerimientoBS/Empleado/{id}/editar', 'RequerimientoBSController@editar')->name('RequerimientoBS.Empleado.EditarRequerimientoBS');


    Route::post('/RequerimientoBS/Empleado/SubirFactura', 'RequerimientoBSController@empleado_subirFactura')->name('RequerimientoBS.Empleado.SubirFactura');

    Route::get('/RequerimientoBS/{id}/Empleado/marcarQueYaTieneFactura', 'RequerimientoBSController@empleado_marcarQueYaTieneFactura')->name('RequerimientoBS.Empleado.marcarQueYaTieneFactura');



    Route::get('/RequerimientoBS/descargarArchivoEmp/{id}', 'RequerimientoBSController@descargarArchivoEmp')->name('RequerimientoBS.descargarArchivoEmp');

    /* Esta se consume desde JS */
    Route::get('/RequerimientoBS/Empleado/eliminarArchivoEmp/{codArchivoReq}', 'RequerimientoBSController@eliminarArchivo');



    Route::get('/RequerimientoBS/descargarArchivoAdm/{id}', 'RequerimientoBSController@descargarArchivoAdm')->name('RequerimientoBS.descargarArchivoAdm');

    Route::get('/RequerimientoBS/verPDF/{id}', 'RequerimientoBSController@verPDF')->name('RequerimientoBS.verPDF');
    Route::get('/RequerimientoBS/descargarPDF/{id}', 'RequerimientoBSController@descargarPDF')->name('RequerimientoBS.descargarPDF');



    Route::group(['middleware' => "ValidarSesionGerente"], function () {
      Route::get('/RequerimientoBS/Gerente/listar', 'RequerimientoBSController@listarOfGerente')->name('RequerimientoBS.Gerente.Listar');
      Route::get('/RequerimientoBS/{id}/Gerente/view', 'RequerimientoBSController@viewGeren')->name('RequerimientoBS.Gerente.ver');
      Route::Post('/RequerimientoBS/Gerente/Aprobar', 'RequerimientoBSController@aprobar')->name('RequerimientoBS.Gerente.aprobar');
    });


    Route::group(['middleware' => "ValidarSesionAdministracion"], function () {


      Route::get('/RequerimientoBS/Administrador/listar', 'RequerimientoBSController@listarOfAdministrador')->name('RequerimientoBS.Administrador.Listar');

      Route::get('/RequerimientoBS/{id}/Administrador/VerAtender', 'RequerimientoBSController@VerAtender')->name('RequerimientoBS.Administrador.VerAtender');


      Route::get('/RequerimientoBS/{id}/Administrador/atender', 'RequerimientoBSController@atender')->name('RequerimientoBS.Administrador.Atender');

      Route::post('/RequerimientoBS/Administrador/subirArchivosAdministrador', 'RequerimientoBSController@subirArchivosAdministrador')
        ->name('RequerimientoBS.Administrador.subirArchivosAdministrador');


      Route::get('/RequerimientoBS/{id}/Administrador/eliminarArchivosAdmin', 'RequerimientoBSController@eliminarArchivosAdmin')
        ->name('RequerimientoBS.Administrador.eliminarArchivosAdmin');


      Route::get('/RequerimientoBS/{id}/Administrador/marcarQueYaTieneFactura', 'RequerimientoBSController@marcarQueYaTieneFactura')
        ->name('RequerimientoBS.Administrador.marcarQueYaTieneFactura');
    });


    Route::group(['middleware' => "ValidarSesionContador"], function () {
      Route::get('/RequerimientoBS/Contador/listar', 'RequerimientoBSController@listarOfConta')
        ->name('RequerimientoBS.Contador.Listar');

      Route::get('/RequerimientoBS/{id}/Contador/view', 'RequerimientoBSController@viewConta')
        ->name('RequerimientoBS.Contador.ver');

      Route::post('/RequerimientoBS/Contador/Contabilizar', 'RequerimientoBSController@contabilizar')
        ->name('RequerimientoBS.Contador.Contabilizar');


      Route::get('/RequerimientoBS/{id}/Contador/contabilizarFactura', 'RequerimientoBSController@contabilizarFactura')
        ->name('RequerimientoBS.Contador.contabilizarFactura');


      Route::get('/RequerimientoBS/Contador/eliminarArchivoDelEmpleado/{codArchivoEmp}', 'RequerimientoBSController@ContadorEliminarArchivoDelEmpleado');
    });

    Route::group(['middleware' => "ValidarSesionObservador"], function () {
      Route::get('/RequerimientoBS/Observador/listar', 'RequerimientoBSController@listarParaObservador')->name('RequerimientoBS.Observador.Listar');


      Route::get('/RequerimientoBS/Observador/Ver/{codRequerimiento}', 'RequerimientoBSController@VerRequerimientoComoObservador')->name('RequerimientoBS.Observador.Ver');
    });

    Route::get('/RequerimientoBS/{id}/Cancelar', 'RequerimientoBSController@cancelar')->name('RequerimientoBS.cancelar');

    Route::get('/RequerimientoBS/{id}/Administrador/Rechazar', 'RequerimientoBSController@rechazarComoAdministrador')->name('RequerimientoBS.Administrador.rechazar');
    Route::get('/RequerimientoBS/{id}/Gerente/Rechazar', 'RequerimientoBSController@rechazarComoGerente')->name('RequerimientoBS.Gerente.rechazar');


    Route::post('/RequerimientoBS/Gerente/Observar', 'RequerimientoBSController@observarComoGerente')->name('RequerimientoBS.Gerente.observar');
    Route::post('/RequerimientoBS/Administracion/Observar', 'RequerimientoBSController@observarComoAdministrador')->name('RequerimientoBS.Administracion.observar');

    /**RUTA MAESTRA PARA DESCARGAR FORMULARIOS PDF */
    Route::get('/RequerimientoBS/{id}/PDF', 'RequerimientoBSController@descargarPDF')
      ->name('RequerimientoBS.exportarPDF');
    Route::get('/RequerimientoBS/{id}/verPDF', 'RequerimientoBSController@verPDF')
      ->name('RequerimientoBS.verPDF');



    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* --------------------------------MODULO DJ GASTOS MOVILIDAD---------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */


    Route::get('/DJ/GastosMovilidad', 'DJGastosMovilidadController@listarDeEmpleado')
      ->name('DJMovilidad.Empleado.Listar');

    Route::get('/DJ/GastosMovilidad/Crear', 'DJGastosMovilidadController@crearDJMov')
      ->name('DJMovilidad.Empleado.Crear');

    Route::post('/DJ/GastosMovilidad/Guardar', 'DJGastosMovilidadController@Guardar')
      ->name('DJMovilidad.Empleado.Guardar');

    Route::get('/DJ/GastosMovilidad/{codDJ}/descargarPDF', 'DJGastosMovilidadController@descargarPDF')
      ->name('DJMovilidad.Empleado.descargarPDF');

    Route::get('/DJ/GastosMovilidad/{codDJ}/verPDF', 'DJGastosMovilidadController@verPDF')
      ->name('DJMovilidad.Empleado.verPDF');

    Route::get('/DJ/GastosMovilidad/{codDJ}/ver', 'DJGastosMovilidadController@ver')
      ->name('DJMovilidad.Empleado.ver');



    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* --------------------------------  MODULO DJ GASTOS VARIOS ---------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */


    Route::get('/DJ/GastosVarios', 'DJGastosVariosController@listarDeEmpleado')
      ->name('DJVarios.Empleado.Listar');

    Route::get('/DJ/GastosVarios/Crear', 'DJGastosVariosController@crearDJVar')
      ->name('DJVarios.Empleado.Crear');

    Route::post('/DJ/GastosVarios/store', 'DJGastosVariosController@store')
      ->name('DJVarios.Empleado.Guardar');

    Route::get('/DJ/GastosVarios/{codDJ}/descargarPDF', 'DJGastosVariosController@descargarPDF')
      ->name('DJVarios.Empleado.descargarPDF');

    Route::get('/DJ/GastosVarios/{codDJ}/verPDF', 'DJGastosVariosController@verPDF')
      ->name('DJVarios.Empleado.verPDF');

    Route::get('/DJ/GastosVarios/{codDJ}/ver', 'DJGastosVariosController@ver')
      ->name('DJVarios.Empleado.ver');




    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* --------------------------------  MODULO DJ GASTOS VIATICOS -------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */


    Route::get('/DJ/GastosViaticos', 'DJGastosViaticosController@listarDeEmpleado')
      ->name('DJViaticos.Empleado.Listar');

    Route::get('/DJ/GastosViaticos/Crear', 'DJGastosViaticosController@crearDJVia')
      ->name('DJViaticos.Empleado.Crear');

    Route::post('/DJ/GastosViaticos/store', 'DJGastosViaticosController@Guardar')
      ->name('DJViaticos.Empleado.Guardar');

    Route::get('/DJ/GastosViaticos/{codDJ}/descargarPDF', 'DJGastosViaticosController@descargarPDF')
      ->name('DJViaticos.Empleado.descargarPDF');

    Route::get('/DJ/GastosViaticos/{codDJ}/verPDF', 'DJGastosViaticosController@verPDF')
      ->name('DJViaticos.Empleado.verPDF');

    Route::get('/DJ/GastosViaticos/{codDJ}/ver', 'DJGastosViaticosController@ver')
      ->name('DJViaticos.Empleado.ver');



    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* --------------------------------MODULO CONTRATOS      -------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */

    Route::group(['middleware' => "ValidarSesionAdministracion"], function () {
      Route::get('/ContratosPlazo/Listar', 'ContratoPlazoController@listar')->name('ContratosPlazo.Listar');
      Route::get('/ContratosPlazo/Crear', 'ContratoPlazoController@Crear')->name('ContratosPlazo.Crear');
      Route::get('/ContratosPlazo/Editar/{codContrato}', 'ContratoPlazoController@Editar')->name('ContratosPlazo.Editar');

      Route::post('/ContratosPlazo/Guardar', 'ContratoPlazoController@Guardar')->name('ContratosPlazo.Guardar');
      Route::post('/ContratosPlazo/Actualizar', 'ContratoPlazoController@Actualizar')->name('ContratosPlazo.Actualizar');


      Route::post('/ContratosPlazo/GenerarBorrador', 'ContratoPlazoController@GenerarBorrador')->name('ContratosPlazo.GenerarBorrador');
      Route::get('/Contratos/Borradores/Ver/{filename}', 'ContratoPlazoController@VerBorrador')->name('ContratosPlazo.VerBorrador');


      Route::get('/ContratosPlazo/descargarPDF/{codContrato}', 'ContratoPlazoController@descargarPDF')->name('ContratosPlazo.descargarPDF');
      Route::get('/ContratosPlazo/verPDF/{codContrato}', 'ContratoPlazoController@verPDF')->name('ContratosPlazo.verPDF');

      Route::get('/ContratosPlazo/Ver/{codContrato}', 'ContratoPlazoController@Ver')->name('ContratosPlazo.Ver');

      Route::get('/ContratosPlazo/Anular/{codContrato}', 'ContratoPlazoController@Anular')->name('ContratosPlazo.Anular');



      Route::get('/ContratosLocacion/Listar', 'ContratoLocacionController@listar')->name('ContratosLocacion.Listar');
      Route::get('/ContratosLocacion/Crear', 'ContratoLocacionController@Crear')->name('ContratosLocacion.Crear');
      Route::post('/ContratosLocacion/Guardar', 'ContratoLocacionController@Guardar')->name('ContratosLocacion.Guardar');

      Route::get('/ContratosLocacion/Editar/{codContrato}', 'ContratoLocacionController@Editar')->name('ContratosLocacion.Editar');
      Route::post('/ContratosLocacion/Actualizar', 'ContratoLocacionController@Actualizar')->name('ContratosLocacion.Actualizar');


      Route::post('/ContratosLocacion/GenerarBorrador', 'ContratoLocacionController@GenerarBorrador')->name('ContratosLocacion.GenerarBorrador');

      Route::get('/ContratosLocacion/descargarPDF/{codContrato}', 'ContratoLocacionController@descargarPDF')->name('ContratosLocacion.descargarPDF');
      Route::get('/ContratosLocacion/verPDF/{codContrato}', 'ContratoLocacionController@verPDF')->name('ContratosLocacion.verPDF');
      Route::get('/ContratosLocacion/Ver/{codContrato}', 'ContratoLocacionController@Ver')->name('ContratosLocacion.Ver');

      Route::get('/ContratosLocacion/Anular/{codContrato}', 'ContratoLocacionController@Anular')->name('ContratosLocacion.Anular');

      /* *************************+ CONTRATOS NUEVO ********************************++ */

      Route::get('/ContratosPlazoNuevo/Listar', 'ContratoPlazoNuevoController@listar')->name('ContratosPlazoNuevo.Listar');
      Route::get('/ContratosPlazoNuevo/Crear', 'ContratoPlazoNuevoController@Crear')->name('ContratosPlazoNuevo.Crear');
      Route::get('/ContratosPlazoNuevo/Editar/{codContratoPlazo}', 'ContratoPlazoNuevoController@Editar')->name('ContratosPlazoNuevo.Editar');

      Route::post('/ContratosPlazoNuevo/Guardar', 'ContratoPlazoNuevoController@Guardar')->name('ContratosPlazoNuevo.Guardar');
      Route::post('/ContratosPlazoNuevo/Actualizar', 'ContratoPlazoNuevoController@Actualizar')->name('ContratosPlazoNuevo.Actualizar');

      Route::post('/ContratosPlazoNuevo/GenerarBorrador', 'ContratoPlazoNuevoController@GenerarBorrador')->name('ContratosPlazoNuevo.GenerarBorrador');

      Route::get('/ContratosPlazoNuevo/descargarPDF/{codContrato}', 'ContratoPlazoNuevoController@descargarPDF')->name('ContratosPlazoNuevo.descargarPDF');
      Route::get('/ContratosPlazoNuevo/verPDF/{codContrato}', 'ContratoPlazoNuevoController@verPDF')->name('ContratosPlazoNuevo.verPDF');

      Route::get('/ContratosPlazoNuevo/Ver/{codContrato}', 'ContratoPlazoNuevoController@Ver')->name('ContratosPlazoNuevo.Ver');

      Route::get('/ContratosPlazoNuevo/Anular/{codContrato}', 'ContratoPlazoNuevoController@Anular')->name('ContratosPlazoNuevo.Anular');
    });


    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* --------------------------------MODULO ORDEN DE COMPRA-------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */



    Route::get('/OrdenCompra', 'OrdenCompraController@listarDeEmpleado')
      ->name('OrdenCompra.Empleado.Listar');

    Route::get('/OrdenCompra/{id}/Ver', 'OrdenCompraController@verOrdenCompra')
      ->name('OrdenCompra.Empleado.Ver');


    //PDF PARA ORDEN DE COMPRA
    Route::get('/OrdenCompra/{id}/descargar', 'OrdenCompraController@descargarPDF')
      ->name('OrdenCompra.descargarPDF');
    Route::get('/OrdenCompra/{id}/verPDF', 'OrdenCompraController@verPDF')
      ->name('OrdenCompra.verPDF');


    Route::get('/OrdenCompra/descargarArchivo/{id}', 'OrdenCompraController@descargarArchivo')
      ->name('OrdenCompra.descargarArchivo');






    Route::group(['middleware' => "ValidarSesionAdministracionOContador"], function () {


      Route::get('/OrdenCompra/Crear', 'OrdenCompraController@crearOrdenCompra')
        ->name('OrdenCompra.Empleado.Crear');

      Route::post('/OrdenCompra/store', 'OrdenCompraController@Guardar')
        ->name('OrdenCompra.Empleado.Guardar');

      Route::get('/OrdenCompra/{id}/Editar', 'OrdenCompraController@editarOrdenCompra')
        ->name('OrdenCompra.Empleado.Editar');

      Route::post('/OrdenCompra/update', 'OrdenCompraController@Update')
        ->name('OrdenCompra.Empleado.Update');


      Route::get('/OrdenCompra/eliminarArchivo/{id}', 'OrdenCompraController@eliminarArchivo')
        ->name('OrdenCompra.eliminarArchivo');
    });


    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* --------------------------------MODULO BUSCADOR MAESTRO ------------------------------ */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */

    Route::group(['middleware' => "ValidarSesionAdministracion"], function () {

      Route::get('/BuscadorMaestro', 'OperacionesController@buscadorMaestro')->name('BuscadorMaestro');

      Route::get('/BuscadorMaestro/CambiarEstadoDocumento', 'OperacionesController@CambiarEstadoDocumento')->name('BuscadorMaestro.CambiarEstadoDocumento');
      Route::get('/BuscadorMaestro/REQ_CambiarTieneFactura', 'OperacionesController@REQ_CambiarTieneFactura')->name('BuscadorMaestro.REQ_CambiarTieneFactura');
      Route::get('/BuscadorMaestro/REQ_CambiarFacturaContabilizada', 'OperacionesController@REQ_CambiarFacturaContabilizada')->name('BuscadorMaestro.REQ_CambiarFacturaContabilizada');
      Route::get('/BuscadorMaestro/REQ_BorrarArchivosAdministrador', 'OperacionesController@REQ_BorrarArchivosAdministrador')->name('BuscadorMaestro.REQ_BorrarArchivosAdministrador');




      Route::get('/BuscadorMaestro/Invocables/GetListadoBusqueda', 'OperacionesController@GetListadoBusqueda')
        ->name('GetListadoBusqueda');
    });






    /* Notificaciones */
    Route::get('/Notificacion/MarcarComoVista/{codNotificacion}', 'Notificacion\NotificacionController@MarcarComoVista')->name('Notificacion.MarcarComoVista');
  }); //fin de middleware validar sesion








  Route::get("/Crons/EliminarArchivosBorradorInnecesarios", 'ContratoPlazoController@EliminarArchivosBorradorInnecesarios');
});
