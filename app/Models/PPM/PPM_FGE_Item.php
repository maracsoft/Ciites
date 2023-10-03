<?php

namespace App\Models\PPM;

use App\ArchivoGeneral;
use App\Distrito;
use App\MaracModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PPM_FGE_Item extends MaracModel
{
    public $table = "ppm-fge_item";
    protected $primaryKey ="codItem";

    public $timestamps = false;
    protected $fillable = [''];


    public static function BuscarYSiNoExisteCrear($descripcion,PPM_FGE_Segmento $segmento) : PPM_FGE_Item {

      $buscar = PPM_FGE_Item::where('descripcion',$descripcion)->get();
      if(count($buscar) == 0){ //no existe, lo creamos
        $nuevo = new PPM_FGE_Item();
        $nuevo->descripcion = $descripcion;
        $nuevo->codSegmento = $segmento->codSegmento;
        $nuevo->save();
        return $nuevo;
      }else{
        return $buscar[0];
      }

    }


    public function getOptions() : Collection {
      return PPM_FGE_Option::where('codItem',$this->codItem)->get();
    }

    public function getMarcacion(PPM_RelacionOrganizacionSemestre $relacion) : PPM_FGE_Marcacion {
      return PPM_FGE_Marcacion::where('codRelacion',$relacion->codRelacion)->where('codItem',$this->codItem)->first();
    }

    public function verificarMarcacion(PPM_RelacionOrganizacionSemestre $relacion){
      $cant = PPM_FGE_Marcacion::where('codRelacion',$relacion->codRelacion)->where('codItem',$this->codItem)->count();
      
      if($cant == 0)
        return false;
      return true;
    }
    
  }