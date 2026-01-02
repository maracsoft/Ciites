<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codTipoDocumento int(11)     
 * @property string $nombre varchar(100)     
 * @property string $abreviacion varchar(10)     
 * @method static TipoDocumento findOrFail($primary_key)
 * @method static TipoDocumento | null find($primary_key)
 * @method static TipoDocumentoCollection all()
 * @method static \App\Builders\TipoDocumentoBuilder query()
 * @method static \App\Builders\TipoDocumentoBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\TipoDocumentoBuilder where(string $column,string $value)
 * @method static \App\Builders\TipoDocumentoBuilder whereNotNull(string $column) 
 * @method static \App\Builders\TipoDocumentoBuilder whereNull(string $column) 
 * @method static \App\Builders\TipoDocumentoBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\TipoDocumentoBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class TipoDocumento extends MaracModel
{
  public $table = "tipo_documento";
  protected $primaryKey = "codTipoDocumento";

  public $timestamps = false;  //para que no trabaje con los campos fecha

  public function getColor()
  {
    switch ($this->abreviacion) {
      case 'SOL':
        $color = "rgb(148, 186, 255)";
        break;
      case 'REN':
        $color = "rgb(255, 138, 138)";
        break;
      case 'REP':
        $color = "cyan";
        break;
      case 'REQ':
        $color = "rgb(155, 255, 146)";
        break;
    }
    return $color;
  }
}
