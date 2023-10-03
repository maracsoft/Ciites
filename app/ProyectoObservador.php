<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProyectoObservador extends Model
{
    public $timestamps = false;
    public $table = 'proyecto_observador';
    protected $primaryKey = 'codProyectoObservador';
    protected $fillable = [];


    public function getObservador() : Empleado{
        return Empleado::findOrFail($this->codEmpleadoObservador);
    }
    public function getProyecto() : Proyecto {
        return Proyecto::findOrFail($this->codProyecto);
    }

    public static function verificarExistencia($codProyecto,$codEmpleado): bool {
      $search = ProyectoObservador::where('codEmpleadoObservador','=',$codEmpleado)->where('codProyecto',$codProyecto)->get();
      if(count($search) == 0){
        return false;
      }

      return true;
    }

}
