<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpleadoPuesto extends Model
{
    protected $table = "empleado_puesto";
    protected $primaryKey ="codEmpleadoPuesto";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = [];
    

    function getEmpleado(){
        return Empleado::findOrFail($this->codEmpleado);
    }

    function getPuesto(){
        return Puesto::findOrFail($this->codPuesto);
    }


    /* 
      Retorna el nuevo estado
    */
    public static function togleEmpleadoPuesto(Empleado $empleado,Puesto $puesto) : bool{
      //verificamos existencia
      $lista = EmpleadoPuesto::where('codPuesto',$puesto->getId())->where('codEmpleado',$empleado->getId())->get();
      if(count($lista) == 0){//no existe, la creamos
        $nuevo = new EmpleadoPuesto();
        $nuevo->codPuesto = $puesto->codPuesto;
        $nuevo->codEmpleado = $empleado->codEmpleado;
        $nuevo->save();

        return true;
      }else{ //si existe, la destruimos
        $lista[0]->delete();
        return false;
      }

    }

}

