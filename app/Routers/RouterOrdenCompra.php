<?php

namespace App\Routers;

use App\Models\ModuleRouterInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class RouterOrdenCompra implements ModuleRouterInterface
{
  public static function RegisterRoutes()
  {
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
  }
}
