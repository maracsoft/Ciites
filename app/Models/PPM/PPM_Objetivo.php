<?php

namespace App\Models\PPM;

use App\ArchivoGeneral;
use App\Debug;
use App\Distrito;
use App\MaracModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PPM_Objetivo extends MaracModel
{
    public $table = "ppm-objetivo";
    protected $primaryKey ="codObjetivo";

    public $timestamps = false;
    protected $fillable = [''];

    public function getIndicadores(){
      return PPM_Indicador::where('codObjetivo',$this->getId())->get();
    }
    public static function todosParaFront(){

      $lista = PPM_Objetivo::All();
      foreach ($lista as $obj) {
          $indicadores = $obj->getIndicadores();
          foreach ($indicadores as $indicador) {
            $actividades = $indicador->getActividades();
            
            $indicador['actividades'] = $actividades;      
            $indicador['getCodigo'] = $indicador->getCodigo();

          }
          $obj['indicadores'] = $indicadores;
           
      }
      return $lista;
    }

    public function getNombreRecortado($limite_caracteres){
      return Debug::abreviar($this->nombre,$limite_caracteres);
    }

}
