<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public $table = "job";
    protected $primaryKey ="codJob";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

    public function estaEjecutado(){
      return $this->ejecutado == '1';
    }
    
    public function getFechaHoraCreacion(){
      return Fecha::formatoFechaHoraParaVistas($this->fechaHoraCreacion);
    }
    public function getFechaHoraEjecucion(){
      return Fecha::formatoFechaHoraParaVistas($this->fechaHoraEjecucion);
    }


    
}
