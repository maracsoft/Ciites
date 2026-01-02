<?php

namespace App\Routers;

use App\Models\ModuleRouterInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class RouterRequerimientoBs implements ModuleRouterInterface
{
  public static function RegisterRoutes()
  {
    Route::get('/listarDetallesDeRequerimiento/{id}', 'RequerimientoBSController@listarDetalles');


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
  }
}
