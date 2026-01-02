<?php

namespace App\Routers;

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
        Route::get('/ContratosPlazo/Listar', 'ContratoPlazoController@listar')->name('ContratosPlazo.Listar');
        Route::get('/ContratosPlazo/Crear', 'ContratoPlazoController@Crear')->name('ContratosPlazo.Crear');
        Route::get('/ContratosPlazo/Editar/{codContrato}', 'ContratoPlazoController@Editar')->name('ContratosPlazo.Editar');

        Route::post('/ContratosPlazo/Guardar', 'ContratoPlazoController@Guardar')->name('ContratosPlazo.Guardar');
        Route::post('/ContratosPlazo/Actualizar', 'ContratoPlazoController@Actualizar')->name('ContratosPlazo.Actualizar');


        Route::post('/ContratosPlazo/GenerarBorrador', 'ContratoPlazoController@GenerarBorrador')->name('ContratosPlazo.GenerarBorrador');
        Route::get('/Contratos/Borradores/Ver/{filename}', 'ContratoPlazoController@VerBorrador')->name('ContratosPlazo.VerBorrador');


        Route::get('/ContratosPlazo/descargarPDF/{codContrato}', 'ContratoPlazoController@descargarPDF')->name('ContratosPlazo.descargarPDF');
        Route::get('/ContratosPlazo/verPDF/{codContrato}', 'ContratoPlazoController@verPDF')->name('ContratosPlazo.verPDF');

        Route::get('/ContratosPlazo/Ver/{codContrato}', 'ContratoPlazoController@Ver')->name('ContratosPlazo.Ver');

        Route::get('/ContratosPlazo/Anular/{codContrato}', 'ContratoPlazoController@Anular')->name('ContratosPlazo.Anular');



        Route::get('/ContratosLocacion/Listar', 'ContratoLocacionController@listar')->name('ContratosLocacion.Listar');
        Route::get('/ContratosLocacion/Crear', 'ContratoLocacionController@Crear')->name('ContratosLocacion.Crear');
        Route::post('/ContratosLocacion/Guardar', 'ContratoLocacionController@Guardar')->name('ContratosLocacion.Guardar');

        Route::get('/ContratosLocacion/Editar/{codContrato}', 'ContratoLocacionController@Editar')->name('ContratosLocacion.Editar');
        Route::post('/ContratosLocacion/Actualizar', 'ContratoLocacionController@Actualizar')->name('ContratosLocacion.Actualizar');


        Route::post('/ContratosLocacion/GenerarBorrador', 'ContratoLocacionController@GenerarBorrador')->name('ContratosLocacion.GenerarBorrador');

        Route::get('/ContratosLocacion/descargarPDF/{codContrato}', 'ContratoLocacionController@descargarPDF')->name('ContratosLocacion.descargarPDF');
        Route::get('/ContratosLocacion/verPDF/{codContrato}', 'ContratoLocacionController@verPDF')->name('ContratosLocacion.verPDF');
        Route::get('/ContratosLocacion/Ver/{codContrato}', 'ContratoLocacionController@Ver')->name('ContratosLocacion.Ver');

        Route::get('/ContratosLocacion/Anular/{codContrato}', 'ContratoLocacionController@Anular')->name('ContratosLocacion.Anular');

        /* *************************+ CONTRATOS NUEVO ********************************++ */

        Route::get('/ContratosPlazoNuevo/Listar', 'ContratoPlazoNuevoController@listar')->name('ContratosPlazoNuevo.Listar');
        Route::get('/ContratosPlazoNuevo/Crear', 'ContratoPlazoNuevoController@Crear')->name('ContratosPlazoNuevo.Crear');
        Route::get('/ContratosPlazoNuevo/Editar/{codContratoPlazo}', 'ContratoPlazoNuevoController@Editar')->name('ContratosPlazoNuevo.Editar');

        Route::post('/ContratosPlazoNuevo/Guardar', 'ContratoPlazoNuevoController@Guardar')->name('ContratosPlazoNuevo.Guardar');
        Route::post('/ContratosPlazoNuevo/Actualizar', 'ContratoPlazoNuevoController@Actualizar')->name('ContratosPlazoNuevo.Actualizar');

        Route::post('/ContratosPlazoNuevo/GenerarBorrador', 'ContratoPlazoNuevoController@GenerarBorrador')->name('ContratosPlazoNuevo.GenerarBorrador');

        Route::get('/ContratosPlazoNuevo/descargarPDF/{codContrato}', 'ContratoPlazoNuevoController@descargarPDF')->name('ContratosPlazoNuevo.descargarPDF');
        Route::get('/ContratosPlazoNuevo/verPDF/{codContrato}', 'ContratoPlazoNuevoController@verPDF')->name('ContratosPlazoNuevo.verPDF');

        Route::get('/ContratosPlazoNuevo/Ver/{codContrato}', 'ContratoPlazoNuevoController@Ver')->name('ContratosPlazoNuevo.Ver');

        Route::get('/ContratosPlazoNuevo/Anular/{codContrato}', 'ContratoPlazoNuevoController@Anular')->name('ContratosPlazoNuevo.Anular');
      });
    });
  }
}
