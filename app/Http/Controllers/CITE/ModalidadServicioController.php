<?php

namespace App\Http\Controllers\CITE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CITE\UnidadProductiva as UnidadProductiva; 



class ModalidadServicioController extends Controller
{
    const PAGINATION = '20';

    public function listar(Request $request){
         
        return UnidadProductiva::All();
    }
 
    
 
}
