<?php

namespace App\Http\Controllers;
#region Uses
use App\ActividadResultado;
use App\ArchivoProyecto;
use App\ArchivoReposicion;
use App\Configuracion;
use App\Http\Controllers\Controller;
use App\Proyecto;
use Illuminate\Http\Request;
use App\Empleado;
use App\ProyectoContador;
use App\Puesto;
use Illuminate\Support\Facades\DB;
use NumberFormatter;
use App\LugarEjecucion;
use App\Sede;
use App\Debug;
use App\Departamento;
use App\Provincia;
use App\Distrito;
use App\EmpleadoPuesto;
use App\PoblacionBeneficiaria;
use App\EntidadFinanciera;
use App\ErrorHistorial;
use App\EstadoProyecto;
use App\Fecha;
use App\IndicadorActividad;
use App\IndicadorObjEspecifico;
use App\ObjetivoEstrategico;
use App\PlanEstrategicoInstitucional;
use App\RelacionProyectoObj;
use App\ObjetivoEspecifico;
use App\ResultadoEsperado;
use App\IndicadorResultado;
use App\MedioVerificacionMeta;
use App\MedioVerificacionResultado;
use App\MetaEjecutada;
use Illuminate\Support\Facades\Storage;
use App\Moneda;
use App\OperacionDocumento;
use App\PersonaJuridicaPoblacion;
use App\PersonaNaturalPoblacion;
use App\PersonaPoblacion;
use App\RelacionProyectoObjMilenio;
use App\RendicionGastos;
use App\ReposicionGastos;
use App\RequerimientoBS;
use App\RespuestaAPI;
use App\SolicitudFondos;
use App\TipoArchivoProyecto;
use App\TipoDocumento;
use App\TipoFinanciamiento;
use DateTime;
use Exception;
use Illuminate\Http\Response;
//require __DIR__ . "/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

#endregion Uses
class ProyectoController extends Controller
{



  function RedirigirAProyectoSegunActor($codProyecto)
  {
    $datos = session('datos');

    $empleado = Empleado::getEmpleadoLogeado();

    if ($empleado->esGerente())
      return redirect()->route('GestionProyectos.Gerente.Ver', $codProyecto)->with('datos', $datos);

    if ($empleado->esUGE())
      return redirect()->route('GestiónProyectos.editar', $codProyecto)->with('datos', $datos);

    return redirect()->route('user.home');
  }

  function RedirigirAVistaMetas($codProyecto)
  {
    $datos = session('datos');
    $empleado = Empleado::getEmpleadoLogeado();

    if ($empleado->esGerente())
      return redirect()->route('GestionProyectos.Gerente.RegistrarMetasEjecutadas', $codProyecto)->with('datos', $datos);

    if ($empleado->esUGE())
      return redirect()->route('GestionProyectos.UGE.RegistrarMetasEjecutadas', $codProyecto)->with('datos', $datos);

    return redirect()->route('user.home');
  }

  #region CRUDPROYECTOS


  //VISTA INDEX de proyectos PARA EL ADMINISTRADOR
  function index()
  {
    $listaProyectos = Proyecto::All();
    $listaGerentes = Empleado::getListaGerentesActivos();
    $listaContadores = Empleado::getListaContadoresActivos();
    $listaEstados = EstadoProyecto::All();

    return view(
      'Proyectos.AdminSistema.ListarProyectos',
      compact('listaProyectos', 'listaGerentes', 'listaContadores', 'listaEstados')
    );
  }






  function crear()
  {

    $listaDepartamentos = Departamento::All();
    $listaFinancieras = EntidadFinanciera::All();
    $listaPEIs = PlanEstrategicoInstitucional::All();
    $listaMonedas = Moneda::All();
    $listaSedes = Sede::All();
    $listaTipoFinanciamiento = TipoFinanciamiento::All();
    $listaGerentes = Empleado::getListaGerentesActivos();
    $listaProyectos = Proyecto::All();

    return view('Proyectos.Create', compact(
      'listaDepartamentos',
      'listaFinancieras',
      'listaPEIs',
      'listaMonedas',
      'listaSedes',
      'listaTipoFinanciamiento',
      'listaGerentes',
      'listaProyectos'


    ));
  }

  function editar($codProyecto)
  {
    $proyecto = Proyecto::findOrFail($codProyecto);
    $lugaresEjecucion = LugarEjecucion::where('codProyecto', '=', $codProyecto)->get();
    $poblacionesBeneficiarias = PoblacionBeneficiaria::where('codProyecto', '=', $codProyecto)->get();
    $listaDepartamentos = Departamento::All();
    $listaFinancieras = EntidadFinanciera::All();
    $listaPorcentajes = $proyecto->getPorcentajesObjEstrategicos();
    $listaPEIs = PlanEstrategicoInstitucional::All();
    $listaObjetivosEspecificos = ObjetivoEspecifico::where('codProyecto', '=', $codProyecto)->get();
    $listaResultadosEsperados = ResultadoEsperado::where('codProyecto', '=', $codProyecto)->get();
    $listaMonedas = Moneda::All();
    $listaSedes = Sede::All();
    $listaTipoFinanciamiento = TipoFinanciamiento::All();
    $listaActividades = $proyecto->getListaActividades();
    $listaTiposArchivos = TipoArchivoProyecto::All();
    $relacionesObjMilenio = RelacionProyectoObjMilenio::where('codProyecto', '=', $codProyecto)->get();


    $listaIndicadoresResultados = $proyecto->getIndicadoresResultados();

    return view('Proyectos.EditarProyecto', compact(
      'listaSedes',
      'proyecto',
      'lugaresEjecucion',
      'listaDepartamentos',
      'poblacionesBeneficiarias',
      'listaFinancieras',
      'listaPorcentajes',
      'listaPEIs',
      'listaObjetivosEspecificos',
      'listaResultadosEsperados',
      'listaMonedas',
      'listaTipoFinanciamiento',
      'listaActividades',
      'listaIndicadoresResultados',
      'listaTiposArchivos',
      'relacionesObjMilenio'
    ));
  }


  function store(Request $request)
  {
    try {
      DB::beginTransaction();

      //validamos si ya hay otro proyecto activo con ese cod presupuestal
      $proyectosMismoCodPresup = Proyecto::where('codigoPresupuestal', '=', $request->codigoPresupuestal)
        ->where('codEstadoProyecto', '!=', Proyecto::getCodEstado('Finalizado'))
        ->get();
      if (count($proyectosMismoCodPresup) != 0) {

        return redirect()->route('GestiónProyectos.AdminSistema.Listar')
          ->with('datos', 'ERROR: Ya existe un proyecto con el código presupuestal ingresado [' . $request->codigoPresupuestal . '].');
      }


      $proyecto = new Proyecto();
      $proyecto->codEstadoProyecto = Proyecto::getCodEstado('En Registro');

      $fechaInicio = Fecha::formatoParaSQL($request->fechaInicio);
      $proyecto->fechaInicio = $fechaInicio;
      $fechaFinalizacion = Fecha::formatoParaSQL($request->fechaFinalizacion);
      $proyecto->fechaFinalizacion = $fechaFinalizacion;

      $proyecto->nombre = $request->nombre;
      $proyecto->codPEI = $request->codPEI;
      $proyecto->codigoPresupuestal = $request->codigoPresupuestal;
      $proyecto->nombreLargo = $request->nombreLargo;
      $proyecto->codEntidadFinanciera = $request->codEntidadFinanciera;
      $proyecto->codEmpleadoDirector = $request->codGerente;

      $proyecto->codMoneda = $request->codMoneda;

      $proyecto->importeContrapartidaCedepas = $request->importeContrapartidaCedepas;
      $proyecto->importeContrapartidaPoblacionBeneficiaria = $request->importeContrapartidaPoblacionBeneficiaria;
      $proyecto->importeContrapartidaOtros = $request->importeContrapartidaOtros;
      $proyecto->importeFinanciamiento = $request->importeFinanciamiento;


      $proyecto->importePresupuestoTotal =
        $proyecto->importeContrapartidaCedepas +
        $proyecto->importeContrapartidaPoblacionBeneficiaria +
        $proyecto->importeContrapartidaOtros +
        $proyecto->importeFinanciamiento;



      $proyecto->codTipoFinanciamiento = $request->codTipoFinanciamiento;
      $proyecto->codSedePrincipal = $request->codSede;
      $proyecto->objetivoGeneral = $request->objetivoGeneral;


      $proyecto->save();
      $proyecto->inicializarObjetivosMilenio(); //inserta en cada objetivo del milenio

      DB::commit();

      return redirect()->route('GestiónProyectos.AdminSistema.Listar')->with('datos', 'Proyecto creado exitosamente, ya puede asignar contadores y registrar información detallada del proyecto en el botón Editar.');
    } catch (\Throwable $th) {

      Debug::mensajeError('PROYECTO CONTROLLER STORE', $th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('GestiónProyectos.AdminSistema.Listar')->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }

  function update(Request $request)
  {
    //return $request;
    try {
      DB::beginTransaction();

      $proyecto = Proyecto::findOrFail($request->codProyecto);
      $proyecto->nombre = $request->nombre;

      $fechaInicio = Fecha::formatoParaSQL($request->fechaInicio);
      $proyecto->fechaInicio = $fechaInicio;
      $fechaFinalizacion = Fecha::formatoParaSQL($request->fechaFinalizacion);
      $proyecto->fechaFinalizacion = $fechaFinalizacion;

      $proyecto->codigoPresupuestal = $request->codigoPresupuestal;
      $proyecto->nombreLargo = $request->nombreLargo;
      $proyecto->codEntidadFinanciera = $request->codEntidadFinanciera;

      $proyecto->codMoneda = $request->codMoneda;

      $proyecto->importeContrapartidaCedepas = $request->importeContrapartidaCedepas;
      $proyecto->importeContrapartidaPoblacionBeneficiaria = $request->importeContrapartidaPoblacionBeneficiaria;
      $proyecto->importeContrapartidaOtros = $request->importeContrapartidaOtros;
      $proyecto->importeFinanciamiento = $request->importeFinanciamiento;


      $proyecto->importePresupuestoTotal =
        $proyecto->importeContrapartidaCedepas +
        $proyecto->importeContrapartidaPoblacionBeneficiaria +
        $proyecto->importeContrapartidaOtros +
        $proyecto->importeFinanciamiento;



      $proyecto->codTipoFinanciamiento = $request->codTipoFinanciamiento;
      $proyecto->codSedePrincipal = $request->codSede;
      $proyecto->objetivoGeneral = $request->objetivoGeneral;


      $proyecto->save();

      DB::commit();

      return redirect()->route('GestiónProyectos.editar', $proyecto->codProyecto)->with('datos', 'Proyecto actualizado exitosamente.');
    } catch (\Throwable $th) {

      Debug::mensajeError('PROYECTO CONTROLLER update', $th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('GestiónProyectos.editar', $proyecto->codProyecto)->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }




  /* Funcion ejecutada desde JS con un get */
  /* La cadena tiene el formato 15*2
    Donde 15 esel codigo del proyecto
    donde 2 es el codigo del nuevo estado
    */
  function actualizarEstado($cadena)
  {
    try {
      db::beginTransaction();
      $vector = explode('*', $cadena);
      $codProyecto = $vector[0];
      $codNuevoEstado = $vector[1];

      $proyecto = Proyecto::findOrFail($codProyecto);
      $proyecto->codEstadoProyecto = $codNuevoEstado;
      $proyecto->save();

      db::commit();

      return TRUE;
    } catch (\Throwable $th) {

      Debug::mensajeError('PROYECTO CONTROLLER actualizarEstado', $th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError($th, app('request')->route()->getAction(), $cadena);
      return FALSE;
    }
  }



  #endregion CRUDPROYECTOS

  /*

      Obtiene el json con la información que se renderizará en el dashboard
      Request variables

        codsProyectos

      JSON Retornado
        SOL
          cant_aprobados_dia
          cant_aprobados_semana
          cant_aprobados_mes


          cant_emitidos_dia
          cant_emitidos_semana
          cant_emitidos_mes

          cant_emitidos_historico: [{fecha:"2022-11-25",cantidad_docs:0,monto_total:5},{...}]
        REN
          cant_aprobados_dia
          cant_aprobados_semana
          cant_aprobados_mes


          cant_emitidos_dia
          cant_emitidos_semana
          cant_emitidos_mes

          cant_emitidos_historico: [{fecha:"2022-11-25",cantidad_docs:0,monto_total:5},{...}]
        REP
          cant_aprobados_dia
          cant_aprobados_semana
          cant_aprobados_mes


          cant_emitidos_dia
          cant_emitidos_semana
          cant_emitidos_mes

          cant_emitidos_historico: [{fecha:"2022-11-25",cantidad_docs:2,monto_total:5},{...}]
        REQ
          cant_aprobados_dia
          cant_aprobados_semana
          cant_aprobados_mes


          cant_emitidos_dia
          cant_emitidos_semana
          cant_emitidos_mes

          cant_emitidos_historico: [{fecha:"2022-11-25",cantidad_docs:6},{...}]
        RESUMEN
          cant_docs_aprobados_dia
          cant_docs_aprobados_semana
          cant_docs_aprobados_mes

          cant_docs_emitidos_dia
          cant_docs_emitidos_semana
          cant_docs_emitidos_mes

          cant_docs_historico: [{fecha:"2022-11-25",cantidad_emitidos:5},{...}]

    */
  function getDashboardInfo(Request $request)
  {

    $empLogeado = Empleado::getEmpleadoLogeado();

    $codsProyectos = explode(",", $request->codsProyectos);
    if (!$request->codsProyectos) { //if comes null,  we set the gerente and observador proyects
      $codsProyectosDelObservadorYGerente = [];

      foreach ($empLogeado->getListaProyectosObservador() as $proy) {
        $codsProyectosDelObservadorYGerente[] = $proy->codProyecto;
      }
      foreach ($empLogeado->getListaProyectos() as $proy) {
        $codsProyectosDelObservadorYGerente[] = $proy->codProyecto;
      }


      $codsProyectos = $codsProyectosDelObservadorYGerente;
    }


    $SOL = SolicitudFondos::getDashboardInfo($codsProyectos);
    $REN = RendicionGastos::getDashboardInfo($codsProyectos);
    $REP = ReposicionGastos::getDashboardInfo($codsProyectos);
    $REQ = RequerimientoBS::getDashboardInfo($codsProyectos);

    $cant_historico = [];
    $response = compact('SOL', 'REN', 'REP', 'REQ');
    foreach ($SOL['cant_emitidos_historico'] as $i => $dia) {
      $fecha = $dia->fecha;

      $cant_historico[] = [
        'fecha' => $fecha,
        'cantidad_emitidos' =>
        $SOL['cant_emitidos_historico'][$i]->cantidad_docs +
          $REN['cant_emitidos_historico'][$i]->cantidad_docs +
          $REP['cant_emitidos_historico'][$i]->cantidad_docs +
          $REQ['cant_emitidos_historico'][$i]->cantidad_docs,


      ];
    }


    $response['RESUMEN'] = [
      'cant_docs_emitidos_dia' => $SOL['cant_emitidos_dia'] + $REN['cant_emitidos_dia'] + $REP['cant_emitidos_dia'] + $REQ['cant_emitidos_dia'],
      'cant_docs_emitidos_semana' => $SOL['cant_emitidos_semana'] + $REN['cant_emitidos_semana'] + $REP['cant_emitidos_semana'] + $REQ['cant_emitidos_semana'],
      'cant_docs_emitidos_mes' => $SOL['cant_emitidos_mes'] + $REN['cant_emitidos_mes'] + $REP['cant_emitidos_mes'] + $REQ['cant_emitidos_mes'],

      'cant_docs_aprobados_dia' => $SOL['cant_aprobados_dia'] + $REN['cant_aprobados_dia'] + $REP['cant_aprobados_dia'] + $REQ['cant_aprobados_dia'],
      'cant_docs_aprobados_semana' => $SOL['cant_aprobados_semana'] + $REN['cant_aprobados_semana'] + $REP['cant_aprobados_semana'] + $REQ['cant_aprobados_semana'],
      'cant_docs_aprobados_mes' => $SOL['cant_aprobados_mes'] + $REN['cant_aprobados_mes'] + $REP['cant_aprobados_mes'] + $REQ['cant_aprobados_mes'],


      'cant_docs_historico' => $cant_historico,
    ];

    return $response;
  }

  function VerDashboard()
  {

    $empLogeado = Empleado::getEmpleadoLogeado();
    if (!$empLogeado->esGerente() && !$empLogeado->esObservador()) {
      return redirect()->route('error')->with('datos', "Para acceder al dashboard necesita ser gerente o supervisor");
    }

    $codsProyectosDelObservadorYGerente = [];

    foreach ($empLogeado->getListaProyectosObservador() as $proy) {
      $codsProyectosDelObservadorYGerente[] = $proy->codProyecto;
    }
    foreach ($empLogeado->getListaProyectos() as $proy) {
      $codsProyectosDelObservadorYGerente[] = $proy->codProyecto;
    }

    if (count($codsProyectosDelObservadorYGerente) == 0)
      return redirect()->route('error')->with('datos', "Para acceder al dashboard necesita tener control sobre algun proyecto, sea como gerente o supervisor");

    $listaProyectos = Proyecto::whereIn('codProyecto', $codsProyectosDelObservadorYGerente)->orderBy('codigoPresupuestal', 'ASC')->get();
    $listaProyectos = Proyecto::añadirNombreYcod($listaProyectos);

    $listaTipoDocumentos = TipoDocumento::where('abreviacion', '!=', 'RCITE')->get();

    return view('Proyectos.VerDashboard', compact('listaProyectos', 'listaTipoDocumentos'));
  }



  ///////

  /*  funcion servicio se consume desde JS */
  function getCodigoPresupuestal($id)
  {
    error_log('[' . Proyecto::findOrFail($id)->codigoPresupuestal . ']');
    return Proyecto::findOrFail($id)->codigoPresupuestal;
  }






  #region CRUD Contadores de un proyecto
  /* Despliega vista para ver los contadores de un proyecto */
  function listarContadores($id)
  {


    $proyecto = Proyecto::findOrFail($id);
    $contadoresSeleccionados = $proyecto->getContadores();

    $listaRelaciones = ProyectoContador::where('codProyecto', '=', $id)->get();

    $codsContadoresDelProyecto = [];
    foreach ($contadoresSeleccionados as $itemcontador) {
      $codsContadoresDelProyecto[] = $itemcontador->codEmpleado;
    }

    $listaContadoresExistentes = Empleado::getListaContadoresActivos();

    $contadoresFaltantes = [];
    foreach ($listaContadoresExistentes as $contador) {
      if (!in_array($contador->codEmpleado, $codsContadoresDelProyecto)) {
        $contadoresFaltantes[] = $contador;
      }
    }


    return view('Proyectos.ContadoresProyecto', compact('proyecto', 'contadoresFaltantes', 'contadoresSeleccionados', 'listaRelaciones'));
  }

  function agregarContador(Request $request)
  {


    $detalle = new ProyectoContador();
    $detalle->codProyecto = $request->codProyecto;
    $detalle->codEmpleadoContador = $request->codEmpleadoConta;
    $detalle->save();

    return redirect()->route('GestiónProyectos.ListarContadores', $request->codProyecto);
  }

  function eliminarContador($codProyectoContador)
  {

    try {
      db::beginTransaction();
      $proyectoContador = ProyectoContador::where('codProyectoContador', '=', $codProyectoContador)->first();

      $nombre = $proyectoContador->getContador()->getNombreCompleto();
      $proyecto = $proyectoContador->getProyecto()->nombre;
      /* REVISAR  */

      $proyectoContador->delete();

      db::commit();
      return redirect()->route('GestiónProyectos.ListarContadores', $proyectoContador->codProyecto)
        ->with('datos', "Contador $nombre eliminado del proyecto $proyecto.");
    } catch (\Throwable $th) {
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError($th, app('request')->route()->getAction(), $codProyectoContador);
      return redirect()->route('GestiónProyectos.ListarContadores', $proyectoContador->codProyecto)
        ->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }


  function actualizarProyectosYGerentesContadores($id)
  {
    try {
      $arr = explode('*', $id);
      DB::beginTransaction();
      $proyecto = Proyecto::findOrFail($arr[0]);
      $gerente = Empleado::findOrFail($arr[1]);
      if ($arr[2] == 1) {
        $proyecto->codEmpleadoDirector = $gerente->codEmpleado;
      } else {
        $proyecto->codEmpleadoConta = $gerente->codEmpleado;
      }
      $proyecto->save();
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError($th, app('request')->route()->getAction(), $id);
      return false;
    }
  }


  /**PARA RELLENAR PROYECTO_CONTADOR */
  public function RellenarProyectoContador()
  {


    try {
      db::beginTransaction();
      //borramos todos los actuales
      $listaActual = ProyectoContador::where('codProyectoContador', '>', '0')->delete();


      $contadores = Empleado::getListaContadoresActivos();
      $proyectos = Proyecto::getProyectosActivos();

      foreach ($proyectos as $itemproyecto) {
        foreach ($contadores as $itemcontador) {
          $detalle = new ProyectoContador();
          $detalle->codEmpleadoContador = $itemcontador->codEmpleado;
          $detalle->codProyecto = $itemproyecto->codProyecto;
          $detalle->save();
        }
      }

      db::commit();

      return redirect()->route('GestiónProyectos.AdminSistema.Listar')
        ->with('datos', 'Se han asignado todos los contadores registrados a todos los proyectos registrados.');
    } catch (\Throwable $th) {
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError($th, app('request')->route()->getAction(), "");
      return redirect()->route('GestiónProyectos.AdminSistema.Listar')
        ->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }




  #endregion









  public function listarPersonasRegistradas()
  {
    $personasNaturales = PersonaNaturalPoblacion::All();
    $personasJuridicas = PersonaJuridicaPoblacion::All();

    return view('Proyectos.AdminSistema.ListarPersonas', compact('personasNaturales', 'personasJuridicas'));
  }
  #endregion








  public function listarProvinciasDeDepartamento($codDepartamento)
  {
    return Provincia::where('codDepartamento', '=', $codDepartamento)->get();
  }
  public function listarDistritosDeProvincia($codProvincia)
  {
    return Distrito::where('codProvincia', '=', $codProvincia)->get();
  }


  public function verMetas()
  {
    return view('Proyectos.Gerente.verMetas');
  }

  public function probandoMeses()
  {
    $meta = MetaEjecutada::findOrFail(4);
    return json_encode($meta) . "  ¿?  " . $meta->sePuedeEditar();
  }

  public function registrarMetasEjecutadas($codProyecto)
  {
    $proyecto = Proyecto::findOrFail($codProyecto);
    return view('Proyectos.RegistroEjecucionMetas', compact('proyecto'));
  }



  public function exportarMetasEjecutadas($codProyecto)
  {
    $proyecto = Proyecto::findOrFail($codProyecto);

    return view('Proyectos.ExportarExcelEjecucionMetas', compact('proyecto'));
  }




  #endregion CRUD archivos del proyecto


}
