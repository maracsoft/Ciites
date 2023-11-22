<?php

namespace App;

use Dompdf\Dompdf;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ContratoPlazo extends Contrato
{
  public $timestamps = false;
  public $table = 'contrato_plazo';

  protected $primaryKey = 'codContratoPlazo';
  protected $fillable = [''];

  const RaizCodigoCedepas = "CP";

  const Columnas = [
    "domicilio",
    "tipo_adenda_financiera", // adenda/contrato/convenio
    "nombre_financiera",
    "duracion_convenio_numero", // "5"
    "duracion_convenio_unidad_temporal", // "Meses"
    "nombre_contrato_locacion",
    "puesto",
    "fecha_inicio_prueba",
    "fecha_fin_prueba",
    "fecha_inicio_contrato",
    "fecha_fin_contrato",
    "cantidad_dias_labor",
    "cantidad_dias_descanso",
    "remuneracion_mensual",
    "codMoneda",
  ];

  const TipoAdendaFinanciera_Adenda = "adenda";
  const TipoAdendaFinanciera_Contrato = "contrato";
  const TipoAdendaFinanciera_Convenio = "convenio";

  const Tiempo_Dia = "dia";
  const Tiempo_Mes = "mes";
  const Tiempo_Año = "año";

  public static function getTiempos(){
    return [
      static::Tiempo_Año,
      static::Tiempo_Mes,
      static::Tiempo_Dia,
    ];
  }
  public static function getTiposAdendaFinanciera(){
    return [
      static::TipoAdendaFinanciera_Adenda,
      static::TipoAdendaFinanciera_Contrato,
      static::TipoAdendaFinanciera_Convenio,
    ];
  }

  public function getTextoDuracionConvenio(){

    switch ($this->duracion_convenio_unidad_temporal) {
      case 'dia':

        break;
      case 'mes':

        break;
      case 'año':

        break;

      default:
        # code...
        break;
    }
  }

  public function getMensajeAdendaConvenioContrato(){
    switch ($this->tipo_adenda_financiera) {
      case 'adenda':
        return "una adenda al convenio con ";
        break;
      case 'contrato':
        return "un contrato con ";
        break;
      case 'convenio':
        return "un convenio con ";
        break;

      default:
        throw new Exception ("Tipo de adenda financiera invalida, verifique la base de datos");
        break;
    }
  }



  /* si es hombre retorna EL TRABAJADOR
    si es mujer, retorna LA TRABAJADORA */
  public function getTrabajadore()
  {
    if ($this->sexo == 'M')
      return "EL TRABAJADOR";
    else
      return "LA TRABAJADORA";
  }


  public function getPDF()
  {
    $data = array('contrato' => $this);
    $html_view = view('Contratos.contratoPlazoServicioEspecificoPDF', $data)->render();

    $dompdf = new Dompdf();
    $font = $dompdf->getFontMetrics()->get_font("helvetica", "normal");

    $options = $dompdf->getOptions();
    $options->set(array('isRemoteEnabled' => true));
    $dompdf->setOptions($options);

    $dompdf->loadHtml($html_view);
    $dompdf->setPaper('A4');
    $dompdf->render();

    if($this->esBorrador()){
      $dompdf->getCanvas()->page_text(400, 800, "Documento borrador, no tiene valor", $font, 8, array(200,0,0));
    }

    $nombre_archivo_descarga = $this->getTituloContrato();
    $descargarlo = false;
    $dompdf->stream($nombre_archivo_descarga.".pdf", array("Attachment" => $descargarlo));

    return $dompdf;
  }





  //le pasamos un modelo numeracion y calcula la nomeclatura del cod cedepas SOF21-000001
  public static function calcularCodigoCedepas($objNumeracion)
  {
    return  ContratoPlazo::RaizCodigoCedepas .
      substr($objNumeracion->año, 2, 2) .
      '-' .
      ContratoPlazo::rellernarCerosIzq($objNumeracion->numeroLibreActual, 4);
  }

  public static function rellernarCerosIzq($numero, $nDigitos)
  {
    return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);
  }


  function getRemuneracionMensualEscrita() : string
  {

    return Numeros::escribirNumero($this->remuneracion_mensual);
  }



  public function getFechaInicioPrueba(){
    return Fecha::formatoParaVistas($this->fecha_inicio_prueba);
  }

  public function getFechaFinPrueba(){
    return Fecha::formatoParaVistas($this->fecha_fin_prueba);
  }




  static function listaEmpleadosQueGeneraronContratosPlazo()
  {
    $listaCodigosEmp = ContratoPlazo::select('codEmpleadoCreador')->groupBy('codEmpleadoCreador')->get();
    $objetoResultante = json_decode(json_encode($listaCodigosEmp));
    $arrayDeCodEmpleadosGeneradores = array_column($objetoResultante, 'codEmpleadoCreador');

    return Empleado::whereIn('codEmpleado', $arrayDeCodEmpleadosGeneradores)->get();
  }


  static function listaNombresDeContratados()
  {
    $listaContratos = DB::select("select dni,nombres,apellidos from contrato_plazo group by dni,nombres,apellidos");

    $listaNombres = [];
    foreach ($listaContratos as $contrato) {
      $nombreComp = $contrato->apellidos . " " . $contrato->nombres;
      if (!in_array($nombreComp, $listaNombres)) {
        $listaNombres[] = [
          'nombre' => $nombreComp,
          "nombre_dni" => $nombreComp . " - " . $contrato->dni,
          "dni" => $contrato->dni
        ];
      }
    }


    return $listaNombres;
  }
}
