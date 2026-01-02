<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codEstadoReposicion int(11)     
 * @property string $nombre varchar(100)     
 * @property int $ordenListadoEmpleado int(11)     
 * @property int $ordenListadoGerente int(11)     
 * @property int $ordenListadoAdministrador int(11)     
 * @property int $ordenListadoContador int(11)     
 * @method static EstadoReposicionGastos findOrFail($primary_key)
 * @method static EstadoReposicionGastos | null find($primary_key)
 * @method static EstadoReposicionGastosCollection all()
 * @method static \App\Builders\EstadoReposicionGastosBuilder query()
 * @method static \App\Builders\EstadoReposicionGastosBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\EstadoReposicionGastosBuilder where(string $column,string $value)
 * @method static \App\Builders\EstadoReposicionGastosBuilder whereNotNull(string $column) 
 * @method static \App\Builders\EstadoReposicionGastosBuilder whereNull(string $column) 
 * @method static \App\Builders\EstadoReposicionGastosBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\EstadoReposicionGastosBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class EstadoReposicionGastos extends MaracModel
{
  public $table = "estado_reposicion_gastos";
  protected $primaryKey = "codEstadoReposicion";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['nombre'];
}
