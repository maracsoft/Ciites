<?php

namespace App\Routers;

use App\Http\Controllers\ContratoLocacionController;
use App\Http\Controllers\ContratoPlazoController;
use App\Http\Controllers\ContratoPlazoNuevoController;
use App\Models\ModuleRouterInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class RouterContratos implements ModuleRouterInterface
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
      /* --------------------------------MODULO CONTRATOS      -------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */
      /* -------------------------------------------------------------------------------------- */

      Route::group(['middleware' => "ValidarSesionAdministracion"], function () {
        Route::get('/ContratosPlazo/Listar', [ContratoPlazoController::class, 'listar'])->name('ContratosPlazo.Listar');
        Route::get('/ContratosPlazo/Crear', [ContratoPlazoController::class, 'Crear'])->name('ContratosPlazo.Crear');
        Route::get('/ContratosPlazo/Editar/{codContrato}', [ContratoPlazoController::class, 'Editar'])->name('ContratosPlazo.Editar');

        Route::post('/ContratosPlazo/Guardar', [ContratoPlazoController::class, 'Guardar'])->name('ContratosPlazo.Guardar');
        Route::post('/ContratosPlazo/Actualizar', [ContratoPlazoController::class, 'Actualizar'])->name('ContratosPlazo.Actualizar');


        Route::post('/ContratosPlazo/GenerarBorrador', [ContratoPlazoController::class, 'GenerarBorrador'])->name('ContratosPlazo.GenerarBorrador');
        Route::get('/Contratos/Borradores/Ver/{filename}', [ContratoPlazoController::class, 'VerBorrador'])->name('ContratosPlazo.VerBorrador');


        Route::get('/ContratosPlazo/descargarPDF/{codContrato}', [ContratoPlazoController::class, 'descargarPDF'])->name('ContratosPlazo.descargarPDF');
        Route::get('/ContratosPlazo/verPDF/{codContrato}', [ContratoPlazoController::class, 'verPDF'])->name('ContratosPlazo.verPDF');

        Route::get('/ContratosPlazo/Ver/{codContrato}', [ContratoPlazoController::class, 'Ver'])->name('ContratosPlazo.Ver');

        Route::get('/ContratosPlazo/Anular/{codContrato}', [ContratoPlazoController::class, 'Anular'])->name('ContratosPlazo.Anular');



        Route::get('/ContratosLocacion/Listar', [ContratoLocacionController::class, 'listar'])->name('ContratosLocacion.Listar');
        Route::get('/ContratosLocacion/Crear', [ContratoLocacionController::class, 'Crear'])->name('ContratosLocacion.Crear');
        Route::post('/ContratosLocacion/Guardar', [ContratoLocacionController::class, 'Guardar'])->name('ContratosLocacion.Guardar');

        Route::get('/ContratosLocacion/Editar/{codContrato}', [ContratoLocacionController::class, 'Editar'])->name('ContratosLocacion.Editar');
        Route::post('/ContratosLocacion/Actualizar', [ContratoLocacionController::class, 'Actualizar'])->name('ContratosLocacion.Actualizar');


        Route::post('/ContratosLocacion/GenerarBorrador', [ContratoLocacionController::class, 'GenerarBorrador'])->name('ContratosLocacion.GenerarBorrador');

        Route::get('/ContratosLocacion/descargarPDF/{codContrato}', [ContratoLocacionController::class, 'descargarPDF'])->name('ContratosLocacion.descargarPDF');
        Route::get('/ContratosLocacion/verPDF/{codContrato}', [ContratoLocacionController::class, 'verPDF'])->name('ContratosLocacion.verPDF');
        Route::get('/ContratosLocacion/Ver/{codContrato}', [ContratoLocacionController::class, 'Ver'])->name('ContratosLocacion.Ver');

        Route::get('/ContratosLocacion/Anular/{codContrato}', [ContratoLocacionController::class, 'Anular'])->name('ContratosLocacion.Anular');

        /* *************************+ CONTRATOS NUEVO ********************************++ */

        Route::get('/ContratosPlazoNuevo/Listar', [ContratoPlazoNuevoController::class, 'listar'])->name('ContratosPlazoNuevo.Listar');
        Route::get('/ContratosPlazoNuevo/Crear', [ContratoPlazoNuevoController::class, 'Crear'])->name('ContratosPlazoNuevo.Crear');
        Route::get('/ContratosPlazoNuevo/Editar/{codContratoPlazo}', [ContratoPlazoNuevoController::class, 'Editar'])->name('ContratosPlazoNuevo.Editar');

        Route::post('/ContratosPlazoNuevo/Guardar', [ContratoPlazoNuevoController::class, 'Guardar'])->name('ContratosPlazoNuevo.Guardar');
        Route::post('/ContratosPlazoNuevo/Actualizar', [ContratoPlazoNuevoController::class, 'Actualizar'])->name('ContratosPlazoNuevo.Actualizar');

        Route::post('/ContratosPlazoNuevo/GenerarBorrador', [ContratoPlazoNuevoController::class, 'GenerarBorrador'])->name('ContratosPlazoNuevo.GenerarBorrador');

        Route::get('/ContratosPlazoNuevo/descargarPDF/{codContrato}', [ContratoPlazoNuevoController::class, 'descargarPDF'])->name('ContratosPlazoNuevo.descargarPDF');
        Route::get('/ContratosPlazoNuevo/verPDF/{codContrato}', [ContratoPlazoNuevoController::class, 'verPDF'])->name('ContratosPlazoNuevo.verPDF');

        Route::get('/ContratosPlazoNuevo/Ver/{codContrato}', [ContratoPlazoNuevoController::class, 'Ver'])->name('ContratosPlazoNuevo.Ver');

        Route::get('/ContratosPlazoNuevo/Anular/{codContrato}', [ContratoPlazoNuevoController::class, 'Anular'])->name('ContratosPlazoNuevo.Anular');
      });
    });
  }
}
