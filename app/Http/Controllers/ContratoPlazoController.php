<?php

namespace App\Http\Controllers;

use App\Configuracion;
use App\Contrato;
use App\ContratoPlazo;
use App\Debug;
use App\Empleado;
use App\ErrorHistorial;
use App\Fecha;
use App\Http\Controllers\Controller;
use App\Moneda;
use App\Numeracion;
use App\Proyecto;
use App\RespuestaAPI;
use App\Sede;
use App\TipoContrato;
use App\UI\UIFiltros;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

  function Editar($codContratoPlazo){
    $contrato = ContratoPlazo::findOrFail($codContratoPlazo);

    $listaProyectos = Proyecto::getProyectosActivos();
    $listaMonedas = Moneda::All();
    $listaSedes = Sede::All();
    $listaTipoAdenda = ContratoPlazo::getTiposAdendaFinanciera();
    $tiposTiempos = ContratoPlazo::getTiempos();
    return view('Contratos.PlazoFijo.EditarContratoPlazo', compact('contrato','listaProyectos', 'listaMonedas','tiposTiempos', 'listaSedes','listaTipoAdenda'));
  }

  function Guardar(Request $request)
  {

    try {
      db::beginTransaction();

      $empLogeado = Empleado::getEmpleadoLogeado();

      $contrato = new ContratoPlazo();
      $contrato->setDataFromRequest($request);

      $contrato->codEmpleadoCreador = $empLogeado->codEmpleado;
      $contrato->fechaHoraGeneracion = Carbon::now();
      $contrato->es_borrador = 0;

      $contrato->codigo_unico = ContratoPlazo::calcularCodigoCedepas(Numeracion::getNumeracionCPF());
      Numeracion::aumentarNumeracionCPF();

      $contrato->save();

      DB::commit();
      return redirect()->route('ContratosPlazo.Editar',$contrato->codContratoPlazo)->with('datos_ok', "Se ha creado exitosamente el contrato " . $contrato->codigo_unico);
    } catch (\Throwable $th) {

      Debug::LogMessage($th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('ContratosPlazo.Listar')->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }


  function Actualizar(Request $request)
  {
    try {
      db::beginTransaction();

      $contrato = ContratoPlazo::findOrFail($request->codContratoPlazo);
      $contrato->setDataFromRequest($request);

      $contrato->save();

      DB::commit();
      return redirect()->route('ContratosPlazo.Editar',$request->codContratoPlazo)->with('datos_ok', "Se ha actualizado exitosamente el contrato " . $contrato->codigo_unico);
    } catch (\Throwable $th) {
      Debug::LogMessage($th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('ContratosPlazo.Listar')->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }




  public function descargarPDF($codContrato)
  {
    $contrato = ContratoPlazo::findOrFail($codContrato);
    $pdf = $contrato->getPDF();
    return $pdf->stream('Contrato ' . $contrato->getTituloContrato() . '.Pdf', array("Attachment" => true));
  }

  public function verPDF($codContrato)
  {
    $contrato = ContratoPlazo::findOrFail($codContrato);
    $pdf = $contrato->getPDF();
    return $pdf->stream('Contrato ' . $contrato->getTituloContrato() . '.Pdf', array("Attachment" => false));
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

  /* Retorna la url para visualizar el PDF */
  public function GenerarBorrador(Request $request){

    $contrato = new ContratoPlazo();

    $contrato->setDataFromRequest($request);
    $contrato->es_borrador = 1;
    $contrato->fechaHoraGeneracion = Carbon::now();
    $contrato->codigo_unico = ContratoPlazo::calcularCodigoCedepas(Numeracion::getNumeracionCPF());
    /* NO GUARDAMOS */

    $pdf = $contrato->getPDF();

    $fecha_actual = time();
    $nombre_guardado = "CP_".$fecha_actual.".pdf";

    $generated_file = $pdf->output();

    Storage::put("/borradores_pdf/$nombre_guardado",$generated_file);

    return RespuestaAPI::respuestaDatosOk("Se generó exitosamente el borrador",$nombre_guardado);

  }



  public static function VerBorrador($filename){
    $file = Storage::get("borradores_pdf/$filename");
    return static::setPDFResponse($file);
  }

  public static function setPDFResponse($data){
    return response($data, 200)->header('Content-Type', 'application/pdf');
  }


}
