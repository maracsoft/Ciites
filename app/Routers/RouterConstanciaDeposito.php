<?php
namespace App\Routers;

use App\Models\ModuleRouterInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class RouterConstanciaDeposito implements ModuleRouterInterface
{

  public static function RegisterRoutes(){


  
    Route::group(['middleware'=>"ValidarSesionAdministracionOContador"],function(){
      
      Route::get('/ConstanciaDepositoCTS/Listar','ConstanciaDepositoCTSController@Listar')->name('ConstanciaDepositoCTS.Listar');
      
      Route::get('/ConstanciaDepositoCTS/Crear','ConstanciaDepositoCTSController@Crear')->name('ConstanciaDepositoCTS.Crear');
      Route::get('/ConstanciaDepositoCTS/Editar/{id}','ConstanciaDepositoCTSController@Editar')->name('ConstanciaDepositoCTS.Editar');
      Route::get('/ConstanciaDepositoCTS/Eliminar/{id}','ConstanciaDepositoCTSController@Eliminar')->name('ConstanciaDepositoCTS.Eliminar');
      
      Route::post('/ConstanciaDepositoCTS/Guardar','ConstanciaDepositoCTSController@Guardar')->name('ConstanciaDepositoCTS.Guardar');
      Route::post('/ConstanciaDepositoCTS/Actualizar','ConstanciaDepositoCTSController@Actualizar')->name('ConstanciaDepositoCTS.Actualizar');
      
      Route::get('/ConstanciaDepositoCTS/PDF/Ver/{id}','ConstanciaDepositoCTSController@VerPdf')->name('ConstanciaDepositoCTS.VerPdf');
      Route::get('/ConstanciaDepositoCTS/PDF/Descargar/{id}','ConstanciaDepositoCTSController@DescargarPdf')->name('ConstanciaDepositoCTS.DescargarPdf');
      
      
      
    });

 



  }




}
