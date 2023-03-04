<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    public $table = "provincia";
    protected $primaryKey ="codProvincia";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['nombre','codDepartamento'];

    public function getDepartamento(){
        return Departamento::findOrFail($this->codDepartamento); 
    }

    public function getDistritos(){
        return Distrito::where('codProvincia',$this->codProvincia)->get();

    }
}
