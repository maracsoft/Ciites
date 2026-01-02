<?php

namespace App\Routers;

use App\Http\Controllers\ReposicionGastosController;
use App\Models\ModuleRouterInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class RouterReposicionGastos implements ModuleRouterInterface
{

  public static function RegisterRoutes()
  {
    Route::get('/listarDetallesDeReposicion/{id}', [ReposicionGastosController::class, 'listarDetalles']);
    Route::get('/reposicionGastos/getNumeracionActual/', [ReposicionGastosController::class, 'getNumeracionLibre']);



    /**RUTA MAESTRA PARA REPOSICION */
    Route::get('/indexReposicion', [ReposicionGastosController::class, 'listarReposiciones'])
      ->name('ReposicionGastos.Listar');
    /**RUTA MAESTRA PARA DESCARGAR CDP */
    Route::get('/reposicion/descargarCDP/{cadena}', [ReposicionGastosController::class, 'descargarCDP'])
      ->name('ReposicionGastos.descargarCDP');

    /* Esta se consume desde JS */
    Route::get('/ReposicionGastos/eliminarArchivo/{codArchivoRepo}', [ReposicionGastosController::class, 'eliminarArchivo']);


    /**EMPLEADO*/
    Route::get('/ReposicionGastos/Empleado/listar', [ReposicionGastosController::class, 'listarOfEmpleado'])
      ->name('ReposicionGastos.Empleado.Listar');

    Route::get('/ReposicionGastos/Empleado/ListarConFiltro', [ReposicionGastosController::class, 'ListarConFiltroDeEmpleado'])
      ->name('ReposicionGastos.Empleado.ListarConFiltro');



    Route::get('/ReposicionGastos/Empleado/crear', [ReposicionGastosController::class, 'create'])
      ->name('ReposicionGastos.Empleado.create');
    Route::post('/ReposicionGastos/Empleado/store', [ReposicionGastosController::class, 'store'])
      ->name('ReposicionGastos.Empleado.store');

    Route::post('/ReposicionGastos/Empleado/update', [ReposicionGastosController::class, 'update'])
      ->name('ReposicionGastos.Empleado.update');
    Route::get('/ReposicionGastos/{id}/Empleado/editar', [ReposicionGastosController::class, 'editar'])
      ->name('ReposicionGastos.Empleado.editar');

    Route::get('/ReposicionGastos/{id}/Empleado/view', [ReposicionGastosController::class, 'view'])
      ->name('ReposicionGastos.Empleado.ver');

    Route::get('/ReposicionGastos/Empleado/misGastos', [ReposicionGastosController::class, 'verMisGastos'])
      ->name('ReposicionGastos.Empleado.verMisGastos');

    Route::get('/ReposicionGastos/{codDetalle}/Empleado/marcarComoVisto', [ReposicionGastosController::class, 'marcarDetalleComoVisto'])
      ->name('ReposicionGastos.Empleado.marcarComoVisto');




    Route::group(['middleware' => "ValidarSesionGerente"], function () {
      /**GERENTE*/
      Route::get('/ReposicionGastos/Gerente/listar', [ReposicionGastosController::class, 'listarOfGerente'])
        ->name('ReposicionGastos.Gerente.Listar');
      Route::get('/ReposicionGastos/{id}/Gerente/view', [ReposicionGastosController::class, 'viewGeren'])
        ->name('ReposicionGastos.Gerente.ver');
      Route::Post('/ReposicionGastos/Gerente/Aprobar', [ReposicionGastosController::class, 'aprobar'])
        ->name('ReposicionGastos.Gerente.aprobar');

      Route::post('/ReposicionGastos/Gerente/Observar', [ReposicionGastosController::class, 'observarComoGerente'])->name('ReposicionGastos.Gerente.observar');
    });
    Route::group(['middleware' => "ValidarSesionAdministracion"], function () {

      /**ADMINISTRACION*/
      Route::get('/ReposicionGastos/Administracion/listar', [ReposicionGastosController::class, 'listarOfJefe'])->name('ReposicionGastos.Administracion.Listar');
      Route::get('/ReposicionGastos/{id}/Administracion/view', [ReposicionGastosController::class, 'viewJefe'])->name('ReposicionGastos.Administracion.ver');
      Route::get('/ReposicionGastos/{id}/Abonar', [ReposicionGastosController::class, 'abonar'])->name('ReposicionGastos.abonar');
      Route::post('/ReposicionGastos/Administrador/Observar', [ReposicionGastosController::class, 'observarComoAdministrador'])->name('ReposicionGastos.Administrador.observar');
    });
    Route::group(['middleware' => "ValidarSesionContador"], function () {


      Route::get('/ReposicionGastos/{id}/Contabilizar', [ReposicionGastosController::class, 'contabilizar'])
        ->name('ReposicionGastos.contabilizar'); //usa la ruta no el name

      /**CONTADOR*/
      Route::get('/ReposicionGastos/Contador/listar', [ReposicionGastosController::class, 'listarOfConta'])
        ->name('ReposicionGastos.Contador.Listar');
      Route::get('/ReposicionGastos/{id}/Contador/view', [ReposicionGastosController::class, 'viewConta'])
        ->name('ReposicionGastos.Contador.ver');
    });

    Route::group(['middleware' => "ValidarSesionObservador"], function () {
      Route::get('/ReposicionGastos/Observador/listar', [ReposicionGastosController::class, 'listarReposicionesParaObservador'])->name('ReposicionGastos.Observador.Listar');
      Route::get('/ReposicionGastos/Observador/Ver/{codRendicion}', [ReposicionGastosController::class, 'VerReposicionComoObservador'])->name('ReposicionGastos.Observador.Ver');
    });



    Route::get('/ReposicionGastos/{id}/Cancelar', [ReposicionGastosController::class, 'cancelar'])
      ->name('ReposicionGastos.cancelar');

    Route::get('/ReposicionGastos/{id}/Administrador/Rechazar', [ReposicionGastosController::class, 'rechazarComoAdministrador'])->name('ReposicionGastos.Administrador.rechazar');
    Route::get('/ReposicionGastos/{id}/Gerente/Rechazar', [ReposicionGastosController::class, 'rechazarComoGerente'])->name('ReposicionGastos.Gerente.rechazar');




    /**RUTA MAESTRA PARA DESCARGAR FORMULARIOS PDF */
    Route::get('/ReposicionGastos/{id}/PDF', [ReposicionGastosController::class, 'descargarPDF'])
      ->name('ReposicionGastos.exportarPDF');
    Route::get('/ReposicionGastos/{id}/verPDF', [ReposicionGastosController::class, 'verPDF'])
      ->name('ReposicionGastos.verPDF');
  }
}
