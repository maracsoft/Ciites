<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codNacionalidad int(11)     
 * @property string $nombre varchar(200)     
 * @property string $pais varchar(200)     
 * @property string $abreviacion varchar(10)     
 * @method static Nacionalidad findOrFail($primary_key)
 * @method static Nacionalidad | null find($primary_key)
 * @method static NacionalidadCollection all()
 * @method static \App\Builders\NacionalidadBuilder query()
 * @method static \App\Builders\NacionalidadBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\NacionalidadBuilder where(string $column,string $value)
 * @method static \App\Builders\NacionalidadBuilder whereNotNull(string $column) 
 * @method static \App\Builders\NacionalidadBuilder whereNull(string $column) 
 * @method static \App\Builders\NacionalidadBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\NacionalidadBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class Nacionalidad extends MaracModel
{
  public $table = "nacionalidad";
  protected $primaryKey = "codNacionalidad";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['codTipoFinanciamiento'];
}
