<?php

namespace App;

use App\Utils\MaracUtils;
use Dompdf\Dompdf;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

//START MODEL_HELPER
/**
 * @property int $codVehiculo int(11)
 * @property string $placa varchar(20)
 * @property string $fecha_compra date
 * @property int $codSede int(11)
 * @property float $kilometraje_actual float NULLABLE   se actualiza con cada viaje
 * @property int $codEmpleadoRegistrador int(11)    el que lo registró en el sistema
 * @property string $fechaHoraRegistro datetime    el que lo registró en el sistema
 * @property string $modelo varchar(200)
 * @property string $color varchar(200)
 * @property string $codigo_factura varchar(200)
 * @method static Vehiculo findOrFail($primary_key)
 */
//END MODEL_HELPER
class Vehiculo extends MaracModel
{
  public $table = "vehiculo";
  protected $primaryKey = "codVehiculo";

  public $timestamps = false;  //para que no trabaje con los campos fecha

  const KilometrajeLimiteAlerta = 50;

  public function setDataFromRequest($request)
  {
    $this->placa = $request->placa;
    $this->fecha_compra = Fecha::formatoParaSQL($request->fecha_compra);
    $this->codSede = $request->codSede;
    $this->modelo = $request->modelo;
    $this->color = $request->color;
    $this->codigo_factura = $request->codigo_factura;
    $this->kilometraje_actual = $request->kilometraje_actual;
  }


  public function getFechaCompra()
  {
    if ($this->fecha_compra == null) {
      return "";
    }
    return Fecha::formatoParaVistas($this->fecha_compra);
  }
  public function getSede(): Sede
  {
    return Sede::findOrFail($this->codSede);
  }
  public function getRendimiento()
  {
    return $this->promedio_rendimiento;
  }

  public function getEmpleadoCreador(): Empleado
  {
    return Empleado::findOrFail($this->codEmpleadoRegistrador);
  }
  public function getFechaHoraCreacion(): string
  {
    return Fecha::formatoFechaHoraParaVistas($this->fechaHoraRegistro);
  }

  public function getMensageRegistradoPor(): string
  {
    return "Registrado por " . $this->getEmpleadoCreador()->getNombreCompleto() . " el " . $this->getFechaHoraCreacion();
  }

  public function apareceEnOtrasTablas(): bool
  {
    $viajes = ViajeVehiculo::where('codVehiculo', $this->codVehiculo)->count();
    return $viajes > 0;
  }

  public function sePuedeEliminar(): bool
  {
    return !$this->apareceEnOtrasTablas();
  }

  public function getDescripcion()
  {
    return $this->placa . " - " . $this->modelo . " - " . $this->color;
  }

  public static function findByPlaca($placa): Vehiculo
  {

    $search = Vehiculo::where('placa', $placa)->get();
    if (count($search) == 0) {
      throw new Exception("No existe vehiculo con placa " . $placa);
    }
    return $search[0];
  }

  public function getUrlRegistroViaje(): string
  {
    $conector = "/vv" . "/";
    $url = env('APP_URL') . $conector . $this->placa;
    return $url;
  }

  function getQrSvg()
  {
    $url = $this->getUrlRegistroViaje();
    return QrCode::generate($url);
  }




  public function buildPDF(): Dompdf
  {
    $vehiculo = $this;
    $qr_svg = $this->getQrSvg();

    $html_view = view('Vehiculo.VerPdf', compact('vehiculo', 'qr_svg'))->render();
    $dompdf = MaracUtils::BuildDompdf($html_view);

    return $dompdf;
  }

  public function getPdfName(): string
  {
    return 'Vehiculo ' . $this->placa . '.pdf';
  }

  /*
  para frontend, esto hace un echo como tal asi que no es necesario ningun return
  */
  public function getPdf(bool $download)
  {
    $pdf = $this->buildPDF();
    $output = $pdf->output();
    $pdfname = $this->getPdfName();

    return MaracUtils::ResponsePdf($output, $download, $pdfname);
  }

  public function tieneViajeAbierto(): bool
  {
    return ViajeVehiculo::where('codVehiculo', $this->codVehiculo)->where('estado', EstadoViajeVehiculo::ABIERTO)->count() > 0;
  }

  public static function GetTodosParaFront(): Collection
  {
    $vehiculos = Vehiculo::query()->get();
    foreach ($vehiculos as $veh) {
      $veh['nombre_front'] = $veh->getDescripcion();
    }
    return $vehiculos;
  }

  public function seDebeMostrarAlertaKilometraje(): bool
  {
    return $this->kilometraje_actual > self::KilometrajeLimiteAlerta;
  }
}
