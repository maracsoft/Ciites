<?php

namespace App\Models\PPM;

use App\ArchivoGeneral;
use App\Distrito;
use App\MaracModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PPM_FGE_Marcacion extends MaracModel
{
    public $table = "ppm-fge_marcacion";
    protected $primaryKey ="codMarcacion";

    public $timestamps = false;
    protected $fillable = [''];

    public function getRelacion(){
      return PPM_RelacionOrganizacionSemestre::findOrFail($this->codRelacion);
    }

    public function getItem(){
      return PPM_FGE_Item::findOrFail($this->codItem);
    }

    public function getOptionSeleccionada(){
      return PPM_FGE_Option::findOrFail($this->codOptionSeleccionada);
    }

    
    public static function getByRelacionItem(PPM_RelacionOrganizacionSemestre $relacion, PPM_FGE_Item $item) : PPM_FGE_Marcacion {
      return PPM_FGE_Marcacion::where('codRelacion',$relacion->codRelacion)
        ->where('codItem',$item->codItem)
        ->first();
    }

    //retorna true si existe la dupla de relacion e item
    public static function existeRelacionItem(PPM_RelacionOrganizacionSemestre $relacion, PPM_FGE_Item $item) : bool {
      $cant = PPM_FGE_Marcacion::where('codRelacion',$relacion->codRelacion)
        ->where('codItem',$item->codItem)
        ->count();

      return $cant > 0;
    }
    
}