<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codMoneda int(11)     
 * @property string $nombre varchar(10)     
 * @property string $abreviatura varchar(10)     
 * @property string $simbolo varchar(10)     
 * @method static Moneda findOrFail($primary_key)
 * @method static Moneda | null find($primary_key)
 * @method static MonedaCollection all()
 * @method static \App\Builders\MonedaBuilder query()
 * @method static \App\Builders\MonedaBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\MonedaBuilder where(string $column,string $value)
 * @method static \App\Builders\MonedaBuilder whereNotNull(string $column) 
 * @method static \App\Builders\MonedaBuilder whereNull(string $column) 
 * @method static \App\Builders\MonedaBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\MonedaBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class Moneda extends MaracModel
{
  public $timestamps = false;

  public $table = 'moneda';

  protected $primaryKey = 'codMoneda';

  protected $fillable = [
    'nombre',
    'abreviatura',
    'simbolo'
  ];
}
