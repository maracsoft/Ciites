<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpleadoRevisador extends Model
{
    public $table = "inv-empleado_revisador";
    protected $primaryKey ="codEmpleadoRevisador";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

    
    // le indicamos los campos de la tabla 
    protected $fillable = ['codRevision','codEmpleado'];


    public function getEmpleado(){

        return Empleado::findOrFail($this->codEmpleado);
    }

    public function getRevision(){
        return RevisionInventario::findOrFail($this->codRevision);
    }

    public function getSede(){

        return Sede::findOrFail($this->codSede);
    }

}
