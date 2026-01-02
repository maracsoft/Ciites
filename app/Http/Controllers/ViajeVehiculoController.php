<?php

namespace App\Http\Controllers;


use App\Utils\Configuracion;
use App\ViajeVehiculo;
use App\Debug;
use App\Empleado;
use App\ErrorHistorial;
use App\EstadoViajeVehiculo;
use App\Http\Controllers\Controller;
use App\Sede;
use App\UI\UIFiltros;
use App\Utils\MaracUtils;
use App\Vehiculo;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ViajeVehiculoController extends Controller
{
  const PAGINATION = 20;

  /* ************************** CONDUCTOR DE VEHICULO  ************************** */
  /* ************************** CONDUCTOR DE VEHICULO  ************************** */
  /* ************************** CONDUCTOR DE VEHICULO  ************************** */
  /* ************************** CONDUCTOR DE VEHICULO  ************************** */
  /* ************************** CONDUCTOR DE VEHICULO  ************************** */
  /* ************************** CONDUCTOR DE VEHICULO  ************************** */
  /* ************************** CONDUCTOR DE VEHICULO  ************************** */
  /* ************************** CONDUCTOR DE VEHICULO  ************************** */
  /* ************************** CONDUCTOR DE VEHICULO  ************************** */
  /* ************************** CONDUCTOR DE VEHICULO  ************************** */
  /* ************************** CONDUCTOR DE VEHICULO  ************************** */
  /* ************************** CONDUCTOR DE VEHICULO  ************************** */
  /* ************************** CONDUCTOR DE VEHICULO  ************************** */


  public function ListarParaConductor(Request $request)
  {
    $empLogeado = Empleado::getEmpleadoLogeado();

    $query_viajes = ViajeVehiculo::where('codEmpleadoRegistrador', $empLogeado->codEmpleado);

    $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($query_viajes, $request->getQueryString());

    $query_viajes = UIFiltros::buildQuery($query_viajes, $request->getQueryString());
    $filtros_usados = UIFiltros::getQueryValues($query_viajes, $request->getQueryString());

    $listaViajes = EstadoViajeVehiculo::ordenarParaConductor($query_viajes)->orderBy('codViaje', 'DESC')->paginate($this::PAGINATION);

    $listaEmpleados = Empleado::getListaEmpleadosPorApellido();
    $listaSedes = Sede::All();
    $listaVehiculos = Vehiculo::GetTodosParaFront();
    $listaAprobadores = Empleado::getEmpleadosAprobadoresViajes();



    return view('ViajeVehiculo.Conductor.ListarViajes', compact('listaViajes', 'listaEmpleados', 'filtros_usados', 'listaAprobadores', 'filtros_usados_paginacion', 'listaSedes', 'listaVehiculos', 'empLogeado'));
  }




  public function Crear($placa)
  {


    $empLogeado = Empleado::getEmpleadoLogeado();

    $vehiculo = Vehiculo::findByPlaca($placa);

    if ($vehiculo->tieneViajeAbierto()) {
      return redirect()->route('MensajeError', ['mensaje' => 'No puede registrar un viaje con este vehículo ' . $vehiculo->placa . ' porque tiene viajes abiertos']);
    }

    $codVehiculo = $vehiculo->getId();

    $viaje = new ViajeVehiculo();
    $viaje->codVehiculo = $codVehiculo;
    $viaje->codEmpleadoRegistrador = $empLogeado->getId();
    $viaje->fechaHoraSalida = Carbon::now();

    $listaEmpleados = Empleado::getEmpleadosAprobadoresViajes();

    return view('ViajeVehiculo.Conductor.CrearViaje', compact('viaje', 'vehiculo', 'listaEmpleados'));
  }

  public function Guardar(Request $request)
  {

    try {
      DB::beginTransaction();
      $empLogeado = Empleado::getEmpleadoLogeado();

      $vehiculo = Vehiculo::findOrFail($request->codVehiculo);
      $viaje = new ViajeVehiculo();

      $viaje->codEmpleadoRegistrador = $empLogeado->codEmpleado;
      $viaje->codVehiculo = $request->codVehiculo;
      $viaje->estado = EstadoViajeVehiculo::ABIERTO;
      $viaje->fechaHoraRegistro = Carbon::now();

      $viaje->setDataFromRequest($request);

      $viaje->save();

      db::commit();
      return redirect()->route('ViajeVehiculo.Conductor.Ver', $viaje->getId())->with('datos_ok', "Viaje " . $viaje->placa . " guardado exitosamente.");
    } catch (\Throwable $th) {
      Debug::LogMessage($th);
      DB::rollback();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('ViajeVehiculo.Conductor.Listar')->with('datos_error', Configuracion::getMensajeError($codErrorHistorial));
    }
  }

  public function ActualizarDatosSalida(Request $request)
  {
    try {
      DB::beginTransaction();

      $viaje = ViajeVehiculo::findOrFail($request->codViaje);
      if (!$viaje->sePuedeEditar()) {
        return redirect()->route('ViajeVehiculo.Conductor.Ver', $viaje->getId())->with('datos_error', "Ya se venció el tiempo de edición del viaje.");
      }

      $viaje->setDataFromRequest($request);

      $viaje->save();

      db::commit();
      return redirect()->route('ViajeVehiculo.Conductor.Ver', $viaje->getId())->with('datos_ok', "Viaje " . $viaje->placa . " actualizado exitosamente.");
    } catch (\Throwable $th) {
      Debug::LogMessage($th);
      DB::rollback();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('ViajeVehiculo.Conductor.Listar')->with('datos_error', Configuracion::getMensajeError($codErrorHistorial));
    }
  }



  public function Finalizar(Request $request)
  {

    try {
      DB::beginTransaction();
      $empLogeado = Empleado::getEmpleadoLogeado();

      $viaje = ViajeVehiculo::findOrFail($request->codViaje);
      $viaje->setDataFromRequest_FinalizarViaje($request);

      $viaje->save();

      db::commit();
      return redirect()->route('ViajeVehiculo.Conductor.Ver', $viaje->getId())->with('datos_ok', "Viaje " . $viaje->placa . " cerrado exitosamente.");
    } catch (\Throwable $th) {
      Debug::LogMessage($th);
      DB::rollback();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('ViajeVehiculo.Conductor.Listar')->with('datos_error', Configuracion::getMensajeError($codErrorHistorial));
    }
  }

  public function VerParaConductor($id)
  {


    $viaje = ViajeVehiculo::findOrFail($id);
    $vehiculo = $viaje->getVehiculo();
    $empLogeado = Empleado::getEmpleadoLogeado();
    $listaAprobadores = Empleado::getEmpleadosAprobadoresViajes();

    return view('ViajeVehiculo.Conductor.VerViaje', compact('viaje', 'vehiculo', 'empLogeado', 'listaAprobadores'));
  }




  public function Eliminar($codViaje)
  {
    try {

      DB::beginTransaction();
      $viaje = ViajeVehiculo::findOrFail($codViaje);
      if (!$viaje->sePuedeEliminar()) {
        return redirect()->route('ViajeVehiculo.Conductor.Listar')->with('datos_error', "No se puede eliminar el viaje " . $viaje->placa);
      }

      $cod = $viaje->getId();
      $viaje->delete();

      DB::commit();
      return redirect()->route('ViajeVehiculo.Conductor.Listar')->with('datos_ok', 'Se ha eliminado exitosamente el viaje ' . $cod);
    } catch (\Throwable $th) {
      Debug::LogMessage($th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        $codViaje
      );
      return redirect()->route('ViajeVehiculo.Conductor.Listar')->with('datos_error', Configuracion::getMensajeError($codErrorHistorial));
    }
  }



  /* RUTA PUBLICA PARA REGISTRAR QR */
  public function ManejarQR(string $placa)
  {

    $hay_logeado = Empleado::hayEmpleadoLogeado();
    if ($hay_logeado) {
      return redirect()->route('ViajeVehiculo.Conductor.Crear', $placa);
    }

    $url = route('ViajeVehiculo.Conductor.Crear', $placa);

    return redirect()->route('user.verLogin', ['redirect_to' => $url]);
  }


  /* ************************** APROBADOR DE VIAJES  ************************** */
  /* ************************** APROBADOR DE VIAJES  ************************** */
  /* ************************** APROBADOR DE VIAJES  ************************** */
  /* ************************** APROBADOR DE VIAJES  ************************** */
  /* ************************** APROBADOR DE VIAJES  ************************** */
  /* ************************** APROBADOR DE VIAJES  ************************** */
  /* ************************** APROBADOR DE VIAJES  ************************** */
  /* ************************** APROBADOR DE VIAJES  ************************** */
  /* ************************** APROBADOR DE VIAJES  ************************** */


  public function ListarParaAprobador(Request $request)
  {
    $empLogeado = Empleado::getEmpleadoLogeado();

    $query_viajes = ViajeVehiculo::query();

    $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($query_viajes, $request->getQueryString());

    $query_viajes = UIFiltros::buildQuery($query_viajes, $request->getQueryString());
    $filtros_usados = UIFiltros::getQueryValues($query_viajes, $request->getQueryString());

    $listaViajes = EstadoViajeVehiculo::ordenarParaAprobadorViajes($query_viajes)->orderBy('codViaje', 'DESC')->paginate($this::PAGINATION);

    $listaEmpleados = Empleado::getListaEmpleadosPorApellido();
    $listaSedes = Sede::All();
    $listaVehiculos = Vehiculo::GetTodosParaFront();
    $listaConductores = Empleado::getEmpleadosConductores();

    return view('ViajeVehiculo.Aprobador.ListarViajes', compact('listaViajes', 'listaEmpleados', 'filtros_usados', 'filtros_usados_paginacion', 'listaSedes', 'listaVehiculos', 'empLogeado', 'listaConductores'));
  }

  public function VerParaAprobador($id)
  {


    $viaje = ViajeVehiculo::findOrFail($id);
    $vehiculo = $viaje->getVehiculo();
    $empLogeado = Empleado::getEmpleadoLogeado();

    return view('ViajeVehiculo.Aprobador.VerViaje', compact('viaje', 'vehiculo', 'empLogeado'));
  }


  public function ExportarViajes()
  {
    $listaViajes = ViajeVehiculo::query()->orderBy('codViaje', 'DESC')->get();

    $filename = "Viajes registrados en el sistema.xls";

    MaracUtils::ActivarDescargaExcelSegunParametro($filename);

    return view('ViajeVehiculo.ExportarViajes', compact('listaViajes'));
  }





  /* ************************** CONTADOR DE VIAJES  ************************** */
  /* ************************** CONTADOR DE VIAJES  ************************** */
  /* ************************** CONTADOR DE VIAJES  ************************** */
  /* ************************** CONTADOR DE VIAJES  ************************** */
  /* ************************** CONTADOR DE VIAJES  ************************** */
  /* ************************** CONTADOR DE VIAJES  ************************** */
  /* ************************** CONTADOR DE VIAJES  ************************** */
  /* ************************** CONTADOR DE VIAJES  ************************** */
  /* ************************** CONTADOR DE VIAJES  ************************** */



  public function ListarParaContador(Request $request)
  {
    $empLogeado = Empleado::getEmpleadoLogeado();

    $query_viajes = ViajeVehiculo::query();

    $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($query_viajes, $request->getQueryString());

    $query_viajes = UIFiltros::buildQuery($query_viajes, $request->getQueryString());
    $filtros_usados = UIFiltros::getQueryValues($query_viajes, $request->getQueryString());

    $listaViajes = EstadoViajeVehiculo::ordenarParaContadorViajes($query_viajes)->orderBy('codViaje', 'DESC')->paginate($this::PAGINATION);

    $listaEmpleados = Empleado::getListaEmpleadosPorApellido();
    $listaSedes = Sede::All();
    $listaVehiculos = Vehiculo::GetTodosParaFront();
    $listaConductores = Empleado::getEmpleadosConductores();

    return view('ViajeVehiculo.Contador.ListarViajes', compact('listaViajes', 'listaEmpleados', 'filtros_usados', 'filtros_usados_paginacion', 'listaSedes', 'listaVehiculos', 'empLogeado', 'listaConductores'));
  }

  public function VerParaContador($id)
  {


    $viaje = ViajeVehiculo::findOrFail($id);
    $vehiculo = $viaje->getVehiculo();
    $empLogeado = Empleado::getEmpleadoLogeado();

    return view('ViajeVehiculo.Contador.VerViaje', compact('viaje', 'vehiculo', 'empLogeado'));
  }


  /* TODOS */

  public function VerPdf($id)
  {
    $viaje = ViajeVehiculo::findOrFail($id);
    return $viaje->getPdf(false);
  }
  public function DescargarPdf($id)
  {
    $viaje = ViajeVehiculo::findOrFail($id);
    return $viaje->getPdf(true);
  }
}
