<?php

namespace App\Http\Controllers;

use App\Utils\Configuracion;
use App\ArchivoSolicitud;
use App\BackendValidator;
use App\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\SolicitudFondos;
use App\Banco;
use App\DetalleSolicitudFondos;
use App\Proyecto;
use App\Sede;
use Illuminate\Support\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;
use App\CDP;
use App\EstadoOrden;
use App\EstadoSolicitudFondos;
use App\SolicitudFalta;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use PhpParser\Node\Expr\Throw_;
use App\Moneda;
use App\Debug;
use App\ErrorHistorial;
use App\Numeracion;
use App\ProyectoContador;
use App\ProyectoObservador;
use App\Puesto;
use App\TipoOperacion;
use App\UI\UIFiltros;

class SolicitudFondosController extends Controller


{

  const PAGINATION = 25;


  public function listarDetalles($id)
  {
    $listaDetalles = DetalleSolicitudFondos::where('codSolicitud', '=', $id)->get();

    return $listaDetalles;
  }


  //funcion cuello de botella para volver al index desde el VER SOLICITUD (pq estoy usando la misma vista)
  /* DEPRECATED */
  public function listarSolicitudes()
  {
    $empleado = Empleado::getEmpleadoLogeado();
    $msj = session('datos');
    $datos = '';
    if ($msj != '')
      $datos = 'datos';

    if ($empleado->esGerente()) {
      //lo enrutamos hacia su index
      return redirect()->route('SolicitudFondos.Gerente.Listar')->with($datos, $msj);
    }

    if ($empleado->esJefeAdmin()) //si es jefe de Administracion
    {
      return redirect()->route('SolicitudFondos.Administracion.Listar')->with($datos, $msj);
    }

    return redirect()->route('SolicitudFondos.Empleado.Listar')->with($datos, $msj);
  }





  public function listarSolicitudesDeEmpleado(Request $request)
  {

    $empleado = Empleado::getEmpleadoLogeado();

    $listaSolicitudesFondos = SolicitudFondos::where('codEmpleadoSolicitante', '=', $empleado->codEmpleado);

    $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaSolicitudesFondos, $request->getQueryString());

    $listaSolicitudesFondos = UIFiltros::buildQuery($listaSolicitudesFondos, $request->getQueryString());
    $filtros_usados = UIFiltros::getQueryValues($listaSolicitudesFondos, $request->getQueryString());

    $listaSolicitudesFondos = SolicitudFondos::ordenarParaEmpleado($listaSolicitudesFondos)->paginate($this::PAGINATION);


    $proyectos = Proyecto::getProyectosActivos();
    $listaBancos = Banco::All();
    $fechaInicio = $request->fechaInicio;
    $fechaFin = $request->fechaFin;

    return view('SolicitudFondos.Empleado.ListarSolicitudes', compact('proyectos', 'listaSolicitudesFondos', 'listaBancos', 'empleado', 'filtros_usados_paginacion', 'filtros_usados'));
  }










  /* FUNCION ACTIVADA POR UN Gerente */
  public function listarSolicitudesParaGerente(Request $request)
  {

    $empleado = Empleado::getEmpleadoLogeado();

    $proyectosDelGerente = $empleado->getListaProyectos();

    if (count($proyectosDelGerente) == 0)
      return redirect()->route('error')->with('datos', "No tiene ningún proyecto asignado.");



    $listaSolicitudesFondos = $empleado->getListaSolicitudesDeGerente2();
    $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaSolicitudesFondos, $request->getQueryString());

    $listaSolicitudesFondos = UIFiltros::buildQuery($listaSolicitudesFondos, $request->getQueryString());
    $filtros_usados = UIFiltros::getQueryValues($listaSolicitudesFondos, $request->getQueryString());

    $listaSolicitudesFondos = SolicitudFondos::ordenarParaGerente($listaSolicitudesFondos)->paginate($this::PAGINATION);



    $empleados = Empleado::getListaEmpleadosPorApellido();
    $listaBancos = Banco::All();
    $fechaInicio = $request->fechaInicio;
    $fechaFin = $request->fechaFin;

    return view('SolicitudFondos.Gerente.ListarSolicitudes', compact(
      'filtros_usados_paginacion',
      'filtros_usados',
      'listaSolicitudesFondos',
      'listaBancos',
      'empleado',
      'proyectosDelGerente',
      'empleados'
    ));
  }



  /* DEBE LISTARLE
        LAS QUE ESTÁN APROBADAS (Para que las abone)
        Las que están rendidas (para que las registre)
    */
  public function listarSolicitudesParaJefe(Request $request)
  {

    $empleado = Empleado::getEmpleadoLogeado();

    $estados = [];
    array_push($estados, SolicitudFondos::getCodEstado('Aprobada'));
    array_push($estados, SolicitudFondos::getCodEstado('Abonada'));
    array_push($estados, SolicitudFondos::getCodEstado('Contabilizada'));

    $listaSolicitudesFondos = SolicitudFondos::whereIn('solicitud_fondos.codEstadoSolicitud', $estados);
    $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaSolicitudesFondos, $request->getQueryString());

    $listaSolicitudesFondos = UIFiltros::buildQuery($listaSolicitudesFondos, $request->getQueryString());
    $filtros_usados = UIFiltros::getQueryValues($listaSolicitudesFondos, $request->getQueryString());


    $listaSolicitudesFondos = SolicitudFondos::ordenarParaAdministrador($listaSolicitudesFondos)->paginate($this::PAGINATION);

    $proyectos = Proyecto::getProyectosActivos();
    $empleados = Empleado::getListaEmpleadosPorApellido();
    $listaBancos = Banco::All();

    return view(
      'SolicitudFondos.Administracion.ListarSolicitudes',
      compact('empleados', 'proyectos', 'filtros_usados', 'filtros_usados_paginacion', 'listaSolicitudesFondos', 'listaBancos', 'empleado')
    );
  }

  public function listarSolicitudesParaContador(Request $request)
  {


    $empleado = Empleado::getEmpleadoLogeado();

    $estados = [];
    array_push($estados, SolicitudFondos::getCodEstado('Abonada'));
    array_push($estados, SolicitudFondos::getCodEstado('Contabilizada'));

    //para ver que proyectos tiene el Contador
    $detalles = ProyectoContador::where('codEmpleadoContador', '=', $empleado->codEmpleado)->get();
    if (count($detalles) == 0 && !Empleado::getEmpleadoLogeado()->esAdminSistema()) //si no tiene proyectos y no es admin (si es admin pasa nomas)
      return redirect()->route('error')->with('datos', "No tiene ningún proyecto asignado.");

    $arrayCodProyectosDelContador = [];
    foreach ($detalles as $itemproyecto) {
      $arrayCodProyectosDelContador[] = $itemproyecto->codProyecto;
    }

    $listaSolicitudesFondos = SolicitudFondos::whereIn('solicitud_fondos.codEstadoSolicitud', $estados)->whereIn('codProyecto', $arrayCodProyectosDelContador);

    $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaSolicitudesFondos, $request->getQueryString());

    $listaSolicitudesFondos = UIFiltros::buildQuery($listaSolicitudesFondos, $request->getQueryString());
    $filtros_usados = UIFiltros::getQueryValues($listaSolicitudesFondos, $request->getQueryString());

    $listaSolicitudesFondos = SolicitudFondos::ordenarParaContador($listaSolicitudesFondos)->paginate($this::PAGINATION);


    $proyectosDelContador = Proyecto::añadirNombreYcod(Proyecto::whereIn('codProyecto', $arrayCodProyectosDelContador)->get());
    $empleados = Empleado::getListaEmpleadosPorApellido();


    return view('SolicitudFondos.Contador.ListarSolicitudes', compact('listaSolicitudesFondos', 'empleado', 'empleados', 'proyectosDelContador', 'filtros_usados_paginacion', 'filtros_usados'));
  }


  public function listarSolicitudesParaObservador(Request $request)
  {

    $empleado = Empleado::getEmpleadoLogeado();

    $listaProyectoObservador = ProyectoObservador::where('codEmpleadoObservador', $empleado->getId())->get();
    $estadosSolicitud = EstadoSolicitudFondos::All();


    $codsProyectos = [];
    foreach ($listaProyectoObservador as $proy_obs) {
      $codsProyectos[] = $proy_obs->codProyecto;
    }

    if (count($codsProyectos) == 0)
      return redirect()->route('error')->with('datos', "No tiene ningún proyecto asignado para observar.");

    $proyectosDelObservador = Proyecto::whereIn('codProyecto', $codsProyectos)->orderBy('codigoPresupuestal', 'ASC')->get();
    $proyectosDelObservador = Proyecto::añadirNombreYcod($proyectosDelObservador);

    $listaSolicitudesFondos = SolicitudFondos::whereIn('codProyecto', $codsProyectos);
    $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaSolicitudesFondos, $request->getQueryString());

    $listaSolicitudesFondos = UIFiltros::buildQuery($listaSolicitudesFondos, $request->getQueryString());
    $filtros_usados = UIFiltros::getQueryValues($listaSolicitudesFondos, $request->getQueryString());

    $listaSolicitudesFondos = $listaSolicitudesFondos->orderBy('codSolicitud', 'DESC')->paginate($this::PAGINATION);



    $empleados = Empleado::getListaEmpleadosPorApellido();
    $listaBancos = Banco::All();

    return view('SolicitudFondos.Observador.ListarSolicitudes', compact(
      'filtros_usados_paginacion',
      'filtros_usados',
      'proyectosDelObservador',
      'estadosSolicitud',
      'listaSolicitudesFondos',
      'listaBancos',
      'empleado',
      'empleados'
    ));
  }




  //DESPLIEGA LA VISTA PARA VER LA SOLICITUD (VERLA NOMASSS). ES DEL EMPLEAOD ESTA
  public function ver($id)
  {
    $listaBancos = Banco::All();
    $listaProyectos = Proyecto::getProyectosActivos();
    $listaSedes = Sede::All();

    $solicitud = SolicitudFondos::findOrFail($id);
    $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud', '=', $id)->get();

    $empleadoLogeado = Empleado::getEmpleadoLogeado();

    if ($solicitud->codEmpleadoSolicitante != Empleado::getEmpleadoLogeado()->codEmpleado) {
      return redirect()->route('error')->with('datos', '¡Las solicitudes solo pueden ser vistas por su creador!');
    }

    return view('SolicitudFondos.Empleado.VerSolicitudFondos', compact('solicitud', 'detallesSolicitud', 'empleadoLogeado', 'listaBancos', 'listaProyectos', 'listaSedes'));
  }







  //funcion del Gerente, despliega la vista de revision. Si ya la revisó, esta tambien hace funcion de ver
  public function revisar($id)
  {
    $listaBancos = Banco::All();
    $listaProyectos = Proyecto::getProyectosActivos();
    $listaSedes = Sede::All();

    $solicitud = SolicitudFondos::findOrFail($id);
    $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud', '=', $id)->get();

    $empleadoLogeado = Empleado::getEmpleadoLogeado();

    return view('SolicitudFondos.Gerente.RevisarSolicitudFondos', compact('solicitud', 'detallesSolicitud', 'empleadoLogeado', 'listaBancos', 'listaProyectos', 'listaSedes'));
  }

  public function aprobar(Request $request)
  {
    //return $request;
    try {
      DB::beginTransaction();
      $solicitud = SolicitudFondos::findOrFail($request->codSolicitud);


      if (!$solicitud->listaParaAprobar())
        return redirect()->route('solicitudFondos.ListarSolicitudes')
          ->with('datos', 'ERROR: La solicitud ya fue aprobada o no está apta para serlo.');

      $solicitud->codEstadoSolicitud = SolicitudFondos::getCodEstado('Aprobada');
      $solicitud->observacion = '';
      $empleadoLogeado = Empleado::getEmpleadoLogeado();

      $solicitud->codEmpleadoEvaluador = $empleadoLogeado->codEmpleado;
      $solicitud->fechaHoraRevisado = Carbon::now();
      $solicitud->justificacion = $request->justificacion;
      $solicitud->save();


      $solicitud->registrarOperacion(
        TipoOperacion::getCodTipoOperacion('SOL', 'Aprobar'),
        null,
        Puesto::getCodPuesto_Gerente()
      ); //siempre aprobará el gerente



      $listaDetalles = DetalleSolicitudFondos::where('codSolicitud', '=', $solicitud->codSolicitud)->get();
      foreach ($listaDetalles as $itemDetalle) {
        $itemDetalle->codigoPresupuestal = $request->get('CodigoPresupuestal' . $itemDetalle->codDetalleSolicitud);
        $itemDetalle->save();
      }


      DB::commit();
      return redirect()->route('SolicitudFondos.Gerente.Listar')
        ->with('datos', 'Solicitud ' . $solicitud->codigoCedepas . ' Aprobada! ');
    } catch (\Throwable $th) {
      Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : APROBAR', $th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('SolicitudFondos.Gerente.Listar')
        ->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }


  public function contabilizar($id)
  {
    try {
      DB::beginTransaction();
      $solicitud = SolicitudFondos::findOrFail($id);

      if (!$solicitud->listaParaContabilizar())
        return redirect()->route('solicitudFondos.ListarSolicitudes')
          ->with('datos', 'ERROR: La solicitud ya fue contabilizada o no está apta para serlo.');

      $solicitud->codEstadoSolicitud = SolicitudFondos::getCodEstado('Contabilizada');
      $empleadoLogeado = Empleado::getEmpleadoLogeado();

      $solicitud->codEmpleadoContador = $empleadoLogeado->codEmpleado;
      $solicitud->save();


      $solicitud->registrarOperacion(
        TipoOperacion::getCodTipoOperacion('SOL', 'Contabilizar'),
        null,
        Puesto::getCodPuesto_Contador()
      ); //siempre contabilizará el contador

      DB::commit();

      return redirect()->route('SolicitudFondos.Contador.Listar')
        ->with('datos', 'Solicitud ' . $solicitud->codigoCedepas . ' Contabilizada! ');
    } catch (\Throwable $th) {
      Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : CONTABILIZAR', $th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError($th, app('request')->route()->getAction(), $id);
      return redirect()->route('SolicitudFondos.Contador.Listar')
        ->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }

  public function vistaAbonar($id)
  {
    $solicitud = SolicitudFondos::findOrFail($id);
    $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud', '=', $id)->get();
    return view('SolicitudFondos.Administracion.AbonarSolicitudFondos', compact('solicitud', 'detallesSolicitud'));
  }


  public function VerSolicitudComoObservador($id)
  {
    $solicitud = SolicitudFondos::findOrFail($id);
    $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud', '=', $id)->get();
    return view('SolicitudFondos.Observador.VerSolicitud', compact('solicitud', 'detallesSolicitud'));
  }



  //CAMBIA EL ESTADO DE LA SOLICITUD A ABONADA, Y GUARDA LA FECHA HORA ABONADO
  public function abonar(Request $request)
  {
    $id = $request->codSolicitud;
    try {
      DB::beginTransaction();
      $solicitud = SolicitudFondos::findOrFail($id);

      if (!$solicitud->listaParaAbonar())
        return redirect()->route('solicitudFondos.ListarSolicitudes')
          ->with('datos', 'ERROR: La solicitud ya fue abonada o no está apta para serlo.');
      $solicitud->codEstadoSolicitud = SolicitudFondos::getCodEstado('Abonada');
      $solicitud->codEmpleadoAbonador = Empleado::getEmpleadoLogeado()->codEmpleado;
      $solicitud->fechaHoraAbonado = Carbon::now();
      $solicitud->save();

      $solicitud->registrarOperacion(
        TipoOperacion::getCodTipoOperacion('SOL', 'Abonar'),
        null,
        Puesto::getCodPuesto_Administrador()
      ); //siempre abonará el admin


      DB::commit();
      return redirect()->route('SolicitudFondos.Administracion.Listar')
        ->with('datos', '¡Solicitud ' . $solicitud->codigoCedepas . ' Abonada!');
    } catch (\Throwable $th) {
      Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : ABONAR', $th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('SolicitudFondos.Administracion.Listar')
        ->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }



  function rellernarCerosIzq($numero, $nDigitos)
  {
    return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);
  }


  public function observarGerente(Request $request)
  {
    try {
      DB::beginTransaction();
      $solicitud = $this->observarGenerico($request->codSolicitudModal, $request->observacion, Puesto::getCodPuesto_Gerente());
      DB::commit();

      return redirect()->route('SolicitudFondos.Gerente.Listar')->with('datos', 'Solicitud ' . $solicitud->codigoCedepas . ' Observada');
    } catch (\Throwable $th) {
      Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : observarGerente', $th);

      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('SolicitudFondos.Gerente.Listar')->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }

  public function observarAdministrador(Request $request)
  {
    try {
      DB::beginTransaction();
      $solicitud = $this->observarGenerico($request->codSolicitudModal, $request->observacion, Puesto::getCodPuesto_Administrador());
      DB::commit();

      return redirect()->route('SolicitudFondos.Administracion.Listar')->with('datos', 'Solicitud ' . $solicitud->codigoCedepas . ' Observada');
    } catch (\Throwable $th) {
      Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : observarAdministrador', $th);

      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('SolicitudFondos.Administracion.Listar')->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }

  private function observarGenerico($codSolicitud, $textoObs, $codPuesto): SolicitudFondos
  {


    $solicitud = SolicitudFondos::findOrFail($codSolicitud);

    $solicitud->codEstadoSolicitud = SolicitudFondos::getCodEstado('Observada');
    $solicitud->observacion = $textoObs;

    $empleadoLogeado = Empleado::getEmpleadoLogeado();

    $solicitud->codEmpleadoEvaluador = $empleadoLogeado->codEmpleado;

    $solicitud->save();


    $solicitud->registrarOperacion(
      TipoOperacion::getCodTipoOperacion('SOL', 'Observar'),
      $textoObs,
      $codPuesto
    ); //aqui depende del que lo esté observando

    return $solicitud;
  }



  public function rechazarGerente($codSolicitud)
  {
    try {

      DB::beginTransaction();

      $solicitud = $this->rechazarGenerico($codSolicitud, Puesto::getCodPuesto_Gerente());


      DB::commit();

      return redirect()->route('SolicitudFondos.Gerente.Listar')->with('datos', 'Solicitud ' . $solicitud->codigoCedepas . ' Rechazada.');
    } catch (\Throwable $th) {
      Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : rechazarGerente', $th);

      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError($th, app('request')->route()->getAction(), $codSolicitud);
      return redirect()->route('SolicitudFondos.Gerente.Listar')->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }

  public function rechazarAdministrador($codSolicitud)
  {
    try {

      DB::beginTransaction();

      $solicitud = $this->rechazarGenerico($codSolicitud, Puesto::getCodPuesto_Administrador());

      DB::commit();

      return redirect()->route('SolicitudFondos.Administracion.Listar')->with('datos', 'Solicitud ' . $solicitud->codigoCedepas . ' Rechazada.');
    } catch (\Throwable $th) {
      Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : rechazarGerente', $th);

      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError($th, app('request')->route()->getAction(), $codSolicitud);
      return redirect()->route('SolicitudFondos.Administracion.Listar')->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }


  public function rechazarGenerico($codSolicitud, $codPuesto): SolicitudFondos
  {

    $solicitud = SolicitudFondos::findOrFail($codSolicitud);
    $solicitud->codEstadoSolicitud = SolicitudFondos::getCodEstado('Rechazada');

    $empleadoLogeado = Empleado::getEmpleadoLogeado();
    $solicitud->codEmpleadoEvaluador = $empleadoLogeado->codEmpleado;
    $solicitud->fechaHoraRevisado = Carbon::now();

    $solicitud->save();

    $solicitud->registrarOperacion(
      TipoOperacion::getCodTipoOperacion('SOL', 'Rechazar'),
      null,
      $codPuesto
    );

    return $solicitud;
  }










  //Despliega la vista de rendir esta solciitud. ES LO MISMO QUE UN CREATE EN EL RendicionFondosController
  public function rendir($id)
  { //le pasamos id de la sol fondos

    $solicitud = SolicitudFondos::findOrFail($id);

    $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud', '=', $solicitud->codSolicitud)->get();
    $listaBancos = Banco::All();
    $listaProyectos = Proyecto::getProyectosActivos();
    $listaSedes = Sede::All();
    $listaCDP = CDP::All();
    $empleadoLogeado = Empleado::getEmpleadoLogeado();
    $objNumeracion = Numeracion::getNumeracionREN();

    return view(
      'RendicionGastos.Empleado.CrearRendicionGastos',
      compact(
        'empleadoLogeado',
        'listaBancos',
        'listaProyectos',
        'listaSedes',
        'solicitud',
        'listaCDP',
        'detallesSolicitud',
        'objNumeracion'
      )
    );
  }





  public function edit($id)
  { //id de la solicidu codSolicitud

    $listaBancos = Banco::All();
    $listaProyectos = Proyecto::getProyectosActivos();
    $listaSedes = Sede::All();
    $listaMonedas = Moneda::All();
    $solicitud = SolicitudFondos::findOrFail($id);
    $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud', '=', $id)->get();
    //return $detallesSolicitud;

    $empleadoLogeado = Empleado::getEmpleadoLogeado();

    if ($solicitud->codEmpleadoSolicitante != Empleado::getEmpleadoLogeado()->codEmpleado) {
      return redirect()->route('error')->with('datos', '¡Las solicitudes solo pueden ser editadas por su creador!');
    }

    return view(
      'SolicitudFondos.Empleado.EditarSolicitudFondos',
      compact(
        'solicitud',
        'detallesSolicitud',
        'empleadoLogeado',
        'listaBancos',
        'listaMonedas',
        'listaProyectos',
        'listaSedes'
      )
    );
  }




  public function create()
  {
    $listaBancos = Banco::All();
    $listaProyectos = Proyecto::getProyectosActivos();
    $listaSedes = Sede::All();
    $listaMonedas = Moneda::All();
    $empleadoLogeado = Empleado::getEmpleadoLogeado();
    $objNumeracion = Numeracion::getNumeracionSOF();

    return view(
      'SolicitudFondos.Empleado.CrearSolicitudFondos',
      compact(
        'empleadoLogeado',
        'listaBancos',
        'listaProyectos',
        'listaMonedas',
        'listaSedes',
        'objNumeracion'
      )
    );
  }

  //funcion servicio a ser consumida por javascript
  public function getNumeracionLibre()
  {
    return Numeracion::getNumeracionSOF()->numeroLibreActual;
  }




  /* CREAR UNA SOLICITUD DE FONDOS */
  public function store(Request $request)
  {

    //return ($request->toArray());
    try {

      //BackendValidator::validarSOF($request);

      DB::beginTransaction();
      $solicitud = new SolicitudFondos();
      $solicitud->codProyecto = $request->ComboBoxProyecto;
      $empleadoLogeado = Empleado::getEmpleadoLogeado();

      $solicitud->codEmpleadoSolicitante = $empleadoLogeado->codEmpleado;

      $solicitud->fechaHoraEmision =  Carbon::now();
      $solicitud->totalSolicitado = $request->total;
      $solicitud->girarAOrdenDe = $request->girarAOrden;
      $solicitud->numeroCuentaBanco = $request->nroCuenta;
      $solicitud->codigoContrapartida = $request->codigoContrapartida;
      $solicitud->codBanco = $request->ComboBoxBanco;
      $solicitud->justificacion = $request->justificacion;
      $solicitud->codEstadoSolicitud = SolicitudFondos::getCodEstado('Creada');

      $solicitud->codMoneda = $request->ComboBoxMoneda;

      $vec[] = '';

      $solicitud->codigoCedepas = SolicitudFondos::calcularCodigoCedepas(Numeracion::getNumeracionSOF());
      Numeracion::aumentarNumeracionSOF();


      $solicitud->save();

      $solicitud->registrarOperacion(
        TipoOperacion::getCodTipoOperacion('SOL', 'Crear'),
        null,
        Puesto::getCodPuesto_Empleado()
      ); //siempre creará el empleado


      if ($request->cantElementos == 0)
        throw new Exception("No se ingresó ningún item.", 1);


      $i = 0;
      $cantidadFilas = $request->cantElementos;
      while ($i < $cantidadFilas) {
        $detalle = new DetalleSolicitudFondos();
        $detalle->codSolicitud =          (SolicitudFondos::latest('codSolicitud')->first())->codSolicitud; //ultimo insertad
        $detalle->nroItem =               $i + 1;
        $detalle->concepto =              $request->get('colConcepto' . $i);
        $detalle->importe =               $request->get('colImporte' . $i);
        $detalle->codigoPresupuestal  =  $request->get('colCodigoPresupuestal' . $i);

        $vec[$i] = $detalle;
        $detalle->save();
        /* Actualizar stock */
        //roducto::ActualizarStock($detalle->productoid,$detalle->cantidad);
        $i = $i + 1;
      }




      if (!is_null($request->nombresArchivos) && $request->nombresArchivos != "[]") { //SI NO ES NULO Y No está vacio

        //$nombresArchivos = explode(', ',$request->nombresArchivos);
        $nombresArchivos = json_decode($request->nombresArchivos); //ahora llega un vector en JSON ["archivo1.pdf","archivo2.pdf"]

        $j = 0;
        foreach ($request->file('filenames') as $archivo) {

          $nombreArchivoGuardado = $solicitud->getNombreGuardadoNuevoArchivo($j + 1);
          Debug::mensajeSimple('el nombre de guardado de la imagen es:' . $nombreArchivoGuardado);


          $archivoRepo = new ArchivoSolicitud();
          $archivoRepo->codSolicitud = $solicitud->codSolicitud;
          $archivoRepo->nombreDeGuardado = $nombreArchivoGuardado;
          $archivoRepo->nombreAparente = $nombresArchivos[$j];
          $archivoRepo->save();

          $fileget = \File::get($archivo);

          Storage::disk('solicitudes')
            ->put($nombreArchivoGuardado, $fileget);
          $j++;
        }
      }



      DB::commit();
      return redirect()
        ->route('SolicitudFondos.Empleado.Listar')
        ->with('datos', 'Se ha creado la solicitud ' . $solicitud->codigoCedepas);
    } catch (\Throwable $th) {

      Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : STORE', $th);

      DB::rollback();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()
        ->route('SolicitudFondos.Empleado.Listar')
        ->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }

  public function verContabilizar($id)
  {
    $listaBancos = Banco::All();
    $listaProyectos = Proyecto::getProyectosActivos();
    $listaSedes = Sede::All();

    $solicitud = SolicitudFondos::findOrFail($id);
    $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud', '=', $id)->get();

    $empleadoLogeado = Empleado::getEmpleadoLogeado();

    return view(
      'SolicitudFondos.Contador.ContabilizarSolicitudFondos',
      compact(
        'solicitud',
        'detallesSolicitud',
        'empleadoLogeado',
        'listaBancos',
        'listaProyectos',
        'listaSedes'
      )
    );
  }


  //actualiza el contenido de una solicitud
  public function update(Request $request, $id)
  {

    try {
      //BackendValidator::validarSOF($request);

      DB::beginTransaction();
      $solicitud = SolicitudFondos::findOrFail($id);


      if (!$solicitud->listaParaUpdate())
        return redirect()->route('solicitudFondos.ListarSolicitudes')
          ->with('datos', 'ERROR: La solicitud no puede ser actualizada.');

      if (Empleado::getEmpleadoLogeado()->codEmpleado != $solicitud->codEmpleadoSolicitante)
        return redirect()->route('solicitudFondos.ListarSolicitudes')
          ->with('datos', 'ERROR: La solicitud no puede ser actualizada por un empleado que no la creó.');



      //Si está siendo editada porque la observaron, pasa de OBSERVADA a SUBSANADA
      if ($solicitud->codEstadoSolicitud == SolicitudFondos::getCodEstado('Observada')) {
        $solicitud->codEstadoSolicitud = SolicitudFondos::getCodEstado('Subsanada');
      }
      //Si no, que siga en su estado CREADA


      $solicitud->codProyecto = $request->ComboBoxProyecto;
      //$solicitud->codigoCedepas = $request->codSolicitud; /* POR QUE ESTO ESTA AQUI XD? */


      $solicitud->totalSolicitado = $request->total;


      $solicitud->girarAOrdenDe = $request->girarAOrden;
      $solicitud->numeroCuentaBanco = $request->nroCuenta;
      $solicitud->codigoContrapartida = $request->codigoContrapartida;
      $solicitud->codBanco = $request->ComboBoxBanco;
      $solicitud->justificacion = $request->justificacion;
      //$solicitud->codEstadoSolicitud = '1';

      $solicitud->codMoneda = $request->ComboBoxMoneda;

      $vec[] = '';
      $solicitud->save();

      $solicitud->registrarOperacion(
        TipoOperacion::getCodTipoOperacion('SOL', 'Editar'),
        null,
        Puesto::getCodPuesto_Empleado()
      ); //siempre editará el empleado


      if ($request->cantElementos == 0)
        throw new Exception("No se ingresó ningún item.", 1);


      $i = 0;
      $cantidadFilas = $request->cantElementos;

      //borramos todas las solicitudes puesto que las ingresaremos desde 0 again
      DetalleSolicitudFondos::where('codSolicitud', '=', $id)->delete();


      while ($i < $cantidadFilas) {
        $detalle = new DetalleSolicitudFondos();
        $detalle->codSolicitud =          $id;
        $detalle->nroItem =               $i + 1;
        $detalle->concepto =              $request->get('colConcepto' . $i);
        $detalle->importe =               $request->get('colImporte' . $i);
        $detalle->codigoPresupuestal  =  $request->get('colCodigoPresupuestal' . $i);

        $vec[$i] = $detalle;
        $detalle->save();

        $i = $i + 1;
      }




      //SOLO BORRAMOS TODO E INSERTAMOS NUEVOS ARCHIVOS SI ES QUE SE INGRESÓ NUEVOS
      if (!is_null($request->nombresArchivos) && $request->nombresArchivos != "[]") { //SI NO ES NULO Y No está vacio

        Debug::mensajeSimple("o yara/" . $request->tipoIngresoArchivos);
        if ($request->tipoIngresoArchivos == "1") { //AÑADIR

        } else { //SOBRESRIBIR
          $solicitud->borrarArchivos();  //A
        }

        $cantidadArchivosYaExistentes = $solicitud->getCantidadArchivos();

        //$nombresArchivos = explode(', ',$request->nombresArchivos);
        $nombresArchivos = json_decode($request->nombresArchivos); //ahora llega un vector en JSON ["archivo1.pdf","archivo2.pdf"]

        $j = 0; //A

        foreach ($request->file('filenames') as $archivo) {

          $nombreArchivoGuardado = $solicitud->getNombreGuardadoNuevoArchivo($cantidadArchivosYaExistentes + $j + 1);
          Debug::mensajeSimple('el nombre de guardado de la imagen es:' . $nombreArchivoGuardado);


          $archivoRepo = new ArchivoSolicitud();
          $archivoRepo->codSolicitud = $solicitud->codSolicitud;
          $archivoRepo->nombreDeGuardado = $nombreArchivoGuardado;
          $archivoRepo->nombreAparente = $nombresArchivos[$j];
          $archivoRepo->save();

          $fileget = \File::get($archivo);

          Storage::disk('solicitudes')
            ->put($nombreArchivoGuardado, $fileget);
          $j++;
        }
      }

      DB::commit();
      return redirect()->route('SolicitudFondos.Empleado.Listar')
        ->with('datos', 'Registro ' . $solicitud->codigoCedepas . ' actualizado.');
    } catch (\Throwable $th) {
      Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : UPDATE', $th);

      DB::rollback();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('SolicitudFondos.Empleado.Listar')
        ->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }


  public function cancelar($id)
  { //para cancelar una solicitud desde el index

    try {
      DB::beginTransaction();
      $solicitud = SolicitudFondos::findOrFail($id);

      if (!$solicitud->listaParaCancelar())
        return redirect()->route('solicitudFondos.ListarSolicitudes')
          ->with('datos', 'ERROR: La solicitud no puede cancelada puesto que ya fue ABONADA.');



      $solicitud->codEstadoSolicitud = SolicitudFondos::getCodEstado('Cancelada');
      $solicitud->save();

      $solicitud->registrarOperacion(
        TipoOperacion::getCodTipoOperacion('SOL', 'Cancelar'),
        null,
        Puesto::getCodPuesto_Empleado()
      ); //aqui depende del que lo esté rechazando


      DB::commit();

      return redirect()->route('SolicitudFondos.Empleado.Listar')
        ->with('datos', 'Se ha cancelado la solicitud ' . $solicitud->codigoCedepas);
    } catch (\Throwable $th) {
      Debug::mensajeError('SOLICITUD FONDOS CONTROLLER DELETE', $th);
      DB::rollback();
      $codErrorHistorial = ErrorHistorial::registrarError($th, app('request')->route()->getAction(), $id);
      return redirect()->route('SolicitudFondos.Empleado.Listar')
        ->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }


  public function reportes()
  {

    $empleado = Empleado::getEmpleadoLogeado();



    $listaSolicitudesFondos = SolicitudFondos::where('codEmpleadoSolicitante', '=', $empleado->codEmpleado)
      ->orderBy('codEstadoSolicitud', 'ASC')
      ->paginate();

    $buscarpor = "";

    $listaBancos = Banco::All();
    $listaProyectos = Proyecto::getProyectosActivos();
    $listaSedes = Sede::All();
    $listaEmpleados = Empleado::getListaEmpleadosPorApellido();
    $listaEstados = EstadoSolicitudFondos::All();

    return view('RendicionGastos.Administracion.Reportes.ReportesIndex', compact(
      'buscarpor',
      'listaSolicitudesFondos',
      'listaBancos',
      'listaSedes',
      'listaProyectos',
      'listaEmpleados',
      'listaEstados'
    ));
  }


  public function descargarPDF($codSolicitud)
  {
    $solicitud = SolicitudFondos::findOrFail($codSolicitud);
    return $solicitud->getPDF(true);
  }

  public function verPDF($codSolicitud)
  {
    $solicitud = SolicitudFondos::findOrFail($codSolicitud);
    return $solicitud->getPDF(false);
  }

  ///////////////////////////////////////////////////////////////////
  /*
    public function OCdescargarPDF(){
        $pdf = \PDF::loadview('ordenCompraPDF')->setPaper('a4', 'portrait');
        return $pdf->download('Solicitud de Fondos.Pdf');
    }

    public function OCverPDF(){
        $pdf = \PDF::loadview('ordenCompraPDF')->setPaper('a4', 'portrait');
        return $pdf->stream('Solicitud de Fondos.Pdf');
    }
    */
  ///////////////////////////////////////////////////////////////////


  function eliminarArchivo($codArchivoSol)
  {

    try {
      $archivo = ArchivoSolicitud::findOrFail($codArchivoSol);
    } catch (\Throwable $th) {
      return redirect()->route('SolicitudFondos.Empleado.Listar')
        ->with('datos', 'ERROR: El archivo que desea eliminar no existe o ya ha sido eliminado, vuelva a la página de editar Solicitud.');
    }


    try {
      db::beginTransaction();

      $nombreArchivEliminado = $archivo->nombreAparente;
      $soli = SolicitudFondos::findOrFail($archivo->codSolicitud);

      if ($soli->codEmpleadoSolicitante != Empleado::getEmpleadoLogeado()->codEmpleado)
        throw new Exception("Solo el dueño de la Solicitud puede eliminar sus archivos.", 1);


      $archivo->eliminarArchivo();
      DB::commit();

      return redirect()->route('SolicitudFondos.Empleado.Edit', $soli->codSolicitud)->with('datos', 'Archivo "' . $nombreArchivEliminado . '" eliminado exitosamente.');
    } catch (\Throwable $th) {
      Debug::mensajeError(' SOLCIITUD FONDOS CONTROLLER Eliminar archivo', $th);
      DB::rollback();
      $codErrorHistorial = ErrorHistorial::registrarError($th, app('request')->route()->getAction(), $codArchivoSol);
      return redirect()->route('SolicitudFondos.Empleado.Edit', $soli->codSolicitud)
        ->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }

  //se le pasa el codigo del archivo
  function descargarArchivo($codArchivoSol)
  {
    $archivo = ArchivoSolicitud::findOrFail($codArchivoSol);
    return Storage::download("/solicitudes/" . $archivo->nombreDeGuardado, $archivo->nombreAparente);
  }



  /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
  /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
  /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
  /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
  /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
  /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
  /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
  /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
  /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
  /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
  /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
  /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
  /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
  /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
  /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
  /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
  /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
  /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
  /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */


  function API_listarSOFDeEmpleado($codEmpleado)
  {
    $listaSolicitudesFondos = SolicitudFondos::where('codEmpleadoSolicitante', '=', $codEmpleado)
      ->orderBy('fechaHoraEmision', 'DESC')->get();

    $listaSolicitudesFondos = SolicitudFondos::ordenarParaEmpleado($listaSolicitudesFondos);

    $listaPreparada = [];
    foreach ($listaSolicitudesFondos as $sof) {
      $listaPreparada[] = $sof->getVectorParaAPI();
    }

    return $listaPreparada;
    return Debug::contenidoEnJS(json_encode($listaPreparada));
  }

  function API_getSOF($codSolicitud)
  {
    $solicitud = SolicitudFondos::findOrFail($codSolicitud);
    $listaDetalles = $solicitud->getDetalles();

    $solPreparada = $solicitud->getVectorParaAPI();
    $solPreparada['listaDetalles'] = json_encode($listaDetalles);

    return json_encode($solPreparada);
  }
}
