<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codDetalleRendicion int(11)     
 * @property int $codRendicionGastos int(11)     
 * @property string $fecha date     
 * @property string $nroComprobante varchar(200)     
 * @property string $concepto varchar(500)     
 * @property float $importe float     
 * @property string $codigoPresupuestal varchar(200)     
 * @property int $codTipoCDP int(11)     
 * @property string $terminacionArchivo varchar(10) NULLABLE    
 * @property int $nroEnRendicion int(11)     
 * @property int $contabilizado tinyint(4) NULLABLE    
 * @property int $pendienteDeVer int(11)     
 * @method static DetalleRendicionGastos findOrFail($primary_key)
 * @method static DetalleRendicionGastos | null find($primary_key)
 * @method static DetalleRendicionGastosCollection all()
 * @method static \App\Builders\DetalleRendicionGastosBuilder query()
 * @method static \App\Builders\DetalleRendicionGastosBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\DetalleRendicionGastosBuilder where(string $column,string $value)
 * @method static \App\Builders\DetalleRendicionGastosBuilder whereNotNull(string $column) 
 * @method static \App\Builders\DetalleRendicionGastosBuilder whereNull(string $column) 
 * @method static \App\Builders\DetalleRendicionGastosBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\DetalleRendicionGastosBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class DetalleRendicionGastos extends MaracModel
{
  public $table = "detalle_rendicion_gastos";
  protected $primaryKey = "codDetalleRendicion";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = [
    'codRendicionGastos',
    'fecha',
    'nroComprobante',
    'concepto',
    'importe',
    'codigoPresupuestal',
    'codTipoCDP',
    'nroEnRendicion',
    'contabilizado'
  ];

  public function getFecha()
  {

    return Fecha::formatoParaVistas($this->fecha);
  }

  public function getRendicion()
  {
    return RendicionGastos::findOrFail($this->codRendicionGastos);
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

  public function getColor()
  {

    $a = $this->getRendicion()->codRendicionGastos;
    $b = $this->getRendicion()->totalImporteRecibido;
    $c = $this->getRendicion()->totalImporteRendido;


    $R = 5222 * $a + 7001 * $b * $a + 1275 * $c;
    $G = $a + $b * 9899 + 12878 * $c * $b;
    $B = 1500 * $a + $b + 1625 * $c * $a;


    $R = ($R + 170) % 255;
    $G = ($G + 170) % 255;
    $B = ($B + 170) % 255;

    $color = "rgb(" . $R . "," . $G . "," . $B . ")";

    return $color;
  }


  //retorna background-color:red si es que la rend ya está contabilizdaa y ese gasto no lo está
  public function getEstadoDeAlerta()
  {
    if ($this->getRendicion()->verificarEstado('Contabilizada') && $this->contabilizado == 0)
      return "background-color:red";

    return "";
  }



  /* Convierte el objeto en un vector con elementos leibles directamente por la API */
  public function getVectorParaAPI()
  {
    $itemActual = $this;
    $itemActual['fechaFormateada'] = $this->getFecha();
    $itemActual['nombreCDP'] = $this->getNombreTipoCDP();

    return $itemActual;
  }
}
