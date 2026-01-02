<?php

namespace App\Routers;

use App\Http\Controllers\RequerimientoBSController;
use App\Models\ModuleRouterInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class RouterRequerimientoBs implements ModuleRouterInterface
{
  public static function RegisterRoutes()
  {
    Route::get('/listarDetallesDeRequerimiento/{id}', [RequerimientoBSController::class, 'listarDetalles']);


    /**RUTA MAESTRA PARA REPOSICION */
    Route::get('/indexRequerimiento', [RequerimientoBSController::class, 'listarRequerimientos'])->name('RequerimientoBS.Listar');

    /* EMPLEADO */
    Route::get('/RequerimientoBS/Empleado/listar', [RequerimientoBSController::class, 'listarOfEmpleado'])->name('RequerimientoBS.Empleado.Listar');

    Route::get('/RequerimientoBS/Empleado/crear', [RequerimientoBSController::class, 'crear'])->name('RequerimientoBS.Empleado.CrearRequerimientoBS');
    Route::post('/RequerimientoBS/Empleado/store', [RequerimientoBSController::class, 'store'])->name('RequerimientoBS.Empleado.store');

    Route::get('/RequerimientoBS/Empleado/{id}/ver', [RequerimientoBSController::class, 'ver'])->name('RequerimientoBS.Empleado.ver');

    Route::get('/RequerimientoBS/Empleado/{id}/editar', [RequerimientoBSController::class, 'editar'])->name('RequerimientoBS.Empleado.EditarRequerimientoBS');
    Route::post('/RequerimientoBS/Empleado/update', [RequerimientoBSController::class, 'update'])->name('RequerimientoBS.Empleado.update');


    Route::get('/RequerimientoBS/Empleado/{id}/editar', [RequerimientoBSController::class, 'editar'])->name('RequerimientoBS.Empleado.EditarRequerimientoBS');


    Route::post('/RequerimientoBS/Empleado/SubirFactura', [RequerimientoBSController::class, 'empleado_subirFactura'])->name('RequerimientoBS.Empleado.SubirFactura');

    Route::get('/RequerimientoBS/{id}/Empleado/marcarQueYaTieneFactura', [RequerimientoBSController::class, 'empleado_marcarQueYaTieneFactura'])->name('RequerimientoBS.Empleado.marcarQueYaTieneFactura');



    Route::get('/RequerimientoBS/descargarArchivoEmp/{id}', [RequerimientoBSController::class, 'descargarArchivoEmp'])->name('RequerimientoBS.descargarArchivoEmp');

    /* Esta se consume desde JS */
    Route::get('/RequerimientoBS/Empleado/eliminarArchivoEmp/{codArchivoReq}', [RequerimientoBSController::class, 'eliminarArchivo']);



    Route::get('/RequerimientoBS/descargarArchivoAdm/{id}', [RequerimientoBSController::class, 'descargarArchivoAdm'])->name('RequerimientoBS.descargarArchivoAdm');

    Route::get('/RequerimientoBS/verPDF/{id}', [RequerimientoBSController::class, 'verPDF'])->name('RequerimientoBS.verPDF');
    Route::get('/RequerimientoBS/descargarPDF/{id}', [RequerimientoBSController::class, 'descargarPDF'])->name('RequerimientoBS.descargarPDF');



    Route::group(['middleware' => "ValidarSesionGerente"], function () {
      Route::get('/RequerimientoBS/Gerente/listar', [RequerimientoBSController::class, 'listarOfGerente'])->name('RequerimientoBS.Gerente.Listar');
      Route::get('/RequerimientoBS/{id}/Gerente/view', [RequerimientoBSController::class, 'viewGeren'])->name('RequerimientoBS.Gerente.ver');
      Route::Post('/RequerimientoBS/Gerente/Aprobar', [RequerimientoBSController::class, 'aprobar'])->name('RequerimientoBS.Gerente.aprobar');
    });


    Route::group(['middleware' => "ValidarSesionAdministracion"], function () {


      Route::get('/RequerimientoBS/Administrador/listar', [RequerimientoBSController::class, 'listarOfAdministrador'])->name('RequerimientoBS.Administrador.Listar');

      Route::get('/RequerimientoBS/{id}/Administrador/VerAtender', [RequerimientoBSController::class, 'VerAtender'])->name('RequerimientoBS.Administrador.VerAtender');


      Route::get('/RequerimientoBS/{id}/Administrador/atender', [RequerimientoBSController::class, 'atender'])->name('RequerimientoBS.Administrador.Atender');

      Route::post('/RequerimientoBS/Administrador/subirArchivosAdministrador', [RequerimientoBSController::class, 'subirArchivosAdministrador'])
        ->name('RequerimientoBS.Administrador.subirArchivosAdministrador');


      Route::get('/RequerimientoBS/{id}/Administrador/eliminarArchivosAdmin', [RequerimientoBSController::class, 'eliminarArchivosAdmin'])
        ->name('RequerimientoBS.Administrador.eliminarArchivosAdmin');


      Route::get('/RequerimientoBS/{id}/Administrador/marcarQueYaTieneFactura', [RequerimientoBSController::class, 'marcarQueYaTieneFactura'])
        ->name('RequerimientoBS.Administrador.marcarQueYaTieneFactura');
    });


    Route::group(['middleware' => "ValidarSesionContador"], function () {
      Route::get('/RequerimientoBS/Contador/listar', [RequerimientoBSController::class, 'listarOfConta'])
        ->name('RequerimientoBS.Contador.Listar');

      Route::get('/RequerimientoBS/{id}/Contador/view', [RequerimientoBSController::class, 'viewConta'])
        ->name('RequerimientoBS.Contador.ver');

      Route::post('/RequerimientoBS/Contador/Contabilizar', [RequerimientoBSController::class, 'contabilizar'])
        ->name('RequerimientoBS.Contador.Contabilizar');


      Route::get('/RequerimientoBS/{id}/Contador/contabilizarFactura', [RequerimientoBSController::class, 'contabilizarFactura'])
        ->name('RequerimientoBS.Contador.contabilizarFactura');


      Route::get('/RequerimientoBS/Contador/eliminarArchivoDelEmpleado/{codArchivoEmp}', [RequerimientoBSController::class, 'ContadorEliminarArchivoDelEmpleado']);
    });

    Route::group(['middleware' => "ValidarSesionObservador"], function () {
      Route::get('/RequerimientoBS/Observador/listar', [RequerimientoBSController::class, 'listarParaObservador'])->name('RequerimientoBS.Observador.Listar');


      Route::get('/RequerimientoBS/Observador/Ver/{codRequerimiento}', [RequerimientoBSController::class, 'VerRequerimientoComoObservador'])->name('RequerimientoBS.Observador.Ver');
    });

    Route::get('/RequerimientoBS/{id}/Cancelar', [RequerimientoBSController::class, 'cancelar'])->name('RequerimientoBS.cancelar');

    Route::get('/RequerimientoBS/{id}/Administrador/Rechazar', [RequerimientoBSController::class, 'rechazarComoAdministrador'])->name('RequerimientoBS.Administrador.rechazar');
    Route::get('/RequerimientoBS/{id}/Gerente/Rechazar', [RequerimientoBSController::class, 'rechazarComoGerente'])->name('RequerimientoBS.Gerente.rechazar');


    Route::post('/RequerimientoBS/Gerente/Observar', [RequerimientoBSController::class, 'observarComoGerente'])->name('RequerimientoBS.Gerente.observar');
    Route::post('/RequerimientoBS/Administracion/Observar', [RequerimientoBSController::class, 'observarComoAdministrador'])->name('RequerimientoBS.Administracion.observar');

    /**RUTA MAESTRA PARA DESCARGAR FORMULARIOS PDF */
    Route::get('/RequerimientoBS/{id}/PDF', [RequerimientoBSController::class, 'descargarPDF'])
      ->name('RequerimientoBS.exportarPDF');
    Route::get('/RequerimientoBS/{id}/verPDF', [RequerimientoBSController::class, 'verPDF'])
      ->name('RequerimientoBS.verPDF');
  }
}
