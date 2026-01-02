<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codDJGastosViaticos int(11)     
 * @property string $fechaHoraCreacion datetime     
 * @property string $domicilio varchar(200)     
 * @property float $importeTotal float     
 * @property int $codMoneda int(11)     
 * @property int $codEmpleado int(11)     
 * @property string $codigoCedepas varchar(50)     
 * @method static DJGastosViaticos findOrFail($primary_key)
 * @method static DJGastosViaticos | null find($primary_key)
 * @method static DJGastosViaticosCollection all()
 * @method static \App\Builders\DJGastosViaticosBuilder query()
 * @method static \App\Builders\DJGastosViaticosBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\DJGastosViaticosBuilder where(string $column,string $value)
 * @method static \App\Builders\DJGastosViaticosBuilder whereNotNull(string $column) 
 * @method static \App\Builders\DJGastosViaticosBuilder whereNull(string $column) 
 * @method static \App\Builders\DJGastosViaticosBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\DJGastosViaticosBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class DJGastosViaticos extends MaracModel
{
  public $table = "dj_gastosviaticos";
  protected $primaryKey = "codDJGastosViaticos";

  public $timestamps = false;  //para que no trabaje con los campos fecha

  // le indicamos los campos de la tabla
  protected $fillable = ['fechaHoraCreacion', 'domicilio', 'importeTotal', 'codMoneda', 'codEmpleado'];

  const RaizCodigoCedepas = "VIA";
  public function getEmpleado()
  {
    return Empleado::findOrFail($this->codEmpleado);
  }

  public function getMoneda()
  {
    return Moneda::findOrFail($this->codMoneda);
  }

  public static function calcularCodigoCedepasLibre()
  {
    $objNumeracion = Numeracion::getNumeracionDJ_VIA();
    return  DJGastosViaticos::RaizCodigoCedepas .
      substr($objNumeracion->año, 2, 2) .
      '-' .
      DJGastosViaticos::rellernarCerosIzq($objNumeracion->numeroLibreActual, 4);
  }
  public static function rellernarCerosIzq($numero, $nDigitos)
  {
    return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);
  }

  public function getMontoConMoneda()
  {
    return $this->getMoneda()->simbolo . ' ' . number_format($this->importeTotal, 2);
  }

  public function getDetallesAbreviados()
  {

    $cadena = "";
    foreach ($this->getDetalles() as $det) {
      $cadena = $cadena . ", " . $det->lugar;
    }

    $cadena = trim($cadena, ",");
    return $cadena;
  }

  public function getDetalles()
  {
    return DetalleDJGastosViaticos::where('codDJGastosViaticos', '=', $this->codDJGastosViaticos)->get();
  }

  public function getPDF()
  {
    $listaItems = DetalleDJGastosViaticos::where('codDJGastosViaticos', '=', $this->codDJGastosViaticos)->get();
    $pdf = \PDF::loadview(
      'DJ.Viaticos.PdfDJVia',
      array('DJ' => $this, 'listaItems' => $listaItems)
    )->setPaper('a4', 'portrait');

    return $pdf;
  }

  //para el pdf
  public function getFechaHoraCreacion()
  {
    return date("d/m/Y h:i:s", strtotime($this->fechaHoraCreacion));
  }
}
