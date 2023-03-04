<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ActividadPrincipal;
use App\Configuracion;
use App\Debug;
use App\ErrorHistorial;
use Illuminate\Support\Facades\DB;

class AdminPanelController extends Controller
{
  function VerPanel(){

    return view('AdminPanel.VerAdminPanel');
  }

  function VerPhpInfo(){

    return view('AdminPanel.VerPhpinfo');
  }


}
