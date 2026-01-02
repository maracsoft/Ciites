<?php

namespace App;

use App\Utils\Fecha;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//START MODEL_HELPER
/**
 * @property int $codContratoLocacion int(11)     
 * @property string $codigo_unico varchar(30)     
 * @property string $nombres varchar(300)     
 * @property string $apellidos varchar(300)     
 * @property string $direccion varchar(500)     
 * @property string $dni varchar(20)     
 * @property string $ruc varchar(20)     
 * @property string $sexo char(1) NULLABLE    
 * @property string $fechaHoraGeneracion datetime     
 * @property string $fecha_inicio_contrato date     
 * @property string $fecha_fin_contrato date     
 * @property float $retribucionTotal float     
 * @property string $motivoContrato varchar(1000)     
 * @property int $codEmpleadoCreador int(11)     
 * @property int $codMoneda int(11)     
 * @property int $codSede int(11)     
 * @property int $esPersonaNatural int(11)     
 * @property string $razonSocialPJ varchar(200) NULLABLE    
 * @property string $nombreDelCargoPJ varchar(200) NULLABLE    
 * @property string $nombreProyecto varchar(300)     
 * @property string $nombreFinanciera varchar(300)     
 * @property string $fechaHoraAnulacion datetime NULLABLE    
 * @property string $provincia varchar(200)     
 * @property string $departamento varchar(200)     
 * @property int $es_borrador int(11)     
 * @property string $distrito varchar(500)     
 * @method static ContratoLocacion findOrFail($primary_key)
 * @method static ContratoLocacion | null find($primary_key)
 * @method static ContratoLocacionCollection all()
 * @method static \App\Builders\ContratoLocacionBuilder query()
 * @method static \App\Builders\ContratoLocacionBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\ContratoLocacionBuilder where(string $column,string $value)
 * @method static \App\Builders\ContratoLocacionBuilder whereNotNull(string $column) 
 * @method static \App\Builders\ContratoLocacionBuilder whereNull(string $column) 
 * @method static \App\Builders\ContratoLocacionBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\ContratoLocacionBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class ContratoLocacion extends Contrato
{
  public $timestamps = false;
  public $table = 'contrato_locacion';

  protected $primaryKey = 'codContratoLocacion';
  protected $fillable = [''];

  const RaizCodigoCedepas = "CL";

  /*
  CONTRATO LOCACIÓN

      fechaInicio
      fechaFin

      apellidos
      nombres
      dni
      direccion
      motivoContrato

      retribucionTotal
  */

  //le pasamos un modelo numeracion y calcula la nomeclatura del cod cedepas
  public static function calcularCodigoCedepas($objNumeracion)
  {
    return  ContratoLocacion::RaizCodigoCedepas .
      substr($objNumeracion->año, 2, 2) .
      '-' .
      ContratoLocacion::rellernarCerosIzq($objNumeracion->numeroLibreActual, 4);
  }
  public static function rellernarCerosIzq($numero, $nDigitos)
  {
    return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);
  }


  public function getPDF($listaDetalles = null)
  {
    if ($listaDetalles) {
      $listaItems = $listaDetalles;
    } else {
      $listaItems = $this->getAvances();
    }

    $pdf = \PDF::loadview('Contratos.contratoLocacionPDF', array('contrato' => $this, 'listaItems' => $listaItems))->setPaper('a4', 'portrait');

    return $pdf;
  }

  public function getAvances()
  {
    $lista = AvanceEntregable::where('codContratoLocacion', $this->codContratoLocacion)->orderBy('fechaEntrega', 'ASC')->get();
    foreach ($lista as $avance) {
      $avance['fecha_front'] = $avance->getFechaEntrega();
    }

    return $lista;
  }



  function getRetribucionTotal()
  {
    return number_format($this->retribucionTotal, 2);
  }


  function getSede()
  {
    return Sede::findOrFail($this->codSede);
  }



  function esDeNatural()
  {
    return $this->esPersonaNatural == '1';
  }

  public function getTextoTipoPersona(): string
  {
    if ($this->esDeNatural()) {
      return "PERSONA NATURAL";
    } else {
      return "PERSONA JURÍDICA";
    }
  }




  public function getLocadore()
  {
    if ($this->esDeNatural()) {
      if ($this->sexo == "F")
        return "LA LOCADORA";
      else
        return "EL LOCADOR";
    }

    return "EL LOCADOR";
  }

  public function getSexoLabel()
  {
    if ($this->sexo == 'F') {
      return "FEMENINO";
    } else {
      return "MASCULINO";
    }
  }






  static function listaEmpleadosQueGeneraronContratosLocacion()
  {
    $listaCodigosEmp = ContratoLocacion::select('codEmpleadoCreador')->groupBy('codEmpleadoCreador')->get();
    $objetoResultante = json_decode(json_encode($listaCodigosEmp));
    $arrayDeCodEmpleadosGeneradores = array_column($objetoResultante, 'codEmpleadoCreador');

    $lista = Empleado::whereIn('codEmpleado', $arrayDeCodEmpleadosGeneradores)->get();
    $lista = Empleado::prepararParaSelect($lista);
    return $lista;
  }


  static function listaNombresDeContratados()
  {
    $listaContratos = DB::select("select dni,nombres,apellidos from contrato_locacion group by dni,nombres,apellidos");

    $listaNombres = [];
    foreach ($listaContratos as $contrato) {
      $nombreComp = $contrato->apellidos . " " . $contrato->nombres;
      if (!in_array($nombreComp, $listaNombres)) {
        $listaNombres[] = [
          'nombre' => $nombreComp,
          "dni" => $contrato->dni,
          "nombre_dni" => $nombreComp . " - " . $contrato->dni,
        ];
      }
    }


    return $listaNombres;
  }


  static function listaRazonesSociales()
  {
    $listaContratos = DB::select("select ruc,razonSocialPJ from contrato_locacion  where razonSocialPJ != '' group by ruc,razonSocialPJ");

    $listaNombres = [];
    foreach ($listaContratos as $contrato) {

      $listaNombres[] = [
        'nombre' => $contrato->razonSocialPJ,
        "ruc" => $contrato->ruc,
        "nombre_ruc" => $contrato->razonSocialPJ . " - " . $contrato->ruc,
      ];
    }


    return $listaNombres;
  }

  public function setDataFromRequest(Request $request)
  {


    $this->motivoContrato = $request->motivoContrato;
    $this->retribucionTotal = $request->retribucionTotal;
    $this->codMoneda = $request->codMoneda;
    $this->fecha_inicio_contrato = Fecha::formatoParaSQL($request->fecha_inicio_contrato);
    $this->fecha_fin_contrato = Fecha::formatoParaSQL($request->fecha_fin_contrato);
    $this->codSede = $request->codSede;
    $this->esPersonaNatural = $request->esPersonaNatural;

    $this->nombreFinanciera = $request->nombreFinanciera;
    $this->nombreProyecto = $request->nombreProyecto;


    if ($this->esPersonaNatural == "1") { //PERSONA NATURAL

      $this->ruc = $request->PN_ruc;
      $this->dni = $request->PN_dni;

      $this->nombres = $request->PN_nombres;
      $this->apellidos = $request->PN_apellidos;

      $this->sexo = $request->PN_sexo;
      $this->direccion = $request->PN_direccion;
      $this->provincia = $request->PN_provincia;
      $this->departamento = $request->PN_departamento;
      $this->distrito = $request->PN_distrito;
    } else { //PERSONA JURIDICA

      $this->ruc = $request->PJ_ruc;
      $this->dni = $request->PJ_dni;

      $this->nombres = $request->PJ_nombres;
      $this->apellidos = $request->PJ_apellidos;

      $this->direccion = $request->PJ_direccion;
      $this->provincia = $request->PJ_provincia;
      $this->departamento = $request->PJ_departamento;
      $this->distrito = $request->PJ_distrito;

      $this->razonSocialPJ = $request->PJ_razonSocialPJ;
      $this->nombreDelCargoPJ = $request->PJ_nombreDelCargoPJ;
    }
  }


  public function setDetallesFromRequest(Request $request, $activar_guardado = true)
  {

    //eliminamos los que existen
    if ($activar_guardado) {
      AvanceEntregable::where('codContratoLocacion', '=', $this->codContratoLocacion)->delete();
    }

    $lista = new Collection();
    $detalles = json_decode($request->json_detalles);

    foreach ($detalles as $detalle) {
      $avance = new AvanceEntregable();

      $avance->fechaEntrega = Fecha::formatoParaSQL($detalle->fecha);
      $avance->descripcion = $detalle->descripcion;
      $avance->monto = $detalle->monto;
      $avance->porcentaje = $detalle->porcentaje;

      if ($activar_guardado) {
        $avance->codContratoLocacion = $this->getId();
        $avance->save();
      }
      $lista->push($avance);
    }

    return $lista;
  }
}
