<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codTipoParametro int(11)     
 * @property string $nombre varchar(100)     
 * @property string $componente_frontend varchar(100)     
 * @property string $comentario varchar(200)     
 * @method static TipoParametroSistema findOrFail($primary_key)
 * @method static TipoParametroSistema | null find($primary_key)
 * @method static TipoParametroSistemaCollection all()
 * @method static \App\Builders\TipoParametroSistemaBuilder query()
 * @method static \App\Builders\TipoParametroSistemaBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\TipoParametroSistemaBuilder where(string $column,string $value)
 * @method static \App\Builders\TipoParametroSistemaBuilder whereNotNull(string $column) 
 * @method static \App\Builders\TipoParametroSistemaBuilder whereNull(string $column) 
 * @method static \App\Builders\TipoParametroSistemaBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\TipoParametroSistemaBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class TipoParametroSistema extends MaracModel
{


  public $timestamps = false;
  public $table = 'tipo_parametro_sistema';

  protected $primaryKey = 'codTipoParametro';
  protected $fillable = [''];
}
