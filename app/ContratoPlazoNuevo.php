<?php

namespace App;

use Dompdf\Dompdf;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ContratoPlazoNuevo extends Contrato
{
  public $timestamps = false;
  public $table = 'contrato_plazo_nuevo';

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
    "nombre_proyecto",
    "fecha_inicio_prueba",
    "fecha_fin_prueba",
    "fecha_inicio_contrato",
    "fecha_fin_contrato",
    "cantidad_dias_labor",
    "cantidad_dias_descanso",
    "remuneracion_mensual",
    "codMoneda",
    'tipo_contrato' // PUEDE SER atipico/con_jornada/sin_jornada/puesto_confianza/medio_tiempo
  ];



  const TipoContrato_Atipico = "atipico";
  const TipoContrato_ConJornada = "con_jornada";
  const TipoContrato_SinJornada = "sin_jornada";
  const TipoContrato_PuestoConfianza = "puesto_confianza";
  const TipoContrato_MedioTiempo = "medio_tiempo"; //igual al con jornada excepto en la sexta


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

  public static function getTiposContrato() : array {
    return [
      static::TipoContrato_Atipico => "Atípico",
      static::TipoContrato_ConJornada => "Con Jornada",
      static::TipoContrato_SinJornada => "Sin Jornada",
      static::TipoContrato_PuestoConfianza => "Puesto de Confianza",
      static::TipoContrato_MedioTiempo => "Medio Tiempo",
    ];
  }

  public static function getTiposContratoParaFiltro() : array {
    $tipos = static::getTiposContrato();

    return [
      [
        "id" => static::TipoContrato_Atipico,
        "nombre" => $tipos[static::TipoContrato_Atipico]
      ],
      [
        "id" => static::TipoContrato_ConJornada,
        "nombre" => $tipos[static::TipoContrato_ConJornada]
      ],
      [
        "id" => static::TipoContrato_SinJornada,
        "nombre" => $tipos[static::TipoContrato_SinJornada]
      ],
      [
        "id" => static::TipoContrato_PuestoConfianza,
        "nombre" => $tipos[static::TipoContrato_PuestoConfianza]
      ],
      [
        "id" => static::TipoContrato_MedioTiempo,
        "nombre" => $tipos[static::TipoContrato_MedioTiempo]
      ]

    ];
  }

  public function getTipoContratoLabel() : string{
    $tipos = static::getTiposContrato();
    return $tipos[$this->tipo_contrato];
  }



  public function getTextoDuracionConvenio(){
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

    return $num." ".$texto;
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
    $html_view = view('Contratos.PlazoNuevo.ContratoPlazoNuevoPDF', $data)->render();

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



  public function getFechaInicioPruebaEscrita(){
    return Fecha::escribirEnTexto($this->fecha_inicio_prueba);
  }

  public function getFechaFinPruebaEscrita(){
    return Fecha::escribirEnTexto($this->fecha_fin_prueba);
  }

  public function getFechaInicioPrueba(){
    if($this->fecha_inicio_prueba == null){
      return "";
    }

    return Fecha::formatoParaVistas($this->fecha_inicio_prueba);
  }

  public function getFechaFinPrueba(){
    if($this->fecha_fin_prueba == null){
      return "";
    }
    return Fecha::formatoParaVistas($this->fecha_fin_prueba);
  }


  /* overrides */
  function getFechaInicio()
  {
    return Fecha::formatoParaVistas($this->fecha_inicio_contrato);
  }
  /* overrides */
  function getFechaFin()
  {
    return Fecha::formatoParaVistas($this->fecha_fin_contrato);
  }

  function getFechaInicioEscrita()
  {
    return Fecha::escribirEnTexto($this->fecha_inicio_contrato);
  }
  function getFechaFinEscrita()
  {

    return Fecha::escribirEnTexto($this->fecha_fin_contrato);
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

  public function setDataFromRequest(Request $request){

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
    $this->nombre_proyecto = $request->nombre_proyecto;

    $this->fecha_inicio_contrato = Fecha::formatoParaSQL($request->fecha_inicio_contrato);
    $this->fecha_fin_contrato = Fecha::formatoParaSQL($request->fecha_fin_contrato);
    $this->cantidad_dias_labor = $request->cantidad_dias_labor;
    $this->cantidad_dias_descanso = $request->cantidad_dias_descanso;
    $this->remuneracion_mensual = $request->remuneracion_mensual;
    $this->codMoneda = $request->codMoneda;
    $this->tipo_contrato = $request->tipo_contrato;
    $this->tiene_periodo_prueba = $request->tiene_periodo_prueba;

    if($this->tienePeriodoPrueba()){
      $this->fecha_inicio_prueba = Fecha::formatoParaSQL($request->fecha_inicio_prueba);
      $this->fecha_fin_prueba = Fecha::formatoParaSQL($request->fecha_fin_prueba);
    }

  }


  public function verificarTipo_Atipico() : bool {
    return $this->tipo_contrato == static::TipoContrato_Atipico;
  }
  public function verificarTipo_ConJornada() : bool {
    return $this->tipo_contrato == static::TipoContrato_ConJornada;
  }
  public function verificarTipo_SinJornada() : bool {
    return $this->tipo_contrato == static::TipoContrato_SinJornada;
  }
  public function verificarTipo_PuestoConfianza() : bool {
    return $this->tipo_contrato == static::TipoContrato_PuestoConfianza;
  }
  public function verificarTipo_MedioTiempo() : bool {
    return $this->tipo_contrato == static::TipoContrato_MedioTiempo;
  }




  public function tienePeriodoPrueba() : bool {
    return $this->tiene_periodo_prueba == 1;
  }

  public function getLabelTienePeriodoPrueba() : string {
    if($this->tienePeriodoPrueba())
      return "SÍ";
    else
      return "NO";
  }

 
}
