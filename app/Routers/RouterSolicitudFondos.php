<?php

namespace App\Routers;

use App\Http\Controllers\SolicitudFondosController;
use App\Models\ModuleRouterInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class RouterSolicitudFondos implements ModuleRouterInterface
{

  public static function RegisterRoutes()
  {


    Route::get('/listarDetallesDeSolicitud/{id}', [SolicitudFondosController::class, 'listarDetalles']);
    Route::get('/solicitudFondos/getNumeracionActual/', [SolicitudFondosController::class, 'getNumeracionLibre']);


    Route::group(['middleware' => "ValidarSesion"], function () {






      /* AFUERA DEL MIDDLEWARE(no requieren validacion o hacerlas sería demasiado complejo xd) */
      Route::get('/SolicitudFondos/MASTERINDEX', [SolicitudFondosController::class, 'listarSolicitudes'])->name('solicitudFondos.ListarSolicitudes');








      Route::get('/SolicitudFondos/descargar/{id}', [SolicitudFondosController::class, 'descargarPDF'])->name('solicitudFondos.descargarPDF');
      Route::get('/SolicitudFondos/verPDF/{id}', [SolicitudFondosController::class, 'verPDF'])->name('solicitudFondos.verPDF');

      Route::get('/SolicitudFondos/descargarArchivo/{codArc}', [SolicitudFondosController::class, 'descargarArchivo'])->name('SolicitudFondos.descargarArchivo');

      Route::get('/SolicitudFondos/eliminarArchivo/{codArc}', [SolicitudFondosController::class, 'eliminarArchivo'])->name('SolicitudFondos.eliminarArchivo');


      /* EMPLEADO Cualquier user logeado puede hacer, no es necesario validar*/
      Route::get('/SolicitudFondos/Empleado/Crear', [SolicitudFondosController::class, 'create'])->name('SolicitudFondos.Empleado.Create');

      Route::get('/SolicitudFondos/Empleado/editar/{id}', [SolicitudFondosController::class, 'edit'])->name('SolicitudFondos.Empleado.Edit');


      Route::get('/SolicitudFondos/Empleado/delete/{id}', [SolicitudFondosController::class, 'cancelar'])->name('SolicitudFondos.Empleado.cancelar');

      Route::get('/SolicitudFondos/Empleado/listar/', [SolicitudFondosController::class, 'listarSolicitudesDeEmpleado'])->name('SolicitudFondos.Empleado.Listar');





      Route::get('/SolicitudFondos/{id}/Empleado/ver/', [SolicitudFondosController::class, 'ver'])
        ->name('SolicitudFondos.Empleado.Ver');

      Route::post('/SolicitudFondos/Empleado/guardar', [SolicitudFondosController::class, 'store'])
        ->name('SolicitudFondos.Empleado.Guardar');


      Route::get('/SolicitudFondos/Empleado/Rendir/{id}', [SolicitudFondosController::class, 'rendir'])
        ->name('SolicitudFondos.Empleado.Rendir');

      Route::post('/SolicitudFondos/{id}/Empleado/update/', [SolicitudFondosController::class, 'update'])
        ->name('SolicitudFondos.Empleado.update');



      /* GERENTE */


      Route::group(['middleware' => "ValidarSesionGerente"], function () {

        Route::get('/SolicitudFondos/{id}/Gerente/Revisar/', [SolicitudFondosController::class, 'revisar'])
          ->name('SolicitudFondos.Gerente.Revisar');

        Route::get('/SolicitudFondos/Gerente/listar', [SolicitudFondosController::class, 'listarSolicitudesParaGerente'])
          ->name('SolicitudFondos.Gerente.Listar');

        Route::Post('/SolicitudFondos/Gerente/Aprobar/', [SolicitudFondosController::class, 'aprobar'])
          ->name('SolicitudFondos.Gerente.Aprobar');


        Route::post('/SolicitudFondos/Gerente/Observar', [SolicitudFondosController::class, 'observarGerente'])->name('solicitudFondos.Gerente.observar');
        Route::get('/SolicitudFondos/Gerente/Rechazar/{id}', [SolicitudFondosController::class, 'rechazarGerente'])->name('SolicitudFondos.Gerente.Rechazar');
      });

      Route::group(['middleware' => "ValidarSesionAdministracion"], function () {

        /* ADMINSITRACION */
        Route::get('/SolicitudFondos/Administración/listar', [SolicitudFondosController::class, 'listarSolicitudesParaJefe'])->name('SolicitudFondos.Administracion.Listar');

        Route::get('/SolicitudFondos/{id}/Administracion/vistaAbonar/', [SolicitudFondosController::class, 'vistaAbonar'])->name('SolicitudFondos.Administracion.verAbonar');

        Route::post('/SolicitudFondos/Administracion/Abonar/', [SolicitudFondosController::class, 'abonar'])->name('SolicitudFondos.Administracion.Abonar');

        Route::post('/SolicitudFondos/Administrador/Observar', [SolicitudFondosController::class, 'observarAdministrador'])->name('solicitudFondos.Administrador.observar');
        Route::get('/SolicitudFondos/Administrador/Rechazar/{id}', [SolicitudFondosController::class, 'rechazarAdministrador'])->name('SolicitudFondos.Administrador.Rechazar');
      });

      Route::group(['middleware' => "ValidarSesionContador"], function () {

        /* CONTADOR */

        Route::get('/SolicitudFondos/Contador/listar', [SolicitudFondosController::class, 'listarSolicitudesParaContador'])->name('SolicitudFondos.Contador.Listar');
        Route::get('/SolicitudFondos/{id}/Contador/verContabilizar/', [SolicitudFondosController::class, 'verContabilizar'])->name('SolicitudFondos.Contador.verContabilizar');
        Route::get('/SolicitudFondos/Contador/Contabilizar/{id}', [SolicitudFondosController::class, 'contabilizar'])->name('SolicitudFondos.Contador.Contabilizar');
      });

      Route::group(['middleware' => "ValidarSesionObservador"], function () {
        Route::get('/SolicitudFondos/Observador/listar', [SolicitudFondosController::class, 'listarSolicitudesParaObservador'])->name('SolicitudFondos.Observador.Listar');
        Route::get('/SolicitudFondos/Observador/Ver/{codSolicitud}', [SolicitudFondosController::class, 'VerSolicitudComoObservador'])->name('SolicitudFondos.Observador.Ver');
      });
    });
  }
}
