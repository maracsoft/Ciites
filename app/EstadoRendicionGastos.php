<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codEstadoRendicion int(11)     
 * @property string $nombre varchar(100)     
 * @property int $ordenListadoEmpleado int(11)     
 * @property int $ordenListadoGerente int(11)     
 * @property int $ordenListadoAdministrador int(11)     
 * @property int $ordenListadoContador int(11)     
 * @method static EstadoRendicionGastos findOrFail($primary_key)
 * @method static EstadoRendicionGastos | null find($primary_key)
 * @method static EstadoRendicionGastosCollection all()
 * @method static \App\Builders\EstadoRendicionGastosBuilder query()
 * @method static \App\Builders\EstadoRendicionGastosBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\EstadoRendicionGastosBuilder where(string $column,string $value)
 * @method static \App\Builders\EstadoRendicionGastosBuilder whereNotNull(string $column) 
 * @method static \App\Builders\EstadoRendicionGastosBuilder whereNull(string $column) 
 * @method static \App\Builders\EstadoRendicionGastosBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\EstadoRendicionGastosBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class EstadoRendicionGastos extends MaracModel
{
  public $table = "estado_rendicion_gastos";
  protected $primaryKey = "codEstadoRendicion";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['nombre'];
}
