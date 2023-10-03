<?php

namespace App\Models\PPM;


use App\ArchivoGeneral;
use App\Debug;
use App\Distrito;
use App\MaracModel;
use App\Models\CITE\UnidadProductiva;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PPM_Participacion extends MaracModel
{
    public $table = "ppm-participacion";
    protected $primaryKey = "codParticipacion";

    public $timestamps = false;
    protected $fillable = [''];
  
    public function getPersona(){
      return PPM_Persona::findOrFail($this->codPersona);
    }

    public function getEjecucionActividad(){
      return PPM_EjecucionActividad::findOrFail($this->codEjecucionActividad);
    }

    public function esExterno(){
      return $this->externo==1;
    }
  
    public static function VerificarParticipacion($codPersona , $codEjecucionActividad){
      $cant = PPM_Participacion::where('codPersona',$codPersona)->where('codEjecucionActividad',$codEjecucionActividad)->count();
      if($cant == 0)
        return false;
      return true;
    }


    public static function GetParticipacion($codPersona , $codEjecucionActividad){
      $lista = PPM_Participacion::where('codPersona',$codPersona)->where('codEjecucionActividad',$codEjecucionActividad)->get();
      if(count($lista) == 0){
        throw new Exception("No existe la Participacion");
      }
        
      return $lista[0];
    }

    
    
  
  
}