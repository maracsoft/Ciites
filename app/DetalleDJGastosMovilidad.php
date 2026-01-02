<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codDetalleMovilidad int(11)     
 * @property string $fecha date     
 * @property string $lugar varchar(200)     
 * @property string $detalle varchar(200)     
 * @property float $importe float     
 * @property int $codDJGastosMovilidad int(11)     
 * @method static DetalleDJGastosMovilidad findOrFail($primary_key)
 * @method static DetalleDJGastosMovilidad | null find($primary_key)
 * @method static DetalleDJGastosMovilidadCollection all()
 * @method static \App\Builders\DetalleDJGastosMovilidadBuilder query()
 * @method static \App\Builders\DetalleDJGastosMovilidadBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\DetalleDJGastosMovilidadBuilder where(string $column,string $value)
 * @method static \App\Builders\DetalleDJGastosMovilidadBuilder whereNotNull(string $column) 
 * @method static \App\Builders\DetalleDJGastosMovilidadBuilder whereNull(string $column) 
 * @method static \App\Builders\DetalleDJGastosMovilidadBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\DetalleDJGastosMovilidadBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class DetalleDJGastosMovilidad extends MaracModel
{
  public $table = "detalle_dj_gastosmovilidad";
  protected $primaryKey = "codDetalleMovilidad";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['fecha', 'lugar', 'detalle', 'importe', 'codDJGastosMovilidad'];

  public function getFecha()
  {
    return date("d/m/Y", strtotime($this->fecha));
    //return str_replace('-','/',$this->fecha);
  }
}
