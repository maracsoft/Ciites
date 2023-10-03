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

    /* Si bien es cierto le llegan 2 parametros, el 2do que llega es para que el navegador piense que ese es el nombre del PDF y lo muestre así */
    public function VerArchivoPDF($codArchivo,$nombre_archivo){
      $archivo = ArchivoGeneral::findOrFail($codArchivo);
      $file = Storage::get("archivoGeneral/".$archivo->nombreGuardado);
      return static::setPDFResponse($file,$archivo->nombreAparente);
    }

    public static function setPDFResponse($data){
      return response($data, 200)
      ->header('Content-Type', 'application/pdf');
    }
}