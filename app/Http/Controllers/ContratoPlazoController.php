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
    $listaTipoContratos = TipoContrato::All();

    $tiposContrato = TipoContrato::All();
    return view('Contratos.PlazoFijo.ListarContratosPlazo', compact(
      'listaContratos',
      'listaEmpleadosQueGeneraronContratos',
      'tiposContrato',
      'listaNombresDeContratados',
      'filtros_usados',
      'filtros_usados_paginacion',
      'listaTipoContratos'
    ));
  }


  function crear()
  {
    $listaProyectos = Proyecto::getProyectosActivos();
    $listaMonedas = Moneda::All();
    $listaSedes = Sede::All();
    $listaTipoContratos = TipoContrato::All();
    return view('Contratos.PlazoFijo.CrearContratoPlazo', compact('listaProyectos', 'listaMonedas', 'listaSedes', 'listaTipoContratos'));
  }

  function guardar(Request $request)
  {

    try {
      db::beginTransaction();

      if ($request->asignacionFamiliar == '1')
        $asig = 1;
      else
        $asig = 0;

      $empLogeado = Empleado::getEmpleadoLogeado();

      $contrato = new ContratoPlazo();
      $contrato->codEmpleadoCreador = $empLogeado->codEmpleado;
      $contrato->nombres = $request->nombres;
      $contrato->apellidos = $request->apellidos;
      $contrato->direccion = $request->direccion;
      $contrato->dni = $request->dni;
      $contrato->sexo = $request->sexo;
      $contrato->asignacionFamiliar = $asig;
      $contrato->fechaHoraGeneracion = Carbon::now();
      $contrato->fechaInicio = Fecha::formatoParaSQL($request->fechaInicio);
      $contrato->fechaFin = Fecha::formatoParaSQL($request->fechaFin);
      $contrato->sueldoBruto = $request->sueldoBruto;
      $contrato->nombreProyecto = $request->nombreProyecto;
      $contrato->nombreFinanciera = $request->nombreFinanciera;
      $contrato->provinciaYDepartamento = $request->provinciaYDepartamento;


      $contrato->nombrePuesto = $request->nombrePuesto;
      $contrato->codMoneda = $request->codMoneda;
      $contrato->codSede = $request->codSede;
      $contrato->codTipoContrato = $request->codTipoContrato;

      $contrato->codigoCedepas = ContratoPlazo::calcularCodigoCedepas(Numeracion::getNumeracionCPF());
      Numeracion::aumentarNumeracionCPF();

      $contrato->save();



      db::commit();

      return redirect()->route('ContratosPlazo.Listar')
        ->with('datos', "Se ha creado exitosamente el contrato " . $contrato->codigoCedepas);
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
        ->with('datos', 'Se ha ANULADO el contrato ' . $contrato->codigoCedepas);
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
