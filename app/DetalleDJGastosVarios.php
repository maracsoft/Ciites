<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codDetalleVarios int(11)     
 * @property string $fecha date     
 * @property string $concepto varchar(200)     
 * @property float $importe float     
 * @property int $codDJGastosVarios int(11)     
 * @method static DetalleDJGastosVarios findOrFail($primary_key)
 * @method static DetalleDJGastosVarios | null find($primary_key)
 * @method static DetalleDJGastosVariosCollection all()
 * @method static \App\Builders\DetalleDJGastosVariosBuilder query()
 * @method static \App\Builders\DetalleDJGastosVariosBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\DetalleDJGastosVariosBuilder where(string $column,string $value)
 * @method static \App\Builders\DetalleDJGastosVariosBuilder whereNotNull(string $column) 
 * @method static \App\Builders\DetalleDJGastosVariosBuilder whereNull(string $column) 
 * @method static \App\Builders\DetalleDJGastosVariosBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\DetalleDJGastosVariosBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class DetalleDJGastosVarios extends MaracModel
{
  public $table = "detalle_dj_gastosvarios";
  protected $primaryKey = "codDetalleVarios";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['fecha', 'concepto', 'importe', 'codDJGastosVarios'];

  public function getFecha()
  {
    return date("d/m/Y", strtotime($this->fecha));


    //return str_replace('-','/',$this->fecha);

  }
}
