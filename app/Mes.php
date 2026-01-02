<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codMes int(11)     
 * @property string $nombre varchar(30)     
 * @property string $abreviacion varchar(30)     
 * @property string $codDosDig varchar(2)     
 * @method static Mes findOrFail($primary_key)
 * @method static Mes | null find($primary_key)
 * @method static MesCollection all()
 * @method static \App\Builders\MesBuilder query()
 * @method static \App\Builders\MesBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\MesBuilder where(string $column,string $value)
 * @method static \App\Builders\MesBuilder whereNotNull(string $column) 
 * @method static \App\Builders\MesBuilder whereNull(string $column) 
 * @method static \App\Builders\MesBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\MesBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class Mes extends MaracModel
{
  public $timestamps = false;

  public $table = 'mes';

  protected $primaryKey = 'codMes';

  protected $fillable = ['nombre', 'abreviacion'];
}
