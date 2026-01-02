<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codTipoArchivo int(11)     
 * @property string $nombre varchar(100)     
 * @method static TipoArchivoGeneral findOrFail($primary_key)
 * @method static TipoArchivoGeneral | null find($primary_key)
 * @method static TipoArchivoGeneralCollection all()
 * @method static \App\Builders\TipoArchivoGeneralBuilder query()
 * @method static \App\Builders\TipoArchivoGeneralBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\TipoArchivoGeneralBuilder where(string $column,string $value)
 * @method static \App\Builders\TipoArchivoGeneralBuilder whereNotNull(string $column) 
 * @method static \App\Builders\TipoArchivoGeneralBuilder whereNull(string $column) 
 * @method static \App\Builders\TipoArchivoGeneralBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\TipoArchivoGeneralBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class TipoArchivoGeneral extends MaracModel
{
  public $table = "tipo_archivo_general";
  protected $primaryKey = "codTipoArchivo";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = [];

  static function getCodigo($nombre)
  {
    return TipoArchivoGeneral::where('nombre', $nombre)->get()[0]->getId();
  }
}
