<?php

namespace App\Models\PPM;

use App\ArchivoGeneral;
use App\Distrito;
use App\MaracModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PPM_Actividad extends MaracModel
{
    public $table = "ppm-actividad";
    protected $primaryKey ="codActividad";

    public $timestamps = false;
    protected $fillable = [''];


    public function getIndicador(){
      return PPM_Indicador::findOrFail($this->codIndicador);
    }
    
  
}
