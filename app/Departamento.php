<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Departamento extends Model
{
    public $table = "departamento";
    protected $primaryKey ="codDepartamento";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['nombre'];


    public function getProvincias(){
        return Provincia::where('codDepartamento',$this->codDepartamento)->get();

    }


    /* Obtiene en un array todos los cod distritos del departamento */
    public function getArrayCodDistritos(){

        $codDepartamento = $this->getId();
        //  -- Consulta para obtener todos los codDistrito de un departamento
        $listaDistritos = DB::select("
        select DI.codDistrito as 'codDistrito' from distrito DI
            inner join provincia P on P.codProvincia = DI.codProvincia
            inner join departamento DEP on DEP.codDepartamento = P.codDepartamento
            where DEP.codDepartamento = $codDepartamento"
        );

        return array_column($listaDistritos,'codDistrito');

    }
}
