<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codTipoCDP int(11)     
 * @property string $nombreCDP varchar(200)     
 * @property int $codigoSUNAT tinyint(4)     
 * @method static CDP findOrFail($primary_key)
 * @method static CDP | null find($primary_key)
 * @method static CDPCollection all()
 * @method static \App\Builders\CDPBuilder query()
 * @method static \App\Builders\CDPBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\CDPBuilder where(string $column,string $value)
 * @method static \App\Builders\CDPBuilder whereNotNull(string $column) 
 * @method static \App\Builders\CDPBuilder whereNull(string $column) 
 * @method static \App\Builders\CDPBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\CDPBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class CDP extends MaracModel
{
  public $table = "cdp";
  protected $primaryKey = "codTipoCDP";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['nombreCDP', 'codigoSUNAT'];

  public static function getNombre($codTipoCDP)
  {
    return CDP::findOrFail($codTipoCDP)->nombre;
  }
}
