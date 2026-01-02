<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codTipoArchivoProyecto int(11)     
 * @property string $nombre varchar(300)     
 * @method static TipoArchivoProyecto findOrFail($primary_key)
 * @method static TipoArchivoProyecto | null find($primary_key)
 * @method static TipoArchivoProyectoCollection all()
 * @method static \App\Builders\TipoArchivoProyectoBuilder query()
 * @method static \App\Builders\TipoArchivoProyectoBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\TipoArchivoProyectoBuilder where(string $column,string $value)
 * @method static \App\Builders\TipoArchivoProyectoBuilder whereNotNull(string $column) 
 * @method static \App\Builders\TipoArchivoProyectoBuilder whereNull(string $column) 
 * @method static \App\Builders\TipoArchivoProyectoBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\TipoArchivoProyectoBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class TipoArchivoProyecto extends MaracModel
{

  public $table = "tipo_archivo_proyecto";
  protected $primaryKey = "codTipoArchivoProyecto";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['nombre'];
}
