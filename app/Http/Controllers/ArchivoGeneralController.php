<?php

namespace App\Http\Controllers;

use App\ArchivoGeneral;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ArchivoGeneralController extends Controller
{

    function DescargarArchivo($codArchivo){
        $archivo = ArchivoGeneral::findOrFail($codArchivo);
        return Storage::download("/archivoGeneral/".$archivo->nombreGuardado,$archivo->nombreAparente);

    }

}