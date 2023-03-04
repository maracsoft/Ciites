<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivoInventario extends Model
{
    public $timestamps = false;

    public $table = 'inv-activo_inventario';

    protected $primaryKey = 'codActivo';

    protected $fillable = [
        'codProyectoDestino','nombreDelBien','caracteristicas','codCategoriaActivo','codSede','placa','codEstado','codEmpleadoResponsable','activo'
    ];

    function getCategoria(){
        $categoria=CategoriaActivoInventario::find($this->codCategoriaActivo);
        return $categoria;
    }
    function getProyecto(){
        $proyecto=Proyecto::find($this->codProyecto);
        return $proyecto;
    }
    
    function getSede(){
        $sede=Sede::find($this->codSede);
        return $sede;
    }

    function getEstado(){
        return EstadoActivoInventario::find($this->codEstado);
    }

    function getResponsable(){
        return Empleado::find($this->codEmpleadoResponsable);
    }

    function getRazonBaja(){
        if($this->codRazonBaja=="")
            return "";
        
        return RazonBajaActivo::findOrFail($this->codRazonBaja);

    }
    
}
