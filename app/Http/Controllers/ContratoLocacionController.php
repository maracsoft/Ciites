<?php

namespace App\Http\Controllers;

use App\AvanceEntregable;
use App\Configuracion;
use App\ContratoLocacion;
use App\ContratoPlazo;
use App\Debug;
use App\Empleado;
use App\ErrorHistorial;
use App\Fecha;
use App\Http\Controllers\Controller;
use App\Moneda;
use App\Numeracion;
use App\Puesto;
use App\RespuestaAPI;
use App\Sede;
use App\TipoOperacion;
use App\UI\UIFiltros;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ContratoLocacionController extends Controller
{

  const PAGINATION = 25;

  public function listar(Request $request)
  {

    $listaContratos =  ContratoLocacion::query();

    $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaContratos, $request->getQueryString());

    $listaSolicitudesFondos = UIFiltros::buildQuery($listaContratos, $request->getQueryString());
    $filtros_usados = UIFiltros::getQueryValues($listaContratos, $request->getQueryString());

    $listaContratos = $listaContratos->orderBy('codContratoLocacion', 'DESC')->paginate(static::PAGINATION);


    $listaEmpleadosQueGeneraronContratosLocacion = ContratoLocacion::listaEmpleadosQueGeneraronContratosLocacion();
    $listaNombresDeContratados = ContratoLocacion::listaNombresDeContratados();
    $listaRazonesSociales = ContratoLocacion::listaRazonesSociales();

    $listaMonedas = Moneda::All();

    return view('Contratos.LocacionServicios.ListarContratosLocacion',
      compact('listaContratos','listaEmpleadosQueGeneraronContratosLocacion','filtros_usados_paginacion','filtros_usados',
      'listaMonedas','listaNombresDeContratados','listaRazonesSociales')
    );
  }

  public function Crear()
  {

    $listaMonedas = Moneda::All();
    $listaSedes = Sede::All();
    return view('Contratos.LocacionServicios.CrearContratoLocacion', compact('listaMonedas', 'listaSedes'));
  }

  public function Editar($codContrato)
  {

    $contrato = ContratoLocacion::findOrFail($codContrato);

    $listaMonedas = Moneda::All();
    $listaSedes = Sede::All();
    return view('Contratos.LocacionServicios.EditarContratoLocacion', compact('listaMonedas', 'listaSedes','contrato'));
  }

  public function guardar(Request $request)
  {
    try {

      DB::beginTransaction();
      $contrato = new ContratoLocacion();
      $empleadoLogeado = Empleado::getEmpleadoLogeado();

      /* Campos generales */
      $contrato->setDataFromRequest($request);

      $contrato->codEmpleadoCreador = $empleadoLogeado->codEmpleado;
      $contrato->fechaHoraGeneracion =  Carbon::now();
      $contrato->es_borrador = 0;

      $contrato->codigo_unico = ContratoLocacion::calcularCodigoCedepas(Numeracion::getNumeracionCLS());
      Numeracion::aumentarNumeracionCLS();

      $contrato->save();

      $contrato->setDetallesFromRequest($request);

      DB::commit();
      return redirect()->route('ContratosLocacion.Editar',$contrato->getId())->with('datos_ok', 'Se ha creado el contrato ' . $contrato->codigo_unico);
    } catch (\Throwable $th) {

      Debug::mensajeError('CONTRATO LOCACION : STORE', $th);

      DB::rollback();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('ContratosLocacion.Listar')->with('datos_error', Configuracion::getMensajeError($codErrorHistorial));
    }
  }


  public function Actualizar(Request $request)
  {
    try {

      DB::beginTransaction();
      $contrato = ContratoLocacion::findOrFail($request->codContratoLocacion);

      $contrato->setDataFromRequest($request);
      $contrato->save();
      $contrato->setDetallesFromRequest($request);

      DB::commit();
      return redirect()->route('ContratosLocacion.Editar',$request->codContratoLocacion)->with('datos_ok', 'Se ha actualizado el contrato ' . $contrato->codigo_unico);
    } catch (\Throwable $th) {
      Debug::LogMessage($th);

      DB::rollback();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('ContratosLocacion.Listar')->with('datos_error', Configuracion::getMensajeError($codErrorHistorial));
    }
  }




  public function descargarPDF($codContrato)
  {

    $contrato = ContratoLocacion::findOrFail($codContrato);
    $pdf = $contrato->getPDF();

    return $pdf->download('Contrato ' . $contrato->getTituloContrato() . '.Pdf');
  }

  public function verPDF($codContrato)
  {
    $contrato = ContratoLocacion::findOrFail($codContrato);
    $pdf = $contrato->getPDF();

    return $pdf->stream('Contrato ' . $contrato->getTituloContrato() . '.Pdf');
  }

  function Ver($codContrato)
  {
    $contrato = ContratoLocacion::findOrFail($codContrato);
    return view('Contratos.LocacionServicios.VerContratoLocacion', compact('contrato'));
  }


  function Anular($codContrato)
  {
    try {
      db::beginTransaction();



      $empleadoLogeado = Empleado::getEmpleadoLogeado();
      $contrato = ContratoLocacion::findOrFail($codContrato);

      if ($contrato->codEmpleadoCreador != $empleadoLogeado->codEmpleado)
        return redirect()->route('ContratosLocacion.Listar')->with('datos_error', 'El contrato solo puede ser anulado por la persona que lo creó');

      $contrato->fechaHoraAnulacion = Carbon::now();
      $contrato->save();

      DB::commit();
      return redirect()->route('ContratosLocacion.Listar')->with('datos_ok', 'Se ha ANULADO el contrato ' . $contrato->codigo_unico);
    } catch (\Throwable $th) {
      Debug::mensajeError('CONTRATO LOCACION : ANULAR', $th);
      DB::rollback();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        $codContrato
      );
      return redirect()->route('ContratosLocacion.Listar')->with('datos_error', Configuracion::getMensajeError($codErrorHistorial));
    }
  }


  /* Retorna la url para visualizar el PDF */
  public function GenerarBorrador(Request $request){

    $contrato = new ContratoLocacion();

    $contrato->setDataFromRequest($request);
    $contrato->es_borrador = 1;
    $contrato->fechaHoraGeneracion = Carbon::now();
    $contrato->codigo_unico = ContratoLocacion::calcularCodigoCedepas(Numeracion::getNumeracionCLS());
    /* NO GUARDAMOS */

    $detalles = $contrato->setDetallesFromRequest($request,false);

    $pdf = $contrato->getPDF($detalles);


    $fecha_actual = time();
    $nombre_guardado = "CL_".$fecha_actual.".pdf";

    $generated_file = $pdf->output();

    Storage::put("/borradores_pdf/$nombre_guardado",$generated_file);

    return RespuestaAPI::respuestaDatosOk("Se generó exitosamente el borrador",$nombre_guardado);

  }



}
