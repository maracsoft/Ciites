<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codUnidadMedida int(11)     
 * @property string $nombre varchar(50)     
 * @method static UnidadMedida findOrFail($primary_key)
 * @method static UnidadMedida | null find($primary_key)
 * @method static UnidadMedidaCollection all()
 * @method static \App\Builders\UnidadMedidaBuilder query()
 * @method static \App\Builders\UnidadMedidaBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\UnidadMedidaBuilder where(string $column,string $value)
 * @method static \App\Builders\UnidadMedidaBuilder whereNotNull(string $column) 
 * @method static \App\Builders\UnidadMedidaBuilder whereNull(string $column) 
 * @method static \App\Builders\UnidadMedidaBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\UnidadMedidaBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class UnidadMedida extends MaracModel
{

  public $table = "unidad_medida";
  protected $primaryKey = "codUnidadMedida";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['codUnidadMedida', 'nombre'];
}
