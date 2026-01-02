<?php

namespace App\Routers;

use App\Models\ModuleRouterInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class RouterRendicionGastos implements ModuleRouterInterface
{

  public static function RegisterRoutes()
  {
    Route::get('/listarDetallesDeRendicion/{id}', 'RendicionGastosController@listarDetalles');
    Route::get('/rendicionGastos/getNumeracionActual/', 'RendicionGastosController@getNumeracionLibre');




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
  }
}
