<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property string $fechaHoraCreacion datetime     
 * @property string $domicilio varchar(200)     
 * @property float $importeTotal float     
 * @property int $codMoneda int(11)     
 * @property int $codEmpleado int(11)     
 * @property int $codDJGastosMovilidad int(11)     
 * @property string $codigoCedepas varchar(50)     
 * @method static DJGastosMovilidad findOrFail($primary_key)
 * @method static DJGastosMovilidad | null find($primary_key)
 * @method static DJGastosMovilidadCollection all()
 * @method static \App\Builders\DJGastosMovilidadBuilder query()
 * @method static \App\Builders\DJGastosMovilidadBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\DJGastosMovilidadBuilder where(string $column,string $value)
 * @method static \App\Builders\DJGastosMovilidadBuilder whereNotNull(string $column) 
 * @method static \App\Builders\DJGastosMovilidadBuilder whereNull(string $column) 
 * @method static \App\Builders\DJGastosMovilidadBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\DJGastosMovilidadBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class DJGastosMovilidad extends MaracModel
{
  public $table = "dj_gastosmovilidad";
  protected $primaryKey = "codDJGastosMovilidad";

  public $timestamps = false;  //para que no trabaje con los campos fecha

  const RaizCodigoCedepas = "MOV";

  // le indicamos los campos de la tabla
  protected $fillable = ['fechaHoraCreacion', 'domicilio', 'importeTotal', 'codMoneda', 'codEmpleado'];

  public function getTotalFormateado()
  {
    return $this->getMoneda()->simbolo . " " . number_format($this->importeTotal, 2);
  }

  public function getPDF()
  {
    $listaItems = DetalleDJGastosMovilidad::where('codDJGastosMovilidad', '=', $this->codDJGastosMovilidad)->get();
    $pdf = \PDF::loadview(
      'DJ.Movilidad.PdfDJMov',
      array('DJ' => $this, 'listaItems' => $listaItems)
    )->setPaper('a4', 'portrait');

    return $pdf;
  }

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
    return $this->getMoneda()->simbolo . ' ' . $this->importeTotal;
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

    return DetalleDJGastosMovilidad::where('codDJGastosMovilidad', '=', $this->codDJGastosMovilidad)->get();
  }

  public static function calcularCodigoCedepasLibre()
  {
    $objNumeracion = Numeracion::getNumeracionDJ_MOV();
    return  DJGastosMovilidad::RaizCodigoCedepas .
      substr($objNumeracion->año, 2, 2) .
      '-' .
      DJGastosMovilidad::rellernarCerosIzq($objNumeracion->numeroLibreActual, 4);
  }


  public static function rellernarCerosIzq($numero, $nDigitos)
  {
    return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);
  }


  //para pdf
  public function getFechaHoraCreacion()
  {
    return date("d/m/Y h:i:s", strtotime($this->fechaHoraCreacion));
  }
}
