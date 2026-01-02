<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codMesAño int(11)     
 * @property int $año int(11)     
 * @property int $codMes int(11)     
 * @method static MesAño findOrFail($primary_key)
 * @method static MesAño | null find($primary_key)
 * @method static MesAñoCollection all()
 * @method static \App\Builders\MesAñoBuilder query()
 * @method static \App\Builders\MesAñoBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\MesAñoBuilder where(string $column,string $value)
 * @method static \App\Builders\MesAñoBuilder whereNotNull(string $column) 
 * @method static \App\Builders\MesAñoBuilder whereNull(string $column) 
 * @method static \App\Builders\MesAñoBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\MesAñoBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class MesAño extends MaracModel
{
  public $timestamps = false;

  public $table = 'mes_anio';

  protected $primaryKey = 'codMesAño';

  protected $fillable = [];

  function  getMes()
  {
    return Mes::findOrFail($this->codMes);
  }

  /* Retorna Marzo 2022 */
  function  getTexto()
  {

    $mes = $this->getMes();
    return $mes->nombre . " " . $this->año;
  }

  static function getActual()
  {
    $añoActual = date("Y");
    $mesActual = intval(date("m"));

    return MesAño::where('codMes', $mesActual)->where('año', $añoActual)->get()[0];
  }

  public static function getMesesDeEsteAñoYAnterior()
  {
    $añoActual = date("Y");
    $añoAnterior = $añoActual - 1;
    $array = [$añoActual, $añoAnterior];

    $lista = MesAño::whereIn('año', $array)->get();

    foreach ($lista as $elem) {
      $elem['texto'] = $elem->getTexto();
    }

    return $lista;
  }
}
