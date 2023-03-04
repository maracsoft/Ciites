<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Distrito extends Model
{
    public $table = "distrito";
    protected $primaryKey ="codDistrito";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['nombre','codProvincia'];

    public function getProvincia(){
        return Provincia::findOrFail($this->codProvincia); 
    }
    

    function getTextoUbicacion(){
        $dist = $this;
        $prov = $dist->getProvincia();
        $dep = $prov->getDepartamento();
        return $dep->nombre." / ".$prov->nombre." / ".$dist->nombre;

    } 


    // SELECT nombre,count(codDistrito) FROM `distrito` group by nombre having count(codDistrito)>1
    public static function getDistritosNombresRepetidos(){
        $sqlResult = DB::select("SELECT nombre,count(codDistrito) FROM `distrito` group by nombre having count(codDistrito)>1");
        $arrayNombres = [];
        foreach ($sqlResult as $sqlRow) {
            array_push($arrayNombres,$sqlRow->nombre);
        }

        return Distrito::whereIn('nombre',$arrayNombres)->get();
    }

    public static function getArrayCodsDistritosNombresRepetidos(){
        $lista = Distrito::getDistritosNombresRepetidos();
        
        $arr = [];
        foreach ($lista as $dis) {
            array_push($arr,$dis->getId());
        }
        return $arr;


    }

}
