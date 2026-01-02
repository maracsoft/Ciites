<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codEstadoRequerimiento int(11)     
 * @property string $nombre varchar(50)     
 * @property int $ordenListadoEmpleado int(11)     
 * @property int $ordenListadoGerente int(11)     
 * @property int $ordenListadoAdministrador int(11)     
 * @property int $ordenListadoContador int(11)     
 * @method static EstadoRequerimientoBS findOrFail($primary_key)
 * @method static EstadoRequerimientoBS | null find($primary_key)
 * @method static EstadoRequerimientoBSCollection all()
 * @method static \App\Builders\EstadoRequerimientoBSBuilder query()
 * @method static \App\Builders\EstadoRequerimientoBSBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\EstadoRequerimientoBSBuilder where(string $column,string $value)
 * @method static \App\Builders\EstadoRequerimientoBSBuilder whereNotNull(string $column) 
 * @method static \App\Builders\EstadoRequerimientoBSBuilder whereNull(string $column) 
 * @method static \App\Builders\EstadoRequerimientoBSBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\EstadoRequerimientoBSBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class EstadoRequerimientoBS extends MaracModel
{
  public $table = "estado_requerimiento_bs";
  protected $primaryKey = "codEstadoRequerimiento";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['codEstadoRequerimiento', 'nombre'];
}
