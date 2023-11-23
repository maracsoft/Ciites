<?php

namespace App\Http\Controllers;

use App\Configuracion;
use App\ContratoPlazo;
use App\Debug;
use App\Empleado;
use App\ErrorHistorial;
use App\Fecha;
use App\Http\Controllers\Controller;
use App\Moneda;
use App\Numeracion;
use App\Proyecto;
use App\Sede;
use App\TipoContrato;
use App\UI\UIFiltros;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContratoPlazoController extends Controller
{

  const PAGINATION = 25;

  function listar(Request $request)
  {

    $listaContratos =  ContratoPlazo::query();

    $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaContratos,$request->getQueryString());

    $listaSolicitudesFondos = UIFiltros::buildQuery($listaContratos,$request->getQueryString());
    $filtros_usados = UIFiltros::getQueryValues($listaContratos,$request->getQueryString());

    $listaContratos = $listaContratos->orderBy('codContratoPlazo', 'DESC')->paginate(static::PAGINATION);


    $listaEmpleadosQueGeneraronContratos = ContratoPlazo::listaEmpleadosQueGeneraronContratosPlazo();
    $listaEmpleadosQueGeneraronContratos = Empleado::prepararParaSelect($listaEmpleadosQueGeneraronContratos);
    $listaNombresDeContratados = ContratoPlazo::listaNombresDeContratados();


    return view('Contratos.PlazoFijo.ListarContratosPlazo', compact(
      'listaContratos',
      'listaEmpleadosQueGeneraronContratos',

      'listaNombresDeContratados',
      'filtros_usados',
      'filtros_usados_paginacion'
    ));
  }


  function crear()
  {
    $listaProyectos = Proyecto::getProyectosActivos();
    $listaMonedas = Moneda::All();
    $listaSedes = Sede::All();
    $listaTipoAdenda = ContratoPlazo::getTiposAdendaFinanciera();
    $tiposTiempos = ContratoPlazo::getTiempos();
    return view('Contratos.PlazoFijo.CrearContratoPlazo', compact('listaProyectos', 'listaMonedas','tiposTiempos', 'listaSedes','listaTipoAdenda'));
  }

  function guardar(Request $request)
  {

    try {
      db::beginTransaction();



      $empLogeado = Empleado::getEmpleadoLogeado();

      $contrato = new ContratoPlazo();

      $contrato->nombres = $request->nombres;
      $contrato->apellidos = $request->apellidos;
      $contrato->dni = $request->dni;

      $contrato->codEmpleadoCreador = $empLogeado->codEmpleado;
      $contrato->fechaHoraGeneracion = Carbon::now();
      $contrato->es_borrador = 0;

      $contrato->domicilio = $request->domicilio;
      $contrato->puesto = $request->puesto;
      $contrato->tipo_adenda_financiera = $request->tipo_adenda_financiera;
      $contrato->nombre_financiera = $request->nombre_financiera;
      $contrato->duracion_convenio_numero = $request->duracion_convenio_numero;
      $contrato->duracion_convenio_unidad_temporal = $request->duracion_convenio_unidad_temporal;
      $contrato->nombre_contrato_locacion = $request->nombre_contrato_locacion;
      $contrato->fecha_inicio_prueba = Fecha::formatoParaSQL($request->fecha_inicio_prueba);
      $contrato->fecha_fin_prueba = Fecha::formatoParaSQL($request->fecha_fin_prueba);
      $contrato->fecha_inicio_contrato = Fecha::formatoParaSQL($request->fecha_inicio_contrato);
      $contrato->fecha_fin_contrato = Fecha::formatoParaSQL($request->fecha_fin_contrato);
      $contrato->cantidad_dias_labor = $request->cantidad_dias_labor;
      $contrato->cantidad_dias_descanso = $request->cantidad_dias_descanso;
      $contrato->remuneracion_mensual = $request->remuneracion_mensual;
      $contrato->codMoneda = $request->codMoneda;

      $contrato->codigo_unico = ContratoPlazo::calcularCodigoCedepas(Numeracion::getNumeracionCPF());
      Numeracion::aumentarNumeracionCPF();

      $contrato->save();

      DB::commit();
      return redirect()->route('ContratosPlazo.Listar')
        ->with('datos', "Se ha creado exitosamente el contrato " . $contrato->codigo_unico);
    } catch (\Throwable $th) {

      Debug::mensajeError('CONTRATO PLAZO GUARDAR', $th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('ContratosPlazo.Listar')
        ->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }




  public function descargarPDF($codContrato)
  {


    $contrato = ContratoPlazo::findOrFail($codContrato);
    $pdf = $contrato->getPDF();
    //return $pdf;
    return $pdf->download('Contrato ' . $contrato->getTituloContrato() . '.Pdf');
  }

  public function verPDF($codContrato)
  {
    $contrato = ContratoPlazo::findOrFail($codContrato);
    //return view('Contratos.contratoPlazoPDF',compact('contrato'));
    $pdf = $contrato->getPDF();

    /*
        return $pdf;
        */


    return $pdf->stream('Contrato ' . $contrato->getTituloContrato() . '.Pdf');
  }

  public function Ver($id)
  {
    $contrato = ContratoPlazo::findOrFail($id);
    return view('Contratos.PlazoFijo.VerContratoPlazo', compact('contrato'));
  }




  function Anular($codContrato)
  {
    try {
      db::beginTransaction();

      $empleadoLogeado = Empleado::getEmpleadoLogeado();
      $contrato = ContratoPlazo::findOrFail($codContrato);

      if ($contrato->codEmpleadoCreador != $empleadoLogeado->codEmpleado)
        return redirect()
          ->route('ContratosPlazo.Listar')
          ->with('datos', 'El contrato solo puede ser anulado por la persona que lo creó');

      $contrato->fechaHoraAnulacion = Carbon::now();
      $contrato->save();

      DB::commit();
      return redirect()
        ->route('ContratosPlazo.Listar')
        ->with('datos', 'Se ha ANULADO el contrato ' . $contrato->codigo_unico);
    } catch (\Throwable $th) {
      Debug::mensajeError('CONTRATO PLAZO : ANULAR', $th);
      DB::rollback();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        $codContrato
      );
      return redirect()
        ->route('ContratosPlazo.Listar')
        ->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }
}
