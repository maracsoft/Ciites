<?php

namespace App\Models\PPM;

use App\ArchivoGeneral;
use App\Distrito;
use App\MaracModel;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PPM_UnidadMedida extends MaracModel
{
    public $table = "ppm-unidad_medida";
    protected $primaryKey ="codUnidadMedida";

    public $timestamps = false;
    protected $fillable = [''];


    public static function getCodByNombre($nombre){
      $unid = PPM_UnidadMedida::where('nombre',$nombre)->get();
      if(count($unid) == 0){
        throw new Exception("No existe la unidad de medida ppm con nombre $nombre");
      }

      return $unid[0]->codUnidadMedida;
    } 
    
}
