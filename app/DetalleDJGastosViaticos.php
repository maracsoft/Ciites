<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codDetalleViaticos int(11)     
 * @property string $fecha date     
 * @property string $lugar varchar(200)     
 * @property float $montoDesayuno float     
 * @property float $montoAlmuerzo float     
 * @property float $montoCena float     
 * @property float $totalDia float     
 * @property int $codDJGastosViaticos int(11)     
 * @method static DetalleDJGastosViaticos findOrFail($primary_key)
 * @method static DetalleDJGastosViaticos | null find($primary_key)
 * @method static DetalleDJGastosViaticosCollection all()
 * @method static \App\Builders\DetalleDJGastosViaticosBuilder query()
 * @method static \App\Builders\DetalleDJGastosViaticosBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\DetalleDJGastosViaticosBuilder where(string $column,string $value)
 * @method static \App\Builders\DetalleDJGastosViaticosBuilder whereNotNull(string $column) 
 * @method static \App\Builders\DetalleDJGastosViaticosBuilder whereNull(string $column) 
 * @method static \App\Builders\DetalleDJGastosViaticosBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\DetalleDJGastosViaticosBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class DetalleDJGastosViaticos extends MaracModel
{
  public $table = "detalle_dj_gastosviaticos";
  protected $primaryKey = "codDetalleViaticos";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['fecha', 'lugar', 'montoDesayuno', 'montoAlmuerzo', 'montoCena', 'totalDia', 'codDJGastosViaticos'];

  public function getDJ()
  {
    return DJGastosViaticos::findOrFail($this->codDJGastosViaticos);
  }

  public function getMontoDesayunoFormateado()
  {
    return $this->getDJ()->getMoneda()->simbolo . " " . number_format($this->montoDesayuno, 2);
  }

  public function getMontoAlmuerzoFormateado()
  {
    return $this->getDJ()->getMoneda()->simbolo . " " . number_format($this->montoAlmuerzo, 2);
  }

  public function getMontoCenaFormateado()
  {
    return $this->getDJ()->getMoneda()->simbolo . " " . number_format($this->montoCena, 2);
  }

  public function getTotalDiaFormateado()
  {
    return $this->getDJ()->getMoneda()->simbolo . " " . number_format($this->totalDia, 2);
  }

  public function getFecha()
  {
    return date("d/m/Y", strtotime($this->fecha));
    //return str_replace('-','/',$this->fecha);
  }
}
