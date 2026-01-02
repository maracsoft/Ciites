<?php

namespace App\Routers;

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


      Route::get('/DJ/GastosMovilidad', 'DJGastosMovilidadController@listarDeEmpleado')
        ->name('DJMovilidad.Empleado.Listar');

      Route::get('/DJ/GastosMovilidad/Crear', 'DJGastosMovilidadController@crearDJMov')
        ->name('DJMovilidad.Empleado.Crear');

      Route::post('/DJ/GastosMovilidad/Guardar', 'DJGastosMovilidadController@Guardar')
        ->name('DJMovilidad.Empleado.Guardar');

      Route::get('/DJ/GastosMovilidad/{codDJ}/descargarPDF', 'DJGastosMovilidadController@descargarPDF')
        ->name('DJMovilidad.Empleado.descargarPDF');

      Route::get('/DJ/GastosMovilidad/{codDJ}/verPDF', 'DJGastosMovilidadController@verPDF')
        ->name('DJMovilidad.Empleado.verPDF');

      Route::get('/DJ/GastosMovilidad/{codDJ}/ver', 'DJGastosMovilidadController@ver')
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


      Route::get('/DJ/GastosVarios', 'DJGastosVariosController@listarDeEmpleado')
        ->name('DJVarios.Empleado.Listar');

      Route::get('/DJ/GastosVarios/Crear', 'DJGastosVariosController@crearDJVar')
        ->name('DJVarios.Empleado.Crear');

      Route::post('/DJ/GastosVarios/store', 'DJGastosVariosController@store')
        ->name('DJVarios.Empleado.Guardar');

      Route::get('/DJ/GastosVarios/{codDJ}/descargarPDF', 'DJGastosVariosController@descargarPDF')
        ->name('DJVarios.Empleado.descargarPDF');

      Route::get('/DJ/GastosVarios/{codDJ}/verPDF', 'DJGastosVariosController@verPDF')
        ->name('DJVarios.Empleado.verPDF');

      Route::get('/DJ/GastosVarios/{codDJ}/ver', 'DJGastosVariosController@ver')
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


      Route::get('/DJ/GastosViaticos', 'DJGastosViaticosController@listarDeEmpleado')
        ->name('DJViaticos.Empleado.Listar');

      Route::get('/DJ/GastosViaticos/Crear', 'DJGastosViaticosController@crearDJVia')
        ->name('DJViaticos.Empleado.Crear');

      Route::post('/DJ/GastosViaticos/store', 'DJGastosViaticosController@Guardar')
        ->name('DJViaticos.Empleado.Guardar');

      Route::get('/DJ/GastosViaticos/{codDJ}/descargarPDF', 'DJGastosViaticosController@descargarPDF')
        ->name('DJViaticos.Empleado.descargarPDF');

      Route::get('/DJ/GastosViaticos/{codDJ}/verPDF', 'DJGastosViaticosController@verPDF')
        ->name('DJViaticos.Empleado.verPDF');

      Route::get('/DJ/GastosViaticos/{codDJ}/ver', 'DJGastosViaticosController@ver')
        ->name('DJViaticos.Empleado.ver');
    });
  }
}
