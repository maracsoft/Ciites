<?php

namespace App\Models\PPM;

use App\ArchivoGeneral;
use App\Distrito;
use App\MaracModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PPM_FGE_Segmento extends MaracModel
{
    public $table = "ppm-fge_segmento";
    protected $primaryKey ="codSegmento";

    public $timestamps = false;
    protected $fillable = [''];


    public static function BuscarYSiNoExisteCrear($nombre) : PPM_FGE_Segmento {

      $buscar = PPM_FGE_Segmento::where('nombre',$nombre)->get();
      if(count($buscar) == 0){ //no existe, lo creamos
        $nuevo = new PPM_FGE_Segmento();
        $nuevo->nombre = $nombre;
        $nuevo->save();
        return $nuevo;
      }else{
        return $buscar[0];
      }

    }


    public function getItems() : Collection {
      return PPM_FGE_Item::where('codSegmento',$this->codSegmento)->get();
    }
    public function getCantidadItems(){
      return PPM_FGE_Item::where('codSegmento',$this->codSegmento)->count();
    }
    
  }