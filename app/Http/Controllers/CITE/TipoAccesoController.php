<?php

namespace App\Http\Controllers\CITE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ActividadPrincipal;
use App\Configuracion;
use App\Debug;
use App\Models\CITE\UnidadProductiva as UnidadProductiva; 

use App\ErrorHistorial;
use Illuminate\Support\Facades\DB;

class TipoAccesoController extends Controller
{
    const PAGINATION = '20';

    public function listar(Request $request){
         
        return UnidadProductiva::All();
    }
 
    
 
}
