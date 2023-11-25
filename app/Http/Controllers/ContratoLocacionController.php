<?php

namespace App\Http\Controllers;

use App\AvanceEntregable;
use App\Configuracion;
use App\ContratoLocacion;
use App\Debug;
use App\Empleado;
use App\ErrorHistorial;
use App\Fecha;
use App\Http\Controllers\Controller;
use App\Moneda;
use App\Numeracion;
use App\Puesto;
use App\Sede;
use App\TipoOperacion;
use App\UI\UIFiltros;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    return view(
      'Contratos.LocacionServicios.ListarContratosLocacion',
      compact(
        'listaContratos',
        'listaEmpleadosQueGeneraronContratosLocacion',
        'filtros_usados_paginacion',
        'filtros_usados',
        'listaMonedas',
        'listaNombresDeContratados',
        'listaRazonesSociales'
      )
    );
  }

  public function Crear()
  {

    $listaMonedas = Moneda::All();
    $listaSedes = Sede::All();
    return view('Contratos.LocacionServicios.CrearContratoLocacion', compact('listaMonedas', 'listaSedes'));
  }

  public function guardar(Request $request)
  {
    try {

      DB::beginTransaction();
      $contrato = new ContratoLocacion();
      $empleadoLogeado = Empleado::getEmpleadoLogeado();

      /* Campos generales */
      $contrato->setFromRequest($request);

      $contrato->codEmpleadoCreador = $empleadoLogeado->codEmpleado;
      $contrato->fechaHoraGeneracion =  Carbon::now();

      $contrato->codigo_unico = ContratoLocacion::calcularCodigoCedepas(Numeracion::getNumeracionCLS());
      Numeracion::aumentarNumeracionCLS();

      $contrato->save();

      if ($request->cantElementos == 0)
        throw new Exception("No se ingresó ningún item.", 1);


      $i = 0;
      $cantidadFilas = $request->cantElementos;
      while ($i < $cantidadFilas) {
        $avance = new AvanceEntregable();
        $avance->fechaEntrega =         Fecha::formatoParaSQL($request->get('colFecha' . $i));
        $avance->descripcion =          $request->get('colDescripcion' . $i);
        $avance->monto =                $request->get('colMonto' . $i);
        $avance->porcentaje  =         $request->get('colPorcentaje' . $i);
        $avance->codContratoLocacion =          $contrato->codContratoLocacion; //ultimo insertad

        $avance->save();
        $i = $i + 1;
      }

      DB::commit();
      return redirect()->route('ContratosLocacion.Listar')->with('datos', 'Se ha creado el contrato ' . $contrato->codigo_unico);
    } catch (\Throwable $th) {

      Debug::mensajeError('CONTRATO LOCACION : STORE', $th);

      DB::rollback();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('ContratosLocacion.Listar')->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }

  public function descargarPDF($codContrato)
  {


    $contrato = ContratoLocacion::findOrFail($codContrato);
    $pdf = $contrato->getPDF();
    //return $pdf;
    return $pdf->download('Contrato ' . $contrato->getTituloContrato() . '.Pdf');
  }

  public function verPDF($codContrato)
  {
    $contrato = ContratoLocacion::findOrFail($codContrato);
    $pdf = $contrato->getPDF();
    //return view('Contratos.contratoLocacionPDF',compact('contrato'));
    /*
        return $pdf;
        */


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
        return redirect()
          ->route('ContratosLocacion.Listar')
          ->with('datos', 'El contrato solo puede ser anulado por la persona que lo creó');

      $contrato->fechaHoraAnulacion = Carbon::now();
      $contrato->save();

      DB::commit();
      return redirect()
        ->route('ContratosLocacion.Listar')
        ->with('datos', 'Se ha ANULADO el contrato ' . $contrato->codigo_unico);
    } catch (\Throwable $th) {
      Debug::mensajeError('CONTRATO LOCACION : ANULAR', $th);
      DB::rollback();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        $codContrato
      );
      return redirect()
        ->route('ContratosLocacion.Listar')
        ->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }
}
