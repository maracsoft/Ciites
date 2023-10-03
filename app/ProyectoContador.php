<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProyectoContador extends Model
{
    public $timestamps = false;

    public $table = 'proyecto_contador';

    protected $primaryKey = 'codProyectoContador';

    protected $fillable = [
        'codEmpleadoContador','codProyecto'
    ];

    public function getContador(){
        return Empleado::findOrFail($this->codEmpleadoContador);
    }
    public function getProyecto(){

        return Proyecto::findOrFail($this->codProyecto);
    }

    public static function verificarExistencia($codProyecto,$codEmpleado): bool {
      $search = ProyectoContador::where('codEmpleadoContador','=',$codEmpleado)->where('codProyecto',$codProyecto)->get();
      if(count($search) == 0){
        return false;
      }

      return true;

    }
}
