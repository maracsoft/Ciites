<?php

namespace App;

use App\Utils\Fecha;
use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codDetalleReposicion int(11)     
 * @property int $codReposicionGastos int(11)     
 * @property string $fechaComprobante date     
 * @property string $nroComprobante varchar(50)     
 * @property string $concepto varchar(250)     
 * @property float $importe float     
 * @property string $codigoPresupuestal varchar(50)     
 * @property int $nroEnReposicion int(11)     
 * @property int $codTipoCDP int(11)     
 * @property int $contabilizado tinyint(4) NULLABLE    
 * @property int $pendienteDeVer int(11)     
 * @method static DetalleReposicionGastos findOrFail($primary_key)
 * @method static DetalleReposicionGastos | null find($primary_key)
 * @method static DetalleReposicionGastosCollection all()
 * @method static \App\Builders\DetalleReposicionGastosBuilder query()
 * @method static \App\Builders\DetalleReposicionGastosBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\DetalleReposicionGastosBuilder where(string $column,string $value)
 * @method static \App\Builders\DetalleReposicionGastosBuilder whereNotNull(string $column) 
 * @method static \App\Builders\DetalleReposicionGastosBuilder whereNull(string $column) 
 * @method static \App\Builders\DetalleReposicionGastosBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\DetalleReposicionGastosBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class DetalleReposicionGastos extends MaracModel
{
  public $table = "detalle_reposicion_gastos";
  protected $primaryKey = "codDetalleReposicion";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = [
    'codReposicionGastos',
    'fechaComprobante',
    'nroComprobante',
    'nroEnReposicion',
    'concepto',
    'importe',
    'codigoPresupuestal',
    'codTipoCDP',
    'nroEnRendicion',
    'pendienteDeVer',
    'contabilizado'
  ];


  public function getReposicion()
  {
    return ReposicionGastos::findOrFail($this->codReposicionGastos);
  }

  public function getColor()
  {

    $a = $this->getReposicion()->codReposicionGastos;
    $b = $this->getReposicion()->totalImporte;
    $c = $this->getReposicion()->codEmpleadoSolicitante;


    $R = 5222 * $a + 7001 * $b * $a + 1275 * $c;
    $G = $a + $b * 9899 + 12878 * $c * $b;
    $B = 1500 * $a + $b + 1625 * $c * $a;


    $R = ($R + 170) % 255;
    $G = ($G + 170) % 255;
    $B = ($B + 170) % 255;

    $color = "rgb(" . $R . "," . $G . "," . $B . ")";

    return $color;
  }


  public function setTipoCDPPorNombre($nombreCDP)
  {
    $listacdp = CDP::where('nombreCDP', '=', $nombreCDP)->get();
    $cdp = $listacdp[0];
    $this->codTipoCDP = $cdp->codTipoCDP;
  }
  public function getNombreTipoCDP()
  {
    $cdp = CDP::findOrFail($this->codTipoCDP);
    return $cdp->nombreCDP;
  }

  public function getCDP()
  {
    return CDP::findOrFail($this->codTipoCDP);
  }



  public function getContabilizado()
  {
    if ($this->contabilizado)
      return "SÍ";
    return "NO";
  }



  //retorna background-color:red si es que la rend ya está contabilizdaa y ese gasto no lo está
  public function getEstadoDeAlerta()
  {
    if ($this->getReposicion()->verificarEstado('Contabilizada') && $this->contabilizado == 0)
      return "background-color:rgb(223, 117, 117);";

    return "";
  }




  public function getFechaComprobante()
  {

    return Fecha::formatoParaVistas($this->fechaComprobante);
  }

  /* Convierte el objeto en un vector con elementos leibles directamente por la API */
  public function getVectorParaAPI()
  {
    $itemActual = $this;
    $itemActual['fechaFormateada'] = $this->getFechaComprobante();
    $itemActual['nombreCDP'] = $this->getNombreTipoCDP();

    return $itemActual;
  }
}
