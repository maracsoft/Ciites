<?php

namespace App\Routers;

use App\Http\Controllers\OrdenCompraController;
use App\Models\ModuleRouterInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class RouterOrdenCompra implements ModuleRouterInterface
{
  public static function RegisterRoutes()
  {
    Route::get('/OrdenCompra', [OrdenCompraController::class, 'listarDeEmpleado'])
      ->name('OrdenCompra.Empleado.Listar');

    Route::get('/OrdenCompra/{id}/Ver', [OrdenCompraController::class, 'verOrdenCompra'])
      ->name('OrdenCompra.Empleado.Ver');


    //PDF PARA ORDEN DE COMPRA
    Route::get('/OrdenCompra/{id}/descargar', [OrdenCompraController::class, 'descargarPDF'])
      ->name('OrdenCompra.descargarPDF');
    Route::get('/OrdenCompra/{id}/verPDF', [OrdenCompraController::class, 'verPDF'])
      ->name('OrdenCompra.verPDF');


    Route::get('/OrdenCompra/descargarArchivo/{id}', [OrdenCompraController::class, 'descargarArchivo'])
      ->name('OrdenCompra.descargarArchivo');






    Route::group(['middleware' => "ValidarSesionAdministracionOContador"], function () {


      Route::get('/OrdenCompra/Crear', [OrdenCompraController::class, 'crearOrdenCompra'])
        ->name('OrdenCompra.Empleado.Crear');

      Route::post('/OrdenCompra/store', [OrdenCompraController::class, 'Guardar'])
        ->name('OrdenCompra.Empleado.Guardar');

      Route::get('/OrdenCompra/{id}/Editar', [OrdenCompraController::class, 'editarOrdenCompra'])
        ->name('OrdenCompra.Empleado.Editar');

      Route::post('/OrdenCompra/update', [OrdenCompraController::class, 'Update'])
        ->name('OrdenCompra.Empleado.Update');


      Route::get('/OrdenCompra/eliminarArchivo/{id}', [OrdenCompraController::class, 'eliminarArchivo'])
        ->name('OrdenCompra.eliminarArchivo');
    });
  }
}
