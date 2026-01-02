<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codTipoFinanciamiento int(11)     
 * @property string $nombre varchar(100)     
 * @method static TipoFinanciamiento findOrFail($primary_key)
 * @method static TipoFinanciamiento | null find($primary_key)
 * @method static TipoFinanciamientoCollection all()
 * @method static \App\Builders\TipoFinanciamientoBuilder query()
 * @method static \App\Builders\TipoFinanciamientoBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\TipoFinanciamientoBuilder where(string $column,string $value)
 * @method static \App\Builders\TipoFinanciamientoBuilder whereNotNull(string $column) 
 * @method static \App\Builders\TipoFinanciamientoBuilder whereNull(string $column) 
 * @method static \App\Builders\TipoFinanciamientoBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\TipoFinanciamientoBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class TipoFinanciamiento extends MaracModel
{


  public $table = "tipo_financiamiento";
  protected $primaryKey = "codTipoFinanciamiento";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['nombre'];
}
