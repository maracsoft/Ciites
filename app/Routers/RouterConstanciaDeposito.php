<?php

namespace App\Routers;

use App\Http\Controllers\ConstanciaDepositoCTSController;
use App\Models\ModuleRouterInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class RouterConstanciaDeposito implements ModuleRouterInterface
{

  public static function RegisterRoutes()
  {



    Route::group(['middleware' => "ValidarSesionAdministracionOContador"], function () {

      Route::get('/ConstanciaDepositoCTS/Listar', [ConstanciaDepositoCTSController::class, 'Listar'])->name('ConstanciaDepositoCTS.Listar');

      Route::get('/ConstanciaDepositoCTS/Crear', [ConstanciaDepositoCTSController::class, 'Crear'])->name('ConstanciaDepositoCTS.Crear');
      Route::get('/ConstanciaDepositoCTS/Editar/{id}', [ConstanciaDepositoCTSController::class, 'Editar'])->name('ConstanciaDepositoCTS.Editar');
      Route::get('/ConstanciaDepositoCTS/Eliminar/{id}', [ConstanciaDepositoCTSController::class, 'Eliminar'])->name('ConstanciaDepositoCTS.Eliminar');

      Route::post('/ConstanciaDepositoCTS/Guardar', [ConstanciaDepositoCTSController::class, 'Guardar'])->name('ConstanciaDepositoCTS.Guardar');
      Route::post('/ConstanciaDepositoCTS/Actualizar', [ConstanciaDepositoCTSController::class, 'Actualizar'])->name('ConstanciaDepositoCTS.Actualizar');

      Route::get('/ConstanciaDepositoCTS/PDF/Ver/{id}', [ConstanciaDepositoCTSController::class, 'VerPdf'])->name('ConstanciaDepositoCTS.VerPdf');
      Route::get('/ConstanciaDepositoCTS/PDF/Descargar/{id}', [ConstanciaDepositoCTSController::class, 'DescargarPdf'])->name('ConstanciaDepositoCTS.DescargarPdf');
    });
  }
}
