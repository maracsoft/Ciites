<?php

use App\Routers\RouterAdminSistema;
use App\Routers\RouterConstanciaDeposito;
use App\Routers\RouterContratos;
use App\Routers\RouterDeclaracionJurada;
use App\Routers\RouterOrdenCompra;
use App\Routers\RouterRendicionGastos;
use App\Routers\RouterReposicionGastos;
use App\Routers\RouterRequerimientoBs;
use App\Routers\RouterSolicitudFondos;
use App\Routers\RouterViajes;
use Illuminate\Support\Facades\Route;



Route::get('/PaginaEnMantenimiento/', 'UserController@paginaEnMantenimiento')->name('mantenimiento');

Route::group(['middleware' => "Mantenimiento"], function () {

  RouterConstanciaDeposito::RegisterRoutes();
  RouterViajes::RegisterRoutes();
  RouterSolicitudFondos::RegisterRoutes();
  RouterRendicionGastos::RegisterRoutes();
  RouterReposicionGastos::RegisterRoutes();
  RouterRequerimientoBs::RegisterRoutes();
  RouterOrdenCompra::RegisterRoutes();
  RouterDeclaracionJurada::RegisterRoutes();
  RouterContratos::RegisterRoutes();
  RouterAdminSistema::RegisterRoutes();

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




  Route::get('/listarDetallesDeOrdenCompra/{id}', 'OrdenCompraController@listarDetalles');

  Route::get('/obtenerCodigoPresupuestalDeProyecto/{id}', 'ProyectoController@getCodigoPresupuestal');

  Route::get('/listarProvinciasDeDepartamento/{id}', 'ProyectoController@listarProvinciasDeDepartamento');
  Route::get('/listarDistritosDeProvincia/{id}', 'ProyectoController@listarDistritosDeProvincia');



  Route::get('/ConsultarAPISunat/ruc/{ruc}', 'PersonaPoblacionController@ConsultarAPISunatRUC');
  Route::get('/ConsultarAPISunat/dni/{dni}', 'PersonaPoblacionController@ConsultarAPISunatDNI');







  /* ESTE MIDDLEWARE VALIDA SI ES QUE ESTÁS LOGEADO, SI NO, TE MANDA AL LOGIN */
  Route::group(['middleware' => "ValidarSesion"], function () {


    /**PUEDE HACER EL EMPLEADO */

    Route::get('/GestionUsuarios/misDatos', 'EmpleadoController@verMisDatos')->name('GestionUsuarios.verMisDatos');
    Route::get('/GestionUsuarios/cambiarContraseña', 'EmpleadoController@cambiarContraseña')->name('GestionUsuarios.cambiarContraseña');
    Route::post('/ActualizarEstadoMenu', 'UserController@ActualizarEstadoMenu')->name('ActualizarEstadoMenu');



    Route::post('/GestionUsuarios/updateContrasena', 'EmpleadoController@guardarContrasena')->name('GestionUsuarios.updateContrasena');
    Route::post('/GestionUsuarios/updateDPersonales', 'EmpleadoController@guardarDPersonales')->name('GestionUsuarios.updateDPersonales');






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





























    /* Notificaciones */
    Route::get('/Notificacion/MarcarComoVista/{codNotificacion}', 'Notificacion\NotificacionController@MarcarComoVista')->name('Notificacion.MarcarComoVista');
  }); //fin de middleware validar sesion








  Route::get("/Crons/EliminarArchivosBorradorInnecesarios", 'ContratoPlazoController@EliminarArchivosBorradorInnecesarios');
});
