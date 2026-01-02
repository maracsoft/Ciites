<?php

namespace App;

use App\Http\Controllers\ArchivoGeneralController;
use App\Utils\Fecha;
use App\Utils\MaracUtils;
use DateTime;
use Dompdf\Dompdf;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
//START MODEL_HELPER
/**
 * @property int $codConstancia int(11)     
 * @property string $codigo_unico varchar(25)     
 * @property int $codEmpleadoCreador int(11)     
 * @property string $fechaHoraCreacion datetime     
 * @property int $codPeriodoDirector int(11)     
 * @property float $ultimo_sueldo_bruto float     
 * @property float $monto_ultima_grati float     
 * @property string $nombres varchar(200)     
 * @property string $apellidos varchar(200)     
 * @property string $dni varchar(20)     
 * @property string $fecha_deposito date     
 * @property string $nro_cuenta varchar(50)     
 * @property int $nro_meses_laborados int(11)     
 * @property int $nro_dias_laborados int(11)     
 * @property float $monto_total_cts float     
 * @property string $fecha_inicio date    del periodo 
 * @property string $fecha_fin date    del periodo 
 * @property string $fecha_emision date NULLABLE   emision formal del documento, no es la fecha de creacion del registro en bd. Es logica negocio 
 * @property string $nombre_banco varchar(300) NULLABLE    
 * @property float $promedio_otras_remuneraciones float     
 * @method static ConstanciaDepositoCTS findOrFail($primary_key)
 * @method static ConstanciaDepositoCTS | null find($primary_key)
 * @method static ConstanciaDepositoCTSCollection all()
 * @method static \App\Builders\ConstanciaDepositoCTSBuilder query()
 * @method static \App\Builders\ConstanciaDepositoCTSBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\ConstanciaDepositoCTSBuilder where(string $column,string $value)
 * @method static \App\Builders\ConstanciaDepositoCTSBuilder whereNotNull(string $column) 
 * @method static \App\Builders\ConstanciaDepositoCTSBuilder whereNull(string $column) 
 * @method static \App\Builders\ConstanciaDepositoCTSBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\ConstanciaDepositoCTSBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class ConstanciaDepositoCTS extends MaracModel
{
  public $timestamps = false;
  public $table = 'constancia_deposito_cts';

  protected $primaryKey = 'codConstancia';

  const RaizCodigoCedepas = 'CTS';

  protected $fillable = [];

  public function getNombreCompleto(): string
  {
    return $this->apellidos . " " . $this->nombres;
  }

  public static function calcularCodigoCedepasLibre(Numeracion $numeracion)
  {

    return Numeracion::ConstruirCodigoUnico(static::RaizCodigoCedepas, $numeracion, 4);
  }


  /* ojo esta no es la fechahora de creacion del registro en bd, sino la fecha 15 mayo o 15noviembre
  a escogerse en front en un select

  */
  public function getFechaHoraEmisionEscrita()
  {
    return Fecha::escribirEnTexto($this->fecha_emision);
  }
  public function getFechaHoraEmision()
  {
    return Fecha::formatoParaVistas($this->fecha_emision);
  }

  public function getAñoEmision()
  {
    return date("Y", strtotime($this->fecha_emision));
  }
  public function getCodMesEmision()
  {
    return date("n", strtotime($this->fecha_emision));
  }

  public function getEmpleadoCreador()
  {
    return Empleado::findOrFail($this->codEmpleadoCreador);
  }

  public function getFechaHoraCreacion()
  {
    return Fecha::formatoFechaHoraParaVistas($this->fechaHoraCreacion);
  }

  public function getFechaEscrita()
  {
    return Fecha::escribirEnTexto($this->fechaHoraCreacion);
  }

  public function getFechaDeposito()
  {
    return Fecha::formatoParaVistas($this->fecha_deposito);
  }



  public function getFechaInicio()
  {
    if ($this->fecha_inicio == "") {
      return "";
    }

    return Fecha::formatoParaVistas($this->fecha_inicio);
  }
  public function getFechaInicioEscrita()
  {
    if ($this->fecha_inicio == "") {
      return "";
    }

    return Fecha::escribirEnTexto($this->fecha_inicio);
  }

  public function getFechaFin()
  {
    if ($this->fecha_fin == "") {
      return "";
    }

    return Fecha::formatoParaVistas($this->fecha_fin);
  }
  public function getFechaFinEscrita()
  {
    if ($this->fecha_fin == "") {
      return "";
    }

    return Fecha::escribirEnTexto($this->fecha_fin);
  }



  public function getFechaDepositoEscrita()
  {
    return Fecha::escribirEnTexto($this->fecha_deposito);
  }
  /* retorna un objeto Dompdf configurado para los pdf */
  public function buildPdfPlantilla($html_rendered_view): Dompdf
  {


    $dompdf = new Dompdf();
    $options = $dompdf->getOptions();
    $options->set(array('isRemoteEnabled' => true));
    $dompdf->setOptions($options);
    $dompdf->setPaper('A4');

    $dompdf->loadHtml($html_rendered_view);
    $dompdf->render();

    return $dompdf;
  }

  /* para frontend */
  public function getPdf(bool $download)
  {
    $pdf = $this->buildPDF();
    return $pdf->stream($this->getPdfName(), array("Attachment" => $download));
  }


  public function buildPDF(): Dompdf
  {
    $constancia = $this;

    $html_view = view('ConstanciaDeposito.PDFConstanciaDepositoCTS', compact('constancia'))->render();
    $dompdf = $this->buildPdfPlantilla($html_view);

    return $dompdf;
  }

  public function getPdfName(): string
  {
    return 'Constancia deposito CTS ' . $this->getCodigoUnico() . '.pdf';
  }
  public function getCodigoUnico()
  {
    return $this->codigo_unico;
  }



  public function setDataFromRequest(Request $request)
  {
    $this->ultimo_sueldo_bruto = $request->ultimo_sueldo_bruto;
    $this->monto_ultima_grati = $request->monto_ultima_grati;
    $this->promedio_otras_remuneraciones = $request->promedio_otras_remuneraciones;

    $this->nombres = $request->nombres;
    $this->apellidos = $request->apellidos;
    $this->dni = $request->dni;
    $this->fecha_deposito = Fecha::formatoParaSQL($request->fecha_deposito);
    $this->fecha_inicio = Fecha::formatoParaSQL($request->fecha_inicio);
    $this->fecha_fin = Fecha::formatoParaSQL($request->fecha_fin);

    $this->nro_cuenta = $request->nro_cuenta;
    $this->nombre_banco = $request->nombre_banco;
    $this->nro_meses_laborados = $request->nro_meses_laborados;
    $this->nro_dias_laborados = $request->nro_dias_laborados;

    $this->monto_total_cts = $this->getTotalCTS(false);

    $codMes = intval($request->mes_emision);
    $codMes = $codMes < 10 ? "0" . $codMes : $codMes;
    $año = $request->año_emision;

    $this->fecha_emision = "$año-$codMes-15";
  }

  public function getUltimoSueldoBruto()
  {
    return MaracUtils::FormatearMonto($this->ultimo_sueldo_bruto);
  }



  public function getPromedioOtrasRemuneraciones(bool $formatear = false)
  {
    $val = $this->promedio_otras_remuneraciones;
    if ($formatear) {
      $val = MaracUtils::FormatearMonto($val);
    }
    return $val;
  }


  public function getSextoUltimaGrati(bool $formatear = false)
  {
    $val = $this->monto_ultima_grati / 6;
    if ($formatear) {
      $val = MaracUtils::FormatearMonto($val);
    }
    return $val;
  }

  public function getTotalRemuneracionComputable(bool $formatear = false)
  {
    $val = $this->ultimo_sueldo_bruto + $this->getSextoUltimaGrati() + $this->promedio_otras_remuneraciones;
    if ($formatear) {
      $val = MaracUtils::FormatearMonto($val);
    }
    return $val;
  }

  public function getFraccionRemuneracionComputableMensual(bool $formatear = false)
  {
    $val = $this->getTotalRemuneracionComputable() / 12;
    if ($formatear) {
      $val = MaracUtils::FormatearMonto($val);
    }
    return $val;
  }

  public function getFraccionRemuneracionComputableDiaria(bool $formatear = false)
  {
    $val = $this->getFraccionRemuneracionComputableMensual() / 30;
    if ($formatear) {
      $val = MaracUtils::FormatearMonto($val);
    }
    return $val;
  }

  public function getMontoMesesLaborados(bool $formatear = false)
  {
    $val = $this->getFraccionRemuneracionComputableMensual() * $this->nro_meses_laborados;
    if ($formatear) {
      $val = MaracUtils::FormatearMonto($val);
    }
    return $val;
  }

  public function getMontoDiasLaborados(bool $formatear = false)
  {
    $val = $this->getFraccionRemuneracionComputableDiaria() * $this->nro_dias_laborados;
    if ($formatear) {
      $val = MaracUtils::FormatearMonto($val);
    }
    return $val;
  }

  public function getTotalCTS(bool $formatear = false)
  {
    $val = $this->getMontoMesesLaborados() + $this->getMontoDiasLaborados();
    if ($formatear) {
      $val = MaracUtils::FormatearMonto($val);
    }

    return $val;
  }
  public function getDNIDirector()
  {

    $director = $this->getPeriodoDirector();
    return $director->dni;
  }


  public function getNombreDirectorGeneral()
  {
    $director = $this->getPeriodoDirector();
    return $director->getNombreCompleto(true);
  }
  public function getPeriodoDirector(): PeriodoDirectorGeneral
  {
    return PeriodoDirectorGeneral::findOrFail($this->codPeriodoDirector);
  }
  /* ********************************** HTML COMPONENTS ************************************* */
  /* ********************************** HTML COMPONENTS ************************************* */
  /* ********************************** HTML COMPONENTS ************************************* */
  /* ********************************** HTML COMPONENTS ************************************* */
  /* ********************************** HTML COMPONENTS ************************************* */
  /* ********************************** HTML COMPONENTS ************************************* */
  /* ********************************** HTML COMPONENTS ************************************* */
  /* ********************************** HTML COMPONENTS ************************************* */
  /* ********************************** HTML COMPONENTS ************************************* */
  /* ********************************** HTML COMPONENTS ************************************* */
  /* ********************************** HTML COMPONENTS ************************************* */
}
