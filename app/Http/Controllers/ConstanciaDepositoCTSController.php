<?php

namespace App\Http\Controllers;



use App\ArchivoOrdenCompra;
use App\Banco;
use App\Utils\Configuracion;
use App\ConstanciaDepositoCTS;
use App\Debug;
use App\DetalleOrdenCompra;
use App\Empleado;
use App\ErrorHistorial;
use App\Fecha;
use App\Http\Controllers\Controller;
use App\Moneda;
use App\Numeracion;
use App\OrdenCompra;
use App\PeriodoDirectorGeneral;
use App\Proyecto;
use App\Sede;
use App\UI\UIFiltros;
use App\UnidadMedida;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ConstanciaDepositoCTSController extends Controller
{
  const PAGINATION = 20;

  public function Listar(Request $request)
  {


    $query_constancias = ConstanciaDepositoCTS::query();

    $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($query_constancias, $request->getQueryString());

    $query_constancias = UIFiltros::buildQuery($query_constancias, $request->getQueryString());
    $filtros_usados = UIFiltros::getQueryValues($query_constancias, $request->getQueryString());

    $listaConstancias = $query_constancias->orderBy('codConstancia', 'DESC')->paginate($this::PAGINATION);


    $listaEmpleados = Empleado::getListaEmpleadosPorApellido();

    return view('ConstanciaDeposito.ListarConstancias', compact('listaConstancias', 'listaEmpleados', 'filtros_usados', 'filtros_usados_paginacion'));
  }




  public function Crear()
  {
    $empLogeado = Empleado::getEmpleadoLogeado();

    $objNumeracion = Numeracion::getNumeracionCTS();

    $constancia = new ConstanciaDepositoCTS();
    $constancia->codigo_unico = ConstanciaDepositoCTS::calcularCodigoCedepasLibre($objNumeracion);
    $constancia->codEmpleadoCreador = $empLogeado->codEmpleado;
    $constancia->fechaHoraCreacion = Carbon::now();

    $constancia->fecha_deposito = Carbon::now();
    $constancia->fecha_emision = "15-05-" . date("Y");


    $title = "Registrar constancia depósito CTS";
    $action = route('ConstanciaDepositoCTS.Guardar');
    $listaBancos = Banco::All();

    return view('ConstanciaDeposito.CrearEditarConstancia', compact('constancia', 'listaBancos', 'title', 'action'));
  }

  public function Guardar(Request $request)
  {

    try {
      DB::beginTransaction();
      $empLogeado = Empleado::getEmpleadoLogeado();

      $constancia = new ConstanciaDepositoCTS();
      $constancia->setDataFromRequest($request);
      $constancia->codEmpleadoCreador = $empLogeado->codEmpleado;
      $constancia->fechaHoraCreacion = Carbon::now();
      $constancia->codPeriodoDirector = PeriodoDirectorGeneral::getCodPeriodoActivo();
      $constancia->codigo_unico = ConstanciaDepositoCTS::calcularCodigoCedepasLibre(Numeracion::getNumeracionCTS());
      Numeracion::aumentarNumeracionCTS();

      $constancia->save();

      db::commit();
      return redirect()->route('ConstanciaDepositoCTS.Editar', $constancia->getId())->with('datos_ok', "Constancia " . $constancia->codigo_unico . " generada exitosamente.");
    } catch (\Throwable $th) {
      Debug::LogMessage($th);
      DB::rollback();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('ConstanciaDepositoCTS.Listar')->with('datos_error', Configuracion::getMensajeError($codErrorHistorial));
    }
  }

  public function Editar($id)
  {
    $constancia = ConstanciaDepositoCTS::findOrFail($id);
    $listaBancos = Banco::all();

    $title = "Editar Constancia deposito " . $constancia->codigo_unico;
    $action = route('ConstanciaDepositoCTS.Actualizar');

    return view('ConstanciaDeposito.CrearEditarConstancia', compact('constancia', 'listaBancos', 'title', 'action'));
  }

  public function Ver($id)
  {
    $constancia = ConstanciaDepositoCTS::findOrFail($id);
    return view('ConstanciaDeposito.Ver', compact('constancia'));
  }

  public function Actualizar(Request $request)
  {

    try {

      db::beginTransaction();
      $constancia = ConstanciaDepositoCTS::findOrFail($request->codConstancia);
      /*
      if ($constancia->codEmpleadoCreador != Empleado::getEmpleadoLogeado()->codEmpleado)
        return redirect()->route('ConstanciaDepositoCTS.Listar')->with('datos_error', 'Error: La constancia no puede ser actualizado por un empleado distinto al que la creó.');
      */
      $constancia->setDataFromRequest($request);

      $constancia->save();

      db::commit();

      return redirect()->route('ConstanciaDepositoCTS.Editar', $constancia->getId())->with('datos_ok', 'Se ha actualizado la constancia ' . $constancia->codigoCedepas);
    } catch (\Throwable $th) {
      Debug::LogMessage($th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('ConstanciaDepositoCTS.Editar')->with('datos_error', Configuracion::getMensajeError($codErrorHistorial));
    }
  }



  public function DescargarPdf($codConstancia)
  {
    $constancia = ConstanciaDepositoCTS::findOrFail($codConstancia);
    return $constancia->getPdf(true);
  }


  public function VerPdf($codConstancia)
  {
    $constancia = ConstanciaDepositoCTS::findOrFail($codConstancia);
    return $constancia->getPdf(false);
  }
}
