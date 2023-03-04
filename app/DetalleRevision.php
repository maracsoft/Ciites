<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleRevision extends Model
{
    public $table = "inv-detalle_revision";
    protected $primaryKey ="codDetalleRevision";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['codRevision','codActivo','codEstado','activo','seReviso'];

    function getActivo(){
        return ActivoInventario::findOrFail($this->codActivo);
    }
    function getEstado(){
        return EstadoActivoInventario::findOrFail($this->codEstado);
    }

    function getRevision(){
        return RevisionInventario::findOrFail($this->codRevision);
    }
    function getEmpleadoQueReviso(){
        return Empleado::findOrFail($this->codEmpleadoQueReviso);
    }
    function getRazonBaja(){

        return RazonBajaActivo::findOrFail($this->codRazonBaja);

    }
    
}
