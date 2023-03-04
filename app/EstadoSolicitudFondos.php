<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoSolicitudFondos extends Model
{
    public $table = "estado_solicitud_fondos";
    protected $primaryKey ="codEstadoSolicitud";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['nombre'];


    
}
