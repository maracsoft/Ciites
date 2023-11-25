<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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


  public function getPDF()
  {
    $listaItems = $this->getAvances();
    $contrato = $this;

    /*
        return view('Contratos.contratoLocacionPDF',compact('contrato','listaItems'));
        */

    $pdf = \PDF::loadview(
      'Contratos.contratoLocacionPDF',
      array('contrato' => $this, 'listaItems' => $listaItems)
    )->setPaper('a4', 'portrait');

    return $pdf;
  }

  public function getAvances()
  {
    return AvanceEntregable::where('codContratoLocacion', $this->codContratoLocacion)
      ->orderBy('fechaEntrega', 'ASC')
      ->get();
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



  /*
        Si es persona jurídica, será EL LOCADOR
        Si es persona natural:
            Hombre: EL LOCADOR
            Mujer : LA LOCADORA


    */
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

  public function setFromRequest(Request $request){

    $this->motivoContrato = $request->motivoContrato;
    $this->retribucionTotal = $request->retribucionTotal;
    $this->codMoneda = $request->codMoneda;
    $this->fechaInicio = Fecha::formatoParaSQL($request->fechaInicio);
    $this->fechaFin = Fecha::formatoParaSQL($request->fechaFin);
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
      $this->provinciaYDepartamento = $request->PN_provinciaYDepartamento;
    } else { //PERSONA JURIDICA

      $this->ruc = $request->PJ_ruc;
      $this->dni = $request->PJ_dni;

      $this->nombres = $request->PJ_nombres;
      $this->apellidos = $request->PJ_apellidos;

      $this->sexo = $request->PJ_sexo;
      $this->direccion = $request->PJ_direccion;
      $this->provinciaYDepartamento = $request->PJ_provinciaYDepartamento;

      $this->razonSocialPJ = $request->PJ_razonSocialPJ;
      $this->nombreDelCargoPJ = $request->PJ_nombreDelCargoPJ;
    }

  }
  public function setDetallesFromRequest(Request $request){
    $detalles = json_decode($request->json_detalles);

    foreach ($detalles as $detalle) {

      if($detalle->codAvance == 0){ //nuevo
        $avance = new AvanceEntregable();
        $avance->codContratoLocacion = $this->getId();
      }else{ //existente
        $avance = AvanceEntregable::findOrFail($detalle->codAvance);
      }

      $avance->fechaEntrega = Fecha::formatoParaSQL($detalle->fecha);
      $avance->descripcion = $detalle->descripcion;
      $avance->monto = $detalle->monto;
      $avance->porcentaje = $detalle->porcentaje;

      $avance->save();

    }

  }
}
