<?php

namespace App\Routers;

use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\ViajeVehiculoController;
use App\Models\ModuleRouterInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class RouterViajes implements ModuleRouterInterface
{

  public static function RegisterRoutes()
  {

    //RUTA ABIERTA QUE REDIRIJE AL CREAR SI ESTÁ LOGEADO O AL LOGIN
    Route::get('/vv/{placa}', [ViajeVehiculoController::class, 'ManejarQR']);



    Route::group(['middleware' => "ValidarSesion"], function () {

      Route::get('/Vehiculo/PDF/Ver/{codVehiculo}', [VehiculoController::class, 'VerPdf'])->name('Vehiculo.PDF.Ver');
      Route::get('/Vehiculo/PDF/Descargar/{codVehiculo}', [VehiculoController::class, 'DescargarPdf'])->name('Vehiculo.PDF.Descargar');


      Route::group(['middleware' => "ValidarSesionConductor"], function () {
        /* MIS VIAJES */
        Route::get('/ViajeVehiculo/Conductor/Listar', [ViajeVehiculoController::class, 'ListarParaConductor'])->name('ViajeVehiculo.Conductor.Listar');
        Route::get('/ViajeVehiculo/Conductor/Crear/{placa}', [ViajeVehiculoController::class, 'Crear'])->name('ViajeVehiculo.Conductor.Crear');
        Route::post('/ViajeVehiculo/Conductor/Guardar', [ViajeVehiculoController::class, 'Guardar'])->name('ViajeVehiculo.Conductor.Guardar');
        Route::post('/ViajeVehiculo/Conductor/ActualizarDatosSalida', [ViajeVehiculoController::class, 'ActualizarDatosSalida'])->name('ViajeVehiculo.Conductor.ActualizarDatosSalida');


        Route::post('/ViajeVehiculo/Conductor/Finalizar', [ViajeVehiculoController::class, 'Finalizar'])->name('ViajeVehiculo.Conductor.Finalizar');

        Route::get('/ViajeVehiculo/Conductor/Ver/{id}', [ViajeVehiculoController::class, 'VerParaConductor'])->name('ViajeVehiculo.Conductor.Ver');
        Route::get('/ViajeVehiculo/Conductor/Eliminar/{id}', [ViajeVehiculoController::class, 'Eliminar'])->name('ViajeVehiculo.Conductor.Eliminar');
      });

      Route::group(['middleware' => "ValidarSesionAprobadorViajes"], function () {

        /* APROBADORES DE  VIAJES */
        Route::get('/ViajeVehiculo/Aprobador/Listar', [ViajeVehiculoController::class, 'ListarParaAprobador'])->name('ViajeVehiculo.Aprobador.Listar');
        Route::get('/ViajeVehiculo/Aprobador/Ver/{id}', [ViajeVehiculoController::class, 'VerParaAprobador'])->name('ViajeVehiculo.Aprobador.Ver');


        /* CRUD DE VEHICULOS */
        Route::get('/Vehiculo/Listar', [VehiculoController::class, 'Listar'])->name('Vehiculo.Listar');
        Route::post('/Vehiculo/Guardar', [VehiculoController::class, 'Guardar'])->name('Vehiculo.Guardar');
        Route::get('/Vehiculo/Crear', [VehiculoController::class, 'Crear'])->name('Vehiculo.Crear');
        Route::get('/Vehiculo/Editar/{id}', [VehiculoController::class, 'Editar'])->name('Vehiculo.Editar');
        Route::post('/Vehiculo/Actualizar', [VehiculoController::class, 'Actualizar'])->name('Vehiculo.Actualizar');

        Route::get('/Vehiculo/Eliminar/{id}', [VehiculoController::class, 'Eliminar'])->name('Vehiculo.Eliminar');
      });



      Route::group(['middleware' => "ValidarSesionContador"], function () {
        /* APROBADORES DE  VIAJES */
        Route::get('/ViajeVehiculo/Contador/Listar', [ViajeVehiculoController::class, 'ListarParaContador'])->name('ViajeVehiculo.Contador.Listar');
        Route::get('/ViajeVehiculo/Contador/Ver/{id}', [ViajeVehiculoController::class, 'VerParaContador'])->name('ViajeVehiculo.Contador.Ver');
      });


      Route::get('/ViajeVehiculo/pdf/ver/{id}', [ViajeVehiculoController::class, 'VerPdf'])->name('ViajeVehiculo.Pdf.Ver');
      Route::get('/ViajeVehiculo/pdf/descargar/{id}', [ViajeVehiculoController::class, 'DescargarPdf'])->name('ViajeVehiculo.Pdf.Descargar');
      Route::get('/ViajeVehiculo/Exportar', [ViajeVehiculoController::class, 'ExportarViajes'])->name('ViajeVehiculo.Exportar');
    });
  }
}
