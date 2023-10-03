<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ActividadPrincipal;
use App\Configuracion;
use App\Debug;
use App\ErrorHistorial;
use App\ParametroSistema;
use Illuminate\Support\Facades\DB;

class AdminPanelController extends Controller
{
  function VerPanel(){

    return view('AdminPanel.VerAdminPanel');
  }

  function VerPhpInfo(){

    return view('AdminPanel.VerPhpinfo');
  }


  public function VerLogCron(){
    $proyect_folder_path = ParametroSistema::getParametroSistema("proyect_folder_path")->valor;

    $fp = fopen("$proyect_folder_path/storage/logs/marac_logs/cron_personas.log", "r");
    while (!feof($fp)){
        $linea = fgets($fp);
        echo $linea."<br>";
    }
    fclose($fp);
    return;
  }

  public function BorrarLogCron(){

    $proyect_folder_path = ParametroSistema::getParametroSistema("proyect_folder_path")->valor;
    
    $file = fopen("$proyect_folder_path/storage/logs/marac_logs/cron_personas.log", "w");
    fwrite($file, "");
    fclose($file);

    return "CONTENIDO BORRADO";
  }

}
