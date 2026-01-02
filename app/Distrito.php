<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
//START MODEL_HELPER
/**
 * @property int $codDistrito int(11)     
 * @property string $nombre varchar(50)     
 * @property int $codProvincia int(11)     
 * @method static Distrito findOrFail($primary_key)
 * @method static Distrito | null find($primary_key)
 * @method static DistritoCollection all()
 * @method static \App\Builders\DistritoBuilder query()
 * @method static \App\Builders\DistritoBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\DistritoBuilder where(string $column,string $value)
 * @method static \App\Builders\DistritoBuilder whereNotNull(string $column) 
 * @method static \App\Builders\DistritoBuilder whereNull(string $column) 
 * @method static \App\Builders\DistritoBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\DistritoBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class Distrito extends MaracModel
{
  public $table = "distrito";
  protected $primaryKey = "codDistrito";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['nombre', 'codProvincia'];

  public function getProvincia()
  {
    return Provincia::findOrFail($this->codProvincia);
  }


  function getTextoUbicacion()
  {
    $dist = $this;
    $prov = $dist->getProvincia();
    $dep = $prov->getDepartamento();
    return $dep->nombre . " / " . $prov->nombre . " / " . $dist->nombre;
  }


  // SELECT nombre,count(codDistrito) FROM `distrito` group by nombre having count(codDistrito)>1
  public static function getDistritosNombresRepetidos()
  {
    $sqlResult = DB::select("SELECT nombre,count(codDistrito) FROM `distrito` group by nombre having count(codDistrito)>1");
    $arrayNombres = [];
    foreach ($sqlResult as $sqlRow) {
      array_push($arrayNombres, $sqlRow->nombre);
    }

    return Distrito::whereIn('nombre', $arrayNombres)->get();
  }

  public static function getArrayCodsDistritosNombresRepetidos()
  {
    $lista = Distrito::getDistritosNombresRepetidos();

    $arr = [];
    foreach ($lista as $dis) {
      array_push($arr, $dis->getId());
    }
    return $arr;
  }
}
