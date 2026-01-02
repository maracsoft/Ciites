<?php

namespace App\Routers;

use App\Models\ModuleRouterInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class RouterReposicionGastos implements ModuleRouterInterface
{

  public static function RegisterRoutes()
  {
    Route::get('/listarDetallesDeReposicion/{id}', 'ReposicionGastosController@listarDetalles');
    Route::get('/reposicionGastos/getNumeracionActual/', 'ReposicionGastosController@getNumeracionLibre');



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
  }
}
