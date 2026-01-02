<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codEstadoProyecto int(11)     
 * @property string $nombre varchar(100)     
 * @method static EstadoProyecto findOrFail($primary_key)
 * @method static EstadoProyecto | null find($primary_key)
 * @method static EstadoProyectoCollection all()
 * @method static \App\Builders\EstadoProyectoBuilder query()
 * @method static \App\Builders\EstadoProyectoBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\EstadoProyectoBuilder where(string $column,string $value)
 * @method static \App\Builders\EstadoProyectoBuilder whereNotNull(string $column) 
 * @method static \App\Builders\EstadoProyectoBuilder whereNull(string $column) 
 * @method static \App\Builders\EstadoProyectoBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\EstadoProyectoBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class EstadoProyecto extends MaracModel
{

  public $table = "estado_proyecto";
  protected $primaryKey = "codEstadoProyecto";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['codEstadoProyecto', 'nombre'];
}
