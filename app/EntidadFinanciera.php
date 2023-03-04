<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntidadFinanciera extends Model
{
    


    public $table = "entidad_financiera";
    protected $primaryKey ="codEntidadFinanciera";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['nombre'];



}
