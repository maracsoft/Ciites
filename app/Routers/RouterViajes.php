<?php

namespace App\Routers;

use App\Models\ModuleRouterInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class RouterViajes implements ModuleRouterInterface
{

  public static function RegisterRoutes()
  {

    //RUTA ABIERTA QUE REDIRIJE AL CREAR SI ESTÁ LOGEADO O AL LOGIN
    Route::get('/vv/{placa}', 'ViajeVehiculoController@ManejarQR');



    Route::group(['middleware' => "ValidarSesion"], function () {

      Route::get('/Vehiculo/PDF/Ver/{codVehiculo}', 'VehiculoController@VerPdf')->name('Vehiculo.PDF.Ver');
      Route::get('/Vehiculo/PDF/Descargar/{codVehiculo}', 'VehiculoController@DescargarPdf')->name('Vehiculo.PDF.Descargar');


      Route::group(['middleware' => "ValidarSesionConductor"], function () {
        /* MIS VIAJES */
        Route::get('/ViajeVehiculo/Conductor/Listar', 'ViajeVehiculoController@ListarParaConductor')->name('ViajeVehiculo.Conductor.Listar');
        Route::get('/ViajeVehiculo/Conductor/Crear/{placa}', 'ViajeVehiculoController@Crear')->name('ViajeVehiculo.Conductor.Crear');
        Route::post('/ViajeVehiculo/Conductor/Guardar', 'ViajeVehiculoController@Guardar')->name('ViajeVehiculo.Conductor.Guardar');
        Route::post('/ViajeVehiculo/Conductor/ActualizarDatosSalida', 'ViajeVehiculoController@ActualizarDatosSalida')->name('ViajeVehiculo.Conductor.ActualizarDatosSalida');


        Route::post('/ViajeVehiculo/Conductor/Finalizar', 'ViajeVehiculoController@Finalizar')->name('ViajeVehiculo.Conductor.Finalizar');

        Route::get('/ViajeVehiculo/Conductor/Ver/{id}', 'ViajeVehiculoController@VerParaConductor')->name('ViajeVehiculo.Conductor.Ver');
        Route::get('/ViajeVehiculo/Conductor/Eliminar/{id}', 'ViajeVehiculoController@Eliminar')->name('ViajeVehiculo.Conductor.Eliminar');
      });

      Route::group(['middleware' => "ValidarSesionAprobadorViajes"], function () {

        /* APROBADORES DE  VIAJES */
        Route::get('/ViajeVehiculo/Aprobador/Listar', 'ViajeVehiculoController@ListarParaAprobador')->name('ViajeVehiculo.Aprobador.Listar');
        Route::get('/ViajeVehiculo/Aprobador/Ver/{id}', 'ViajeVehiculoController@VerParaAprobador')->name('ViajeVehiculo.Aprobador.Ver');


        /* CRUD DE VEHICULOS */
        Route::get('/Vehiculo/Listar', 'VehiculoController@Listar')->name('Vehiculo.Listar');
        Route::post('/Vehiculo/Guardar', 'VehiculoController@Guardar')->name('Vehiculo.Guardar');
        Route::get('/Vehiculo/Crear', 'VehiculoController@Crear')->name('Vehiculo.Crear');
        Route::get('/Vehiculo/Editar/{id}', 'VehiculoController@Editar')->name('Vehiculo.Editar');
        Route::post('/Vehiculo/Actualizar', 'VehiculoController@Actualizar')->name('Vehiculo.Actualizar');

        Route::get('/Vehiculo/Eliminar/{id}', 'VehiculoController@Eliminar')->name('Vehiculo.Eliminar');
      });



      Route::group(['middleware' => "ValidarSesionContador"], function () {
        /* APROBADORES DE  VIAJES */
        Route::get('/ViajeVehiculo/Contador/Listar', 'ViajeVehiculoController@ListarParaContador')->name('ViajeVehiculo.Contador.Listar');
        Route::get('/ViajeVehiculo/Contador/Ver/{id}', 'ViajeVehiculoController@VerParaContador')->name('ViajeVehiculo.Contador.Ver');
      });


      Route::get('/ViajeVehiculo/pdf/ver/{id}', 'ViajeVehiculoController@VerPdf')->name('ViajeVehiculo.Pdf.Ver');
      Route::get('/ViajeVehiculo/pdf/descargar/{id}', 'ViajeVehiculoController@DescargarPdf')->name('ViajeVehiculo.Pdf.Descargar');
      Route::get('/ViajeVehiculo/Exportar', 'ViajeVehiculoController@ExportarViajes')->name('ViajeVehiculo.Exportar');
    });
  }
}
