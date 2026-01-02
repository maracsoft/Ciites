<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codTipoOperacion int(11)     
 * @property int $codTipoDocumento int(11)     
 * @property string $nombre varchar(50)     
 * @method static TipoOperacion findOrFail($primary_key)
 * @method static TipoOperacion | null find($primary_key)
 * @method static TipoOperacionCollection all()
 * @method static \App\Builders\TipoOperacionBuilder query()
 * @method static \App\Builders\TipoOperacionBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\TipoOperacionBuilder where(string $column,string $value)
 * @method static \App\Builders\TipoOperacionBuilder whereNotNull(string $column) 
 * @method static \App\Builders\TipoOperacionBuilder whereNull(string $column) 
 * @method static \App\Builders\TipoOperacionBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\TipoOperacionBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class TipoOperacion extends MaracModel
{
  public $table = "tipo_operacion";
  protected $primaryKey = "codTipoOperacion";

  public $timestamps = false;  //para que no trabaje con los campos fecha

  public function getTipoDocumento()
  {
    return TipoDocumento::findOrFail($this->codTipoDocumento);
  }

  public static function getCodTipoOperacion($abreviacion, $nombreTipoOperacion)
  {
    $tipoDoc = TipoDocumento::where('abreviacion', '=', $abreviacion)->get()[0];
    $tipoOperacion = TipoOperacion::where('codTipoDocumento', '=', $tipoDoc->codTipoDocumento)
      ->where('nombre', '=', $nombreTipoOperacion)
      ->get()[0];

    return $tipoOperacion->codTipoOperacion;
  }
}
