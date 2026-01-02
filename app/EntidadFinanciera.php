<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codEntidadFinanciera int(11)     
 * @property string $nombre varchar(200)     
 * @method static EntidadFinanciera findOrFail($primary_key)
 * @method static EntidadFinanciera | null find($primary_key)
 * @method static EntidadFinancieraCollection all()
 * @method static \App\Builders\EntidadFinancieraBuilder query()
 * @method static \App\Builders\EntidadFinancieraBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\EntidadFinancieraBuilder where(string $column,string $value)
 * @method static \App\Builders\EntidadFinancieraBuilder whereNotNull(string $column) 
 * @method static \App\Builders\EntidadFinancieraBuilder whereNull(string $column) 
 * @method static \App\Builders\EntidadFinancieraBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\EntidadFinancieraBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class EntidadFinanciera extends MaracModel
{



  public $table = "entidad_financiera";
  protected $primaryKey = "codEntidadFinanciera";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['nombre'];
}
