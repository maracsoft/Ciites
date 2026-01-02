<?php

namespace App\Http\Controllers;


use App\Utils\Configuracion;
use App\Vehiculo;
use App\Utils\Debug;
use App\Empleado;
use App\ErrorHistorial;
use App\Http\Controllers\Controller;
use App\Sede;
use App\UI\UIFiltros;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class VehiculoController extends Controller
{
  const PAGINATION = 20;

  public function Listar(Request $request)
  {


    $query_vehiculos = Vehiculo::query();

    $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($query_vehiculos, $request->getQueryString());

    $query_vehiculos = UIFiltros::buildQuery($query_vehiculos, $request->getQueryString());
    $filtros_usados = UIFiltros::getQueryValues($query_vehiculos, $request->getQueryString());

    $listaVehiculos = $query_vehiculos->orderBy('codVehiculo', 'DESC')->paginate($this::PAGINATION);


    $listaEmpleados = Empleado::getListaEmpleadosPorApellido();
    $listaSedes = Sede::All();

    return view('Vehiculo.ListarVehiculos', compact('listaVehiculos', 'listaEmpleados', 'filtros_usados', 'filtros_usados_paginacion', 'listaSedes'));
  }




  public function Crear()
  {
    $empLogeado = Empleado::getEmpleadoLogeado();

    $vehiculo = new Vehiculo();
    $vehiculo->codEmpleadoRegistrador = $empLogeado->getId();
    $title = "Registrar nuevo vehículo";
    $action = route('Vehiculo.Guardar');

    $listaSedes = Sede::all();

    return view('Vehiculo.CrearEditarVehiculo', compact('vehiculo', 'title', 'action', 'listaSedes'));
  }

  public function Guardar(Request $request)
  {

    try {
      DB::beginTransaction();
      $empLogeado = Empleado::getEmpleadoLogeado();

      $vehiculo = new Vehiculo();
      $vehiculo->setDataFromRequest($request);
      $vehiculo->codEmpleadoRegistrador = $empLogeado->codEmpleado;
      $vehiculo->fechaHoraRegistro = Carbon::now();

      $vehiculo->save();

      db::commit();
      return redirect()->route('Vehiculo.Editar', $vehiculo->getId())->with('datos_ok', "Vehículo " . $vehiculo->placa . " guardado exitosamente.");
    } catch (\Throwable $th) {
      Debug::LogMessage($th);
      DB::rollback();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('Vehiculo.Listar')->with('datos_error', Configuracion::getMensajeError($codErrorHistorial));
    }
  }

  public function Editar($id)
  {
    $vehiculo = Vehiculo::findOrFail($id);

    $title = "Editar vehículo " . $vehiculo->placa;
    $action = route('Vehiculo.Actualizar');
    $listaSedes = Sede::all();

    return view('Vehiculo.CrearEditarVehiculo', compact('vehiculo', 'title', 'action', 'listaSedes'));
  }

  public function Ver($id)
  {
    $vehiculo = Vehiculo::findOrFail($id);
    return view('Vehiculo.Ver', compact('vehiculo'));
  }

  public function Actualizar(Request $request)
  {
    try {

      DB::beginTransaction();
      $vehiculo = Vehiculo::findOrFail($request->codVehiculo);
      $vehiculo->setDataFromRequest($request);
      $vehiculo->save();

      DB::commit();
      return redirect()->route('Vehiculo.Editar', $vehiculo->getId())->with('datos_ok', 'Se ha actualizado el vehiculo ' . $vehiculo->placa);
    } catch (\Throwable $th) {
      Debug::LogMessage($th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('Vehiculo.Editar')->with('datos_error', Configuracion::getMensajeError($codErrorHistorial));
    }
  }


  public function Eliminar($codVehiculo)
  {
    try {

      DB::beginTransaction();
      $vehiculo = Vehiculo::findOrFail($codVehiculo);
      $placa = $vehiculo->placa;
      $vehiculo->delete();

      DB::commit();
      return redirect()->route('Vehiculo.Listar')->with('datos_ok', 'Se ha eliminado el vehiculo ' . $placa);
    } catch (\Throwable $th) {
      Debug::LogMessage($th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        $codVehiculo
      );
      return redirect()->route('Vehiculo.Listar')->with('datos_error', Configuracion::getMensajeError($codErrorHistorial));
    }
  }


  public function VerPdf($codVehiculo)
  {
    $vehi = Vehiculo::findOrFail($codVehiculo);
    return $vehi->getPdf(false);
  }

  public function DescargarPdf($codVehiculo)
  {
    $vehi = Vehiculo::findOrFail($codVehiculo);
    return $vehi->getPdf(true);
  }
}
