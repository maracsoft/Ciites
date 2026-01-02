<?php

namespace App\Routers;

use App\Models\ModuleRouterInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class RouterSolicitudFondos implements ModuleRouterInterface
{

  public static function RegisterRoutes()
  {


    Route::get('/listarDetallesDeSolicitud/{id}', 'SolicitudFondosController@listarDetalles');
    Route::get('/solicitudFondos/getNumeracionActual/', 'SolicitudFondosController@getNumeracionLibre');


    Route::group(['middleware' => "ValidarSesion"], function () {






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
    });
  }
}
