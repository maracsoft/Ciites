<?php

namespace App;

use App\Utils\Fecha;
use App\Utils\Numeros;
use Dompdf\Dompdf;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//START MODEL_HELPER
/**
 * @property int $codContratoPlazo int(11)     
 * @property string $nombres varchar(500)     
 * @property string $dni varchar(500)     
 * @property string $apellidos varchar(500)     
 * @property string $codigo_unico varchar(500)     
 * @property string $fechaHoraGeneracion datetime     
 * @property int $codMoneda int(11)     
 * @property int $codEmpleadoCreador int(11)     
 * @property string $domicilio varchar(500)     
 * @property string $tipo_adenda_financiera varchar(500)     
 * @property string $nombre_financiera varchar(500)     
 * @property int $duracion_convenio_numero int(11)     
 * @property string $duracion_convenio_unidad_temporal varchar(500)     
 * @property string $nombre_contrato_locacion varchar(500)     
 * @property string $puesto varchar(500)     
 * @property string $fecha_inicio_prueba date     
 * @property string $fecha_fin_prueba date     
 * @property string $fecha_inicio_contrato date     
 * @property string $fecha_fin_contrato date     
 * @property int $cantidad_dias_labor int(11)     
 * @property int $cantidad_dias_descanso int(11)     
 * @property float $remuneracion_mensual float     
 * @property string $fechaHoraAnulacion date NULLABLE    
 * @property int $es_borrador int(11)     
 * @property string $provincia varchar(200)     
 * @property string $departamento varchar(200)     
 * @property string $sexo varchar(5)     
 * @property string $distrito varchar(200)     
 * @method static ContratoPlazo findOrFail($primary_key)
 * @method static ContratoPlazo | null find($primary_key)
 * @method static ContratoPlazoCollection all()
 * @method static \App\Builders\ContratoPlazoBuilder query()
 * @method static \App\Builders\ContratoPlazoBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\ContratoPlazoBuilder where(string $column,string $value)
 * @method static \App\Builders\ContratoPlazoBuilder whereNotNull(string $column) 
 * @method static \App\Builders\ContratoPlazoBuilder whereNull(string $column) 
 * @method static \App\Builders\ContratoPlazoBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\ContratoPlazoBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class ContratoPlazo extends Contrato
{
  public $timestamps = false;
  public $table = 'contrato_plazo';

  protected $primaryKey = 'codContratoPlazo';
  protected $fillable = [''];

  const RaizCodigoCedepas = "CP";

  const Columnas = [

    "domicilio",
    "puesto",
    "tipo_adenda_financiera", // adenda/contrato/convenio
    "nombre_financiera",
    "duracion_convenio_numero", // "5"
    "duracion_convenio_unidad_temporal", // "Meses"
    "nombre_contrato_locacion",
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

  public static function getTiempos()
  {
    return [
      static::Tiempo_Año,
      static::Tiempo_Mes,
      static::Tiempo_Dia,
    ];
  }
  public static function getTiposAdendaFinanciera()
  {
    return [
      static::TipoAdendaFinanciera_Adenda,
      static::TipoAdendaFinanciera_Contrato,
      static::TipoAdendaFinanciera_Convenio,
    ];
  }

  public function getTextoDuracionConvenio()
  {
    $num = $this->duracion_convenio_numero;

    switch ($this->duracion_convenio_unidad_temporal) {
      case 'dia':
        $texto = "dias";

        break;
      case 'mes':
        $texto = "meses";

        break;
      case 'año':
        $texto = "años";

        break;

      default:

        break;
    }

    return $num . " " . $texto;
  }

  public function getMensajeAdendaConvenioContrato()
  {
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
        throw new Exception("Tipo de adenda financiera invalida, verifique la base de datos");
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

    if ($this->esBorrador()) {
      $dompdf->getCanvas()->page_text(400, 800, "Documento borrador, no tiene valor", $font, 8, array(200, 0, 0));
    }

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


  function getRemuneracionMensualEscrita(): string
  {

    return Numeros::escribirNumero($this->remuneracion_mensual);
  }



  public function getFechaInicioPruebaEscrita()
  {
    return Fecha::escribirEnTexto($this->fecha_inicio_prueba);
  }

  public function getFechaFinPruebaEscrita()
  {
    return Fecha::escribirEnTexto($this->fecha_fin_prueba);
  }

  public function getFechaInicioPrueba()
  {
    return Fecha::formatoParaVistas($this->fecha_inicio_prueba);
  }

  public function getFechaFinPrueba()
  {
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

  public function setDataFromRequest(Request $request)
  {

    $this->nombres = $request->nombres;
    $this->apellidos = $request->apellidos;
    $this->dni = $request->dni;
    $this->sexo = $request->sexo;

    $this->domicilio = $request->domicilio;

    $this->distrito = $request->distrito;
    $this->provincia = $request->provincia;
    $this->departamento = $request->departamento;

    $this->puesto = $request->puesto;
    $this->tipo_adenda_financiera = $request->tipo_adenda_financiera;
    $this->nombre_financiera = $request->nombre_financiera;
    $this->duracion_convenio_numero = $request->duracion_convenio_numero;
    $this->duracion_convenio_unidad_temporal = $request->duracion_convenio_unidad_temporal;
    $this->nombre_contrato_locacion = $request->nombre_contrato_locacion;
    $this->fecha_inicio_prueba = Fecha::formatoParaSQL($request->fecha_inicio_prueba);
    $this->fecha_fin_prueba = Fecha::formatoParaSQL($request->fecha_fin_prueba);
    $this->fecha_inicio_contrato = Fecha::formatoParaSQL($request->fecha_inicio_contrato);
    $this->fecha_fin_contrato = Fecha::formatoParaSQL($request->fecha_fin_contrato);
    $this->cantidad_dias_labor = $request->cantidad_dias_labor;
    $this->cantidad_dias_descanso = $request->cantidad_dias_descanso;
    $this->remuneracion_mensual = $request->remuneracion_mensual;
    $this->codMoneda = $request->codMoneda;
  }
}
