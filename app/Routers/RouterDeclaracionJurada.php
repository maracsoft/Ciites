<?php

namespace App\Routers;

use App\Http\Controllers\DJGastosMovilidadController;
use App\Http\Controllers\DJGastosVariosController;
use App\Http\Controllers\DJGastosViaticosController;
use App\Models\ModuleRouterInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class RouterDeclaracionJurada implements ModuleRouterInterface
{
  public static function RegisterRoutes()
  {

    Route::group(['middleware' => "ValidarSesion"], function () {










      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* --------------------------------MODULO DJ GASTOS MOVILIDAD---------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */


      Route::get('/DJ/GastosMovilidad', [DJGastosMovilidadController::class, 'listarDeEmpleado'])
        ->name('DJMovilidad.Empleado.Listar');

      Route::get('/DJ/GastosMovilidad/Crear', [DJGastosMovilidadController::class, 'crearDJMov'])
        ->name('DJMovilidad.Empleado.Crear');

      Route::post('/DJ/GastosMovilidad/Guardar', [DJGastosMovilidadController::class, 'Guardar'])
        ->name('DJMovilidad.Empleado.Guardar');

      Route::get('/DJ/GastosMovilidad/{codDJ}/descargarPDF', [DJGastosMovilidadController::class, 'descargarPDF'])
        ->name('DJMovilidad.Empleado.descargarPDF');

      Route::get('/DJ/GastosMovilidad/{codDJ}/verPDF', [DJGastosMovilidadController::class, 'verPDF'])
        ->name('DJMovilidad.Empleado.verPDF');

      Route::get('/DJ/GastosMovilidad/{codDJ}/ver', [DJGastosMovilidadController::class, 'ver'])
        ->name('DJMovilidad.Empleado.ver');



      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* --------------------------------  MODULO DJ GASTOS VARIOS ---------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */


      Route::get('/DJ/GastosVarios', [DJGastosVariosController::class, 'listarDeEmpleado'])
        ->name('DJVarios.Empleado.Listar');

      Route::get('/DJ/GastosVarios/Crear', [DJGastosVariosController::class, 'crearDJVar'])
        ->name('DJVarios.Empleado.Crear');

      Route::post('/DJ/GastosVarios/store', [DJGastosVariosController::class, 'store'])
        ->name('DJVarios.Empleado.Guardar');

      Route::get('/DJ/GastosVarios/{codDJ}/descargarPDF', [DJGastosVariosController::class, 'descargarPDF'])
        ->name('DJVarios.Empleado.descargarPDF');

      Route::get('/DJ/GastosVarios/{codDJ}/verPDF', [DJGastosVariosController::class, 'verPDF'])
        ->name('DJVarios.Empleado.verPDF');

      Route::get('/DJ/GastosVarios/{codDJ}/ver', [DJGastosVariosController::class, 'ver'])
        ->name('DJVarios.Empleado.ver');




      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* --------------------------------  MODULO DJ GASTOS VIATICOS -------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */


      Route::get('/DJ/GastosViaticos', [DJGastosViaticosController::class, 'listarDeEmpleado'])
        ->name('DJViaticos.Empleado.Listar');

      Route::get('/DJ/GastosViaticos/Crear', [DJGastosViaticosController::class, 'crearDJVia'])
        ->name('DJViaticos.Empleado.Crear');

      Route::post('/DJ/GastosViaticos/store', [DJGastosViaticosController::class, 'Guardar'])
        ->name('DJViaticos.Empleado.Guardar');

      Route::get('/DJ/GastosViaticos/{codDJ}/descargarPDF', [DJGastosViaticosController::class, 'descargarPDF'])
        ->name('DJViaticos.Empleado.descargarPDF');

      Route::get('/DJ/GastosViaticos/{codDJ}/verPDF', [DJGastosViaticosController::class, 'verPDF'])
        ->name('DJViaticos.Empleado.verPDF');

      Route::get('/DJ/GastosViaticos/{codDJ}/ver', [DJGastosViaticosController::class, 'ver'])
        ->name('DJViaticos.Empleado.ver');
    });
  }
}
