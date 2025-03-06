<?php

namespace App;

use DateTime;
use Dompdf\Dompdf;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

//START MODEL_HELPER
/**
 * @property int $codViaje int(11)     
 * @property int $codVehiculo int(11)     
 * @property string $fechaHoraSalida datetime     
 * @property float $kilometraje_salida float     
 * @property string $motivo text     
 * @property int $codEmpleadoAprobador int(11)     
 * @property string $fechaHoraLlegada datetime NULLABLE    
 * @property float $kilometraje_llegada float NULLABLE    
 * @property string $codigo_factura_combustible varchar(100) NULLABLE    
 * @property float $monto_factura_combustible float NULLABLE    
 * @property float $kilometraje_recorrido float NULLABLE    
 * @property float $rendimiento float NULLABLE   kilometro por sol 
 * @property int $codEmpleadoRegistrador int(11)     
 * @property string $fechaHoraRegistro datetime     
 * @property string $estado varchar(200)     
 * @property string $fechaHoraValidacion datetime NULLABLE    
 * @property string $fechaHoraConclusion datetime NULLABLE   fecha hora que el usuario marco que ya esta concluido el viaje 
 * @property string $lugar_origen varchar(200)     
 * @property string $lugar_destino varchar(200)     
 * @property string $observaciones_salida text NULLABLE    
 * @property string $observaciones_llegada text NULLABLE    
 * @method static ViajeVehiculo findOrFail($primary_key)
 */
//END MODEL_HELPER
class ViajeVehiculo extends MaracModel
{
  public $table = "viaje_vehiculo";
  protected $primaryKey = "codViaje";

  public $timestamps = false;  //para que no trabaje con los campos fecha 




  public function setDataFromRequest($request)
  {
    $fecha_salida_sql = Fecha::formatoParaSQL($request->fecha_salida);
    $hora_salida = $request->hour_selector_hora_salida;

    $this->fechaHoraSalida = $fecha_salida_sql . " " . $hora_salida;

    $this->motivo = $request->motivo;
    $this->codEmpleadoAprobador = $request->codEmpleadoAprobador;
    $this->kilometraje_salida = $request->kilometraje_salida;
    $this->lugar_origen = $request->lugar_origen;
    $this->lugar_destino = $request->lugar_destino;
    $this->observaciones_salida = $request->observaciones_salida;
  }

  public function setDataFromRequest_FinalizarViaje($request)
  {
    $this->estado = EstadoViajeVehiculo::FINALIZADO;
    $this->kilometraje_llegada = $request->kilometraje_llegada;
    $this->codigo_factura_combustible = $request->codigo_factura_combustible;
    $this->kilometraje_recorrido = $this->kilometraje_llegada - $this->kilometraje_salida;
    $this->monto_factura_combustible = $request->monto_factura_combustible;
    $this->observaciones_llegada = $request->observaciones_llegada;


    if ($request->fecha_llegada && $request->hour_selector_hora_llegada) {
      $fecha_llegada_sql = Fecha::formatoParaSQL($request->fecha_llegada);
      $hora_llegada = $request->hour_selector_hora_llegada;
      $this->fechaHoraLlegada = $fecha_llegada_sql . " " . $hora_llegada;
    }

    //el rendimiento se calculará cuando se finaliza el viaje
    if ($this->monto_factura_combustible != 0) {
      $this->rendimiento = $this->kilometraje_recorrido / $this->monto_factura_combustible;
    }

    $vehiculo = $this->getVehiculo();
    $vehiculo->kilometraje_actual = $this->kilometraje_llegada;
    $vehiculo->save();
  }

  //solo se ejecuta cuando se cierra el viaje
  public function actualizarKilometraje()
  {
    $vehiculo = $this->getVehiculo();
    $vehiculo->kilometraje_actual = $this->kilometraje_llegada;
    $vehiculo->save();
  }

  public function getFechaSalida(): string
  {
    if ($this->fechaHoraSalida == null) {
      return "";
    }
    return Fecha::formatoParaVistas($this->fechaHoraSalida);
  }
  public function getFechaLlegada(): string
  {
    if ($this->fechaHoraLlegada == null) {
      return "";
    }
    return Fecha::formatoParaVistas($this->fechaHoraLlegada);
  }
  public function getFechaHoraSalida(): string
  {
    return Fecha::formatoFechaHoraParaVistas($this->fechaHoraSalida);
  }
  public function getFechaHoraLlegada(): string
  {
    return Fecha::formatoFechaHoraParaVistas($this->fechaHoraLlegada);
  }


  public function getFechaHoraSalidaEscrita(): string
  {
    return Fecha::formatoFechaHoraParaVistasSinSegundos($this->fechaHoraSalida);
  }
  public function getFechaHoraLlegadaEscrita(): string
  {
    if ($this->fechaHoraLlegada == null) {
      return "";
    }
    return Fecha::formatoFechaHoraParaVistasSinSegundos($this->fechaHoraLlegada);
  }

  public function getHoraSalida_HourSelector(): string
  {
    if ($this->fechaHoraSalida == null) {
      return "";
    }
    return Fecha::formatoParaHourSelector($this->fechaHoraSalida);
  }

  public function getHoraLlegada_HourSelector(): string
  {
    if ($this->fechaHoraLlegada == null) {
      return "";
    }
    return Fecha::formatoParaHourSelector($this->fechaHoraLlegada);
  }

  public function getHoraSalida(): string
  {
    if ($this->fechaHoraSalida == null) {
      return "";
    }
    return Fecha::formatoHoraParaVistas($this->fechaHoraSalida);
  }
  public function getHoraLlegada(): string
  {
    if ($this->fechaHoraLlegada == null) {
      return "";
    }
    return Fecha::formatoHoraParaVistas($this->fechaHoraLlegada);
  }

  public function getEmpleadoAprobador(): Empleado
  {
    return Empleado::findOrFail($this->codEmpleadoAprobador);
  }

  public function getVehiculo(): Vehiculo
  {
    return Vehiculo::findOrFail($this->codVehiculo);
  }

  public function getEmpleadoRegistrador(): Empleado
  {
    return Empleado::findOrFail($this->codEmpleadoRegistrador);
  }
  public function getFechaHoraRegistro(): string
  {
    return Fecha::formatoFechaHoraParaVistasSinSegundos($this->fechaHoraRegistro);
  }

  public function getRendimiento(): string
  {
    if ($this->estaFinalizado()) {
      return number_format($this->rendimiento, 2, '.', ' ') . " Km/Sol";
    }
    return "";
  }

  public function getCosto(): string
  {
    return "S/ " . $this->monto_factura_combustible;
  }


  public function sePuedeFinalizar()
  {
    return $this->estaAbierto();
  }

  public function estaFinalizado()
  {
    return $this->estado == EstadoViajeVehiculo::FINALIZADO;
  }
  public function estaAbierto()
  {
    return $this->estado == EstadoViajeVehiculo::ABIERTO;
  }

  public function sePuedeFinalizarPorLogeado(Empleado $logeado)
  {
    return $this->sePuedeFinalizar() && $this->codEmpleadoRegistrador == $logeado->codEmpleado;
  }


  public function sePuedeEliminar()
  {
    return $this->estaAbierto();
  }

  public function getEstado(): EstadoViajeVehiculo
  {
    return new EstadoViajeVehiculo($this->estado);
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


  public function buildPDF(): Dompdf
  {
    $viaje = $this;
    $conductor = $this->getEmpleadoRegistrador();
    $vehiculo = $this->getVehiculo();

    $html_view = view('ViajeVehiculo.ViajePDF', compact('vehiculo', 'viaje', 'conductor'))->render();
    $dompdf = $this->buildPdfPlantilla($html_view);

    return $dompdf;
  }

  public function getPdfName(): string
  {
    return 'Viaje ' . $this->getId() . '.pdf';
  }

  /* para frontend */
  public function getPdf(bool $download)
  {
    $pdf = $this->buildPDF();
    return $pdf->stream($this->getPdfName(), array("Attachment" => $download));
  }


  public function getObservacionesSalida(): string
  {
    if ($this->observaciones_salida) {
      return $this->observaciones_salida;
    }
    return "-";
  }

  public function getObservacionesLlegada(): string
  {
    if ($this->observaciones_llegada) {
      return $this->observaciones_llegada;
    }
    return "-";
  }

  /* 
  Booleana,retorna true si se puede editar
    se puede editar si ha sido creada hace 5 minutos o menos.
    */
  const MinutosEdicion = 5;
  function seCreoHaceMenosDeXMinutos()
  {
    $fechaActual = date("Y-m-d H:i:s");

    $actual_unix = strtotime($fechaActual);
    $creacion_unix = strtotime($this->fechaHoraRegistro);


    $diff_seconds = $actual_unix - $creacion_unix;
    $diff_minutes = floor($diff_seconds / 60);

    return $diff_minutes < static::MinutosEdicion;
  }

  function getSegundosFaltantesParaBloqueoEdicion(): int
  {
    $creacion_unix = strtotime($this->fechaHoraRegistro);
    return $creacion_unix + static::MinutosEdicion * 60 - time();
  }


  public function sePuedeEditar()
  {
    return $this->estaAbierto() && $this->seCreoHaceMenosDeXMinutos();
  }


  //retorna el id pero llenado con ceros a la izquierda
  public function getIdEstandar()
  {
    return str_pad($this->codViaje, 4, '0', STR_PAD_LEFT);
  }

  /* HTML */

  public function renderMotivo()
  {
    $texto_completo = $this->motivo;
    $texto_abreviado = Debug::abreviar($texto_completo, 100);
    return view('ComponentesUI.TextoAbreviado', compact('texto_completo', 'texto_abreviado'));
  }
}
