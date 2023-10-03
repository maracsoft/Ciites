<?php

namespace App\Http\Controllers\CITE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ActividadPrincipal;
use App\ArchivoGeneral;
use App\Configuracion;
use App\Debug;
use App\Models\CITE\UnidadProductiva as UnidadProductiva; 

use App\ErrorHistorial;
use App\Models\CITE\TipoMedioVerificacion;
use App\TipoArchivoGeneral;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TipoMedioVerificacionController extends Controller {
    public function listar(Request $request){
      $listaTipos = TipoMedioVerificacion::query()->get();

      return view('CITE.TiposMediosVerificacion.ListarTiposMedios',compact('listaTipos'));

    }

    public function VerFormatos(){
      $listaTipos = TipoMedioVerificacion::query()->get();

      return view('CITE.TiposMediosVerificacion.VerFormatos',compact('listaTipos'));
    }
    
    public function Editar($id){
      $tipo_medio = TipoMedioVerificacion::findOrFail($id);

      return view('CITE.TiposMediosVerificacion.EditarTipoMedio',compact('tipo_medio'));
    }
    
    public function Actualizar(Request $request){
       
      try {

        DB::beginTransaction();
        $indice_formato = "";
        if($request->indice_formato){
          $indice_formato = $request->indice_formato;
        }

        $tipo_medio = TipoMedioVerificacion::findOrFail($request->codTipoMedioVerificacion);
        $tipo_medio->nombre = $request->nombre;
        $tipo_medio->indice_formato = $indice_formato;
        $tipo_medio->save();

        if($request->nombreArchivo){

          $codTipoArchivo = TipoArchivoGeneral::getCodigo('FormatoCite'); 
          $nombreArchivo = json_decode($request->nombreArchivo)[0];  
          Debug::LogMessage("nombreArchivo $nombreArchivo");

          
          $archivo = $request->file('filenames')[0];
          
          Debug::LogMessage($archivo);
          
          //Primero guardamos el archivo para obtener su id
          $archivoGen = new ArchivoGeneral();
          $archivoGen->nombreGuardado = "nombreTemporal.marac";
          $archivoGen->nombreAparente = $nombreArchivo;
          $archivoGen->codTipoArchivo = $codTipoArchivo;
          $archivoGen->save();

          $nombreArchivoGuardado = ArchivoGeneral::formatoNombre($archivoGen->getId(),$nombreArchivo);
          
          $archivoGen->nombreGuardado = $nombreArchivoGuardado;
          $archivoGen->save();

          $fileget = \File::get($archivo);

          Storage::disk('archivoGeneral')->put($nombreArchivoGuardado,$fileget );

          $tipo_medio->codArchivo = $archivoGen->getId();
          $tipo_medio->save();

        }

        DB::commit();
        return redirect()->route('CITE.TiposMediosVerificacion.Editar',$request->codTipoMedioVerificacion)->with('datos_ok',"Se actualizó exitosamente");

      } catch (\Throwable $th) {

          DB::rollBack();
          Debug::mensajeError("TipoMedioVerificacionController Actualizar",$th);
          $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                          app('request')->route()->getAction(),
                                                          json_encode($request->toArray())
                                                          );
          return redirect()->route('CITE.TiposMediosVerificacion.Editar',$request->codTipoMedioVerificacion)->with('datos_error',"Hubo un error");
        
      }
      

    }
 
}
