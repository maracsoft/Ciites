<?php

namespace App\Routers;

use App\Http\Controllers\RendicionGastosController;
use App\Models\ModuleRouterInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class RouterRendicionGastos implements ModuleRouterInterface
{

  public static function RegisterRoutes()
  {
    Route::get('/listarDetallesDeRendicion/{id}', [RendicionGastosController::class, 'listarDetalles']);
    Route::get('/rendicionGastos/getNumeracionActual/', [RendicionGastosController::class, 'getNumeracionLibre']);




    Route::get('/rendicion/descargarCDP/{cadena}', [RendicionGastosController::class, 'descargarCDP'])->name('rendiciones.descargarCDP');

    //se consume desde JS
    Route::get('/RendicionGastos/eliminarArchivo/{codArchivoRend}', [RendicionGastosController::class, 'eliminarArchivo']);




    Route::get('/RendicionGastos//descargarPDF/{id}', [RendicionGastosController::class, 'descargarPDF'])->name('rendicionGastos.descargarPDF');

    Route::get('/RendicionGastos/verPDF/{id}', [RendicionGastosController::class, 'verPDF'])->name('rendicionGastos.verPDF');



    Route::post('/rendiciones/Gerente/observar', [RendicionGastosController::class, 'observarComoGerente'])->name('RendicionGastos.Gerente.Observar');
    Route::post('/rendiciones/Administrador/observar', [RendicionGastosController::class, 'observarComoAdministrador'])->name('RendicionGastos.Administrador.Observar');
    Route::post('/rendiciones/Contador/observar', [RendicionGastosController::class, 'observarComoContador'])->name('RendicionGastos.Contador.Observar');


    /* EMPLEADO */

    Route::post('/RendicionGastos/Empleado/guardar', [RendicionGastosController::class, 'store'])->name('RendicionGastos.Empleado.Store');

    Route::get('/RendicionGastos/{id}/Empleado/ver/', [RendicionGastosController::class, 'ver'])->name('RendicionGastos.Empleado.Ver');


    Route::get('RendicionGastos/{id}/Empleado/editar', [RendicionGastosController::class, 'editar'])->name('RendicionGastos.Empleado.Editar');

    Route::Post('/RendicionGastos/Empleado/update/', [RendicionGastosController::class, 'update'])->name('RendicionGastos.Empleado.Update');
    Route::get('/RendicionGastos/Empleado/Listar/', [RendicionGastosController::class, 'listarEmpleado'])->name('RendicionGastos.Empleado.Listar');


    Route::get('RendicionGastos/Empleado/verMisGastos', [RendicionGastosController::class, 'listarMisGastosRendicion'])
      ->name('RendicionGastos.Empleado.verMisGastos');


    Route::get('/RendicionGastos/{codDetalle}/Empleado/marcarComoVisto', [RendicionGastosController::class, 'marcarDetalleComoVisto'])
      ->name('RendicionGastos.Empleado.marcarComoVisto');


    Route::group(['middleware' => "ValidarSesionGerente"], function () {

      /* GERENTE */

      Route::get('/RendicionGastos/{id}/Gerente/ver', [RendicionGastosController::class, 'verGerente'])
        ->name('RendicionGastos.Gerente.Ver');

      Route::get('/RendicionGastos/{id}/Gerente/revisar', [RendicionGastosController::class, 'revisar'])
        ->name('RendicionGastos.Gerente.Revisar');

      Route::Post('/RendicionGastos/Gerente/aprobar', [RendicionGastosController::class, 'aprobar'])
        ->name('RendicionGastos.Gerente.Aprobar');

      Route::get('/RendicionGastos/Gerente/listar/', [RendicionGastosController::class, 'listarDelGerente'])
        ->name('RendicionGastos.Gerente.Listar');
    });
    Route::group(['middleware' => "ValidarSesionAdministracion"], function () {
      /* ADMINISTRACION */

      Route::get('/RendicionGastos/Administracion/listar/', [RendicionGastosController::class, 'listarJefeAdmin'])
        ->name('RendicionGastos.Administracion.Listar');

      Route::get('/RendicionGastos/{id}/Administracion/ver', [RendicionGastosController::class, 'verAdmin'])
        ->name('RendicionGastos.Administracion.Ver');
    });

    Route::group(['middleware' => "ValidarSesionContador"], function () {
      /* CONTADOR */

      Route::get('/RendicionGastos/{id}/Contador/verContabilizar/', [RendicionGastosController::class, 'verContabilizar'])
        ->name('RendicionGastos.Contador.verContabilizar');

      Route::get('/rendicion/contabilizar/{cad}', [RendicionGastosController::class, 'contabilizar'])
        ->name('RendicionGastos.Contador.Contabilizar');

      Route::get('/RendicionGastos/Contador/listar/', [RendicionGastosController::class, 'listarContador'])
        ->name('RendicionGastos.Contador.Listar');
    });


    Route::group(['middleware' => "ValidarSesionObservador"], function () {
      Route::get('/RendicionGastos/Observador/listar', [RendicionGastosController::class, 'listarRendicionesParaObservador'])->name('RendicionGastos.Observador.Listar');
      Route::get('/RendicionGastos/Observador/Ver/{codRendicion}', [RendicionGastosController::class, 'VerRendicionComoObservador'])->name('RendicionGastos.Observador.Ver');
    });



    //RUTA MAESTAR QUE REDIRIJE A LOS LISTADOS DE RENDICIONES DE LOS ACTORES EMP GER Y J.A
    Route::get('/RendicionGastos/MAESTRA/listar', [RendicionGastosController::class, 'listarRendiciones'])
      ->name('RendicionGastos.ListarRendiciones');
  }
}
