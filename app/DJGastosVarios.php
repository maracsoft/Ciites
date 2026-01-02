<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codDJGastosVarios int(11)     
 * @property string $fechaHoraCreacion datetime     
 * @property string $domicilio varchar(200)     
 * @property float $importeTotal float     
 * @property int $codMoneda int(11)     
 * @property int $codEmpleado int(11)     
 * @property string $codigoCedepas varchar(50)     
 * @method static DJGastosVarios findOrFail($primary_key)
 * @method static DJGastosVarios | null find($primary_key)
 * @method static DJGastosVariosCollection all()
 * @method static \App\Builders\DJGastosVariosBuilder query()
 * @method static \App\Builders\DJGastosVariosBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\DJGastosVariosBuilder where(string $column,string $value)
 * @method static \App\Builders\DJGastosVariosBuilder whereNotNull(string $column) 
 * @method static \App\Builders\DJGastosVariosBuilder whereNull(string $column) 
 * @method static \App\Builders\DJGastosVariosBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\DJGastosVariosBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class DJGastosVarios extends MaracModel
{
  public $table = "dj_gastosvarios";
  protected $primaryKey = "codDJGastosVarios";

  const RaizCodigoCedepas = "VAR";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['fechaHoraCreacion', 'domicilio', 'importeTotal', 'codMoneda', 'codEmpleado'];

  public function getEmpleado()
  {
    return Empleado::findOrFail($this->codEmpleado);
  }

  public function getMoneda()
  {
    return Moneda::findOrFail($this->codMoneda);
  }

  public function getMontoConMoneda()
  {
    return $this->getMoneda()->simbolo . ' ' . number_format($this->importeTotal, 2);
  }

  public function getDetallesAbreviados()
  {

    $cadena = "";
    $cadenaTemp = "";
    foreach ($this->getDetalles() as $det) {
      $cadenaTemp = $cadenaTemp . ", " . $det->concepto;
      if (strlen($cadenaTemp) > 140) {
        break;
      }
      $cadena = $cadena . ", " . $det->concepto;
    }

    $cadena = trim($cadena, ",");
    return $cadena;
  }
  public function getDetalles()
  {
    return DetalleDJGastosVarios::where('codDJGastosVarios', '=', $this->codDJGastosVarios)->get();
  }

  public static function calcularCodigoCedepasLibre()
  {
    $objNumeracion = Numeracion::getNumeracionDJ_VAR();
    return  DJGastosVarios::RaizCodigoCedepas .
      substr($objNumeracion->año, 2, 2) .
      '-' .
      DJGastosVarios::rellernarCerosIzq($objNumeracion->numeroLibreActual, 4);
  }
  public static function rellernarCerosIzq($numero, $nDigitos)
  {
    return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);
  }

  public function getPDF()
  {
    $listaItems = DetalleDJGastosVarios::where('codDJGastosVarios', '=', $this->codDJGastosVarios)->get();
    $pdf = \PDF::loadview(
      'DJ.Varios.PdfDJVar',
      array('DJ' => $this, 'listaItems' => $listaItems)
    )->setPaper('a4', 'portrait');

    return $pdf;
  }

  public function getFechaHoraCreacion()
  {
    //return $this->fechaHoraCreacion;
    return date("d/m/Y h:i:s", strtotime($this->fechaHoraCreacion));
  }
}
