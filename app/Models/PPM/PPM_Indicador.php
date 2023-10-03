<?php

namespace App\Models\PPM;

use App\ArchivoGeneral;
use App\Distrito;
use App\MaracModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PPM_Indicador extends MaracModel
{
    public $table = "ppm-indicador";
    protected $primaryKey ="codIndicador";

    public $timestamps = false;
    protected $fillable = [''];

    public function getCodigo(){
      $objetivo = $this->getObjetivo();
      return $objetivo->indice.".".$this->indice;
    }

    public function getObjetivo(){
      return PPM_Objetivo::findOrFail($this->codObjetivo);
    }

    public function getActividades(){
      return PPM_Actividad::where('codIndicador',$this->getId())->get();
    }
}
