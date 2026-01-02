<?php

namespace App\Http\Controllers;

use App\Utils\Configuracion;
use App\ArchivoReqAdmin;
use App\ArchivoReqEmp;
use App\Http\Controllers\Controller;
use App\RequerimientoBS;
use App\Empleado;
use App\Proyecto;
use Illuminate\Http\Request;
use App\DetalleSolicitudFondos;
use App\Banco;
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
use App\Utils\Debug;
use App\DetalleRequerimientoBS;
use App\ErrorHistorial;
use App\EstadoRequerimientoBS;

use App\Numeracion;
use App\ProyectoContador;
use App\ProyectoObservador;
use App\Puesto;
use App\TipoOperacion;
use App\UI\UIFiltros;
use App\UnidadMedida;
use DateTime;

class RequerimientoBSController extends Controller
{


  const PAGINATION = 25;
  public function listarOfEmpleado(Request $request)
  {

    $empleado = Empleado::getEmpleadoLogeado();

    $listaRequerimientos = RequerimientoBS::where('codEmpleadoSolicitante', $empleado->getId());

    $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaRequerimientos, $request->getQueryString());

    $listaRequerimientos = UIFiltros::buildQuery($listaRequerimientos, $request->getQueryString());
    $filtros_usados = UIFiltros::getQueryValues($listaRequerimientos, $request->getQueryString());


    $listaRequerimientos = RequerimientoBS::ordenarParaEmpleado($listaRequerimientos)->paginate($this::PAGINATION);


    $proyectos = Proyecto::getProyectosActivos();


    return view('RequerimientoBS.Empleado.ListarRequerimientos', compact('listaRequerimientos', 'proyectos', 'filtros_usados_paginacion', 'filtros_usados'));
  }


  //FUNCION CUELLO DE BOTELLA
  public function listarRequerimientos()
  {

    $empleado = Empleado::getEmpleadoLogeado();
    $msj = session('datos');
    $datos = '';
    if ($msj != '')
      $datos = 'datos';

    if ($empleado->esGerente()) {
      return redirect()->route('RequerimientoBS.Gerente.Listar')->with($datos, $msj);
    }
    if ($empleado->esJefeAdmin()) {
      return redirect()->route('RequerimientoBS.Administrador.Listar')->with($datos, $msj);
    }
    if ($empleado->esContador()) {
      return redirect()->route('RequerimientoBS.Contador.Listar')->with($datos, $msj);
    }
    return redirect()->route('RequerimientoBS.Empleado.Listar')->with($datos, $msj);
  }

  //para consumirlo en js
  public function listarDetalles($idRequerimiento)
  {
    $vector = [];
    $listaDetalles = DetalleRequerimientoBS::where('codRequerimiento', '=', $idRequerimiento)->get();
    for ($i = 0; $i < count($listaDetalles); $i++) {

      $itemDet = $listaDetalles[$i];
      $itemDet['codUnidadMedida'] = UnidadMedida::findOrFail($itemDet->codUnidadMedida)->nombre; //tengo que pasarlo aqui pq en el javascript no hay manera de calcularlo, de todas maneras no lo usaré como Modelo (objeto)
      array_push($vector, $itemDet);
    }
    return $vector;
  }



  public function crear()
  {
    $listaUnidadMedida = UnidadMedida::All();
    $proyectos = Proyecto::getProyectosActivos();
    $empleadoLogeado = Empleado::getEmpleadoLogeado();
    $objNumeracion = Numeracion::getNumeracionREQ();

    return view(
      'RequerimientoBS.Empleado.CrearRequerimientoBS',
      compact('empleadoLogeado', 'listaUnidadMedida', 'proyectos', 'objNumeracion')
    );
  }
  public function store(Request $request)
  {
    try {
      DB::beginTransaction();
      $requerimiento = new RequerimientoBS();
      $requerimiento->codEstadoRequerimiento = 1;
      $requerimiento->codEmpleadoSolicitante = Empleado::getEmpleadoLogeado()->codEmpleado;

      $cuenta = $request->cuentaBancariaProveedor;
      if (is_null($cuenta))
        $cuenta = "No ingresada";

      $requerimiento->cuentaBancariaProveedor = $cuenta;
      $requerimiento->codProyecto = $request->codProyecto;
      $requerimiento->codigoContrapartida = $request->codigoContrapartida;

      $requerimiento->fechaHoraEmision = Carbon::now();
      $requerimiento->justificacion = $request->justificacion; //cambiar a justificacion (se tiene que cambiar en la vista xdxdxd)
      $requerimiento->fechaHoraRevision = null;
      $requerimiento->fechaHoraAtendido = null; //sisi xd
      $requerimiento->fechaHoraConta = null;
      $requerimiento->observacion = null;

      $requerimiento->codigoCedepas = RequerimientoBS::calcularCodigoCedepas(Numeracion::getNumeracionREQ());
      Numeracion::aumentarNumeracionREQ();

      $requerimiento->save();

      $requerimiento->registrarOperacion(
        TipoOperacion::getCodTipoOperacion('REQ', 'Crear'),
        null,
        Puesto::getCodPuesto_Empleado()
      ); //siempre creará el empleado


      //creacion de detalles
      $vec[] = '';
      $codREQRecienInsertado = $requerimiento->codRequerimiento;

      if ($request->cantElementos == 0)
        throw new Exception("No se ingresó ningún item.", 1);


      $i = 0;
      $cantidadFilas = $request->cantElementos;
      while ($i < $cantidadFilas) {
        $detalle = new DetalleRequerimientoBS();
        $detalle->codRequerimiento = $requerimiento->codRequerimiento; //ultimo insertad
        $detalle->codUnidadMedida = UnidadMedida::where('nombre', '=', $request->get('colTipo' . $i))->get()[0]->codUnidadMedida;

        $detalle->descripcion =              $request->get('colDescripcion' . $i);
        $detalle->cantidad =               $request->get('colCantidad' . $i);
        $detalle->codigoPresupuestal  =  $request->get('colCodigoPresupuestal' . $i);

        $detalle->save();
        $i = $i + 1;
      }

      $requerimiento->save();


      if (!is_null($request->nombresArchivos) && $request->nombresArchivos != "[]") { //SI NO ES NULO Y No está vacio

        //$nombresArchivos = explode(', ',$request->nombresArchivos);
        $nombresArchivos = json_decode($request->nombresArchivos); //ahora llega un vector en JSON ["archivo1.pdf","archivo2.pdf"]

        $j = 0;

        foreach ($request->file('filenames') as $archivo) {



          //               CDP-   000002                           -   5   .  jpg

          $nombreArchivoGuardado = $requerimiento->getNombreGuardadoNuevoArchivoEmp($j + 1);
          Debug::mensajeSimple('el nombre de la imagen es:' . $nombreArchivoGuardado);

          $archivoReqEmp = new ArchivoReqEmp();
          $archivoReqEmp->codRequerimiento = $requerimiento->codRequerimiento;
          $archivoReqEmp->nombreDeGuardado = $nombreArchivoGuardado;
          $archivoReqEmp->nombreAparente = $nombresArchivos[$j];
          $archivoReqEmp->save();

          $fileget = \File::get($archivo);

          Storage::disk('requerimientos')->put($nombreArchivoGuardado, $fileget);
          $j++;
        }

        $requerimiento->cantArchivosEmp = $j;
        $requerimiento->nombresArchivosEmp = "";
      }
      /*
            else{
                throw new Exception("No se ingresó ningún archivo.", 1);
            } */

      $requerimiento->save();

      DB::commit();
      return redirect()->route('RequerimientoBS.Empleado.Listar')
        ->with('datos', 'Se ha Registrado el requerimiento N°' . $requerimiento->codigoCedepas);
    } catch (\Throwable $th) {

      Debug::mensajeError('REQUERIMIENTO BS CONTROLLER STORE', $th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('RequerimientoBS.Empleado.Listar')->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }

  //empleado
  public function ver($id)
  {


    $requerimiento = RequerimientoBS::findOrFail($id);
    $detalles = $requerimiento->detalles();
    $empleadoLogeado = Empleado::getEmpleadoLogeado();

    if ($requerimiento->codEmpleadoSolicitante != $empleadoLogeado->codEmpleado) {
      return redirect()->route('error')->with('datos', 'Los requerimientos solo pueden ser vistos por su creador.');
    }

    return view(
      'RequerimientoBS.Empleado.VerRequerimientoBS',
      compact('requerimiento', 'empleadoLogeado', 'detalles')
    );
  }


  //$cadena = "6*5" para descargar el quinto archivo del req numero 6
  public function descargarArchivoEmp($codArchivoReqEmp)
  {

    $archivo = ArchivoReqEmp::findOrFail($codArchivoReqEmp);

    $nombreArchivoGuardado = $archivo->nombreDeGuardado;

    //                          UBICACION                       NOMBRE CON EL QUE SE DESCARGA
    return Storage::download("/requerimientos/" . $nombreArchivoGuardado, $archivo->nombreAparente);
  }


  function eliminarArchivo($codArchivoReqEmp)
  {

    try {
      $archivo = ArchivoReqEmp::findOrFail($codArchivoReqEmp);
    } catch (\Throwable $th) {
      return redirect()->route('RequerimientoBS.Empleado.Listar')
        ->with('datos', 'ERROR: El archivo que desea eliminar no existe o ya ha sido eliminado, vuelva a la página de editar Requerimiento.');
    }

    try {
      db::beginTransaction();

      $nombreArchivEliminado = $archivo->nombreAparente;
      $req = $archivo->getRequerimiento();

      if ($req->codEmpleadoSolicitante != Empleado::getEmpleadoLogeado()->codEmpleado)
        throw new Exception("Solo el dueño del Requerimiento puede eliminar sus archivos.", 1);


      $archivo->eliminarArchivo();
      DB::commit();

      return redirect()->route('RequerimientoBS.Empleado.EditarRequerimientoBS', $req->codRequerimiento)
        ->with('datos', 'Archivo "' . $nombreArchivEliminado . '" eliminado exitosamente');
    } catch (\Throwable $th) {
      Debug::mensajeError(' REQUERIMIENTO BS ELIMINAR archivo EMP', $th);
      DB::rollback();
      $codErrorHistorial = ErrorHistorial::registrarError($th, app('request')->route()->getAction(), $codArchivoReqEmp);
      return redirect()->route('RequerimientoBS.Empleado.EditarRequerimientoBS', $req->codRequerimiento)->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }


  //desde una cuenta de contador, eliminar un archivo que haya subido un empleado
  function ContadorEliminarArchivoDelEmpleado($codArchivoReqEmp)
  {
    try {
      db::beginTransaction();
      $archivo = ArchivoReqEmp::findOrFail($codArchivoReqEmp);
      $nombreArchivEliminado = $archivo->nombreAparente;
      $req = $archivo->getRequerimiento();

      $archivo->eliminarArchivo();
      DB::commit();

      return redirect()->route('RequerimientoBS.Contador.ver', $req->codRequerimiento)
        ->with('datos', 'Archivo "' . $nombreArchivEliminado . '" eliminado exitosamente');
    } catch (\Throwable $th) {
      Debug::mensajeError(' REQUERIMIENTO BS ELIMINAR archivo EMP', $th);
      DB::rollback();
      $codErrorHistorial = ErrorHistorial::registrarError($th, app('request')->route()->getAction(), $codArchivoReqEmp);
      return redirect()->route('RequerimientoBS.Contador.ver', $req->codRequerimiento)
        ->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }






  public function descargarArchivoAdm($codArchivoReqAdm)
  {
    $archivo = ArchivoReqAdmin::findOrFail($codArchivoReqAdm);
    $nombreArchivoGuardado = $archivo->nombreDeGuardado;
    //                          UBICACION                       NOMBRE CON EL QUE SE DESCARGA
    return Storage::download("/requerimientos/" . $nombreArchivoGuardado, $archivo->nombreAparente);
  }

  public function editar($id)
  {
    $requerimiento = RequerimientoBS::findOrFail($id);


    $listaUnidadMedida = UnidadMedida::All();
    $proyectos = Proyecto::getProyectosActivos();
    $empleadoLogeado = Empleado::getEmpleadoLogeado();

    if ($requerimiento->codEmpleadoSolicitante != $empleadoLogeado->codEmpleado) {
      return redirect()->route('error')->with('datos', 'Los requerimientos solo pueden ser editados por el creador.');
    }

    return view(
      'RequerimientoBS.Empleado.EditarRequerimientoBS',
      compact('empleadoLogeado', 'listaUnidadMedida', 'proyectos', 'requerimiento')
    );
  }
  public function update(Request $request)
  {
    try {
      $requerimiento = RequerimientoBS::findOrFail($request->codRequerimiento);

      if ($requerimiento->codEmpleadoSolicitante != Empleado::getEmpleadoLogeado()->codEmpleado)
        return redirect()->route('RequerimientoBS.Empleado.Listar')
          ->with('datos', 'Error: El requerimiento no puede ser actualizado por un empleado distinto al que la creó.');

      if (!$requerimiento->listaParaActualizar())
        return redirect()->route('RequerimientoBS.Empleado.Listar')
          ->with('datos', 'Error: el requerimeinto no puede ser actualizado ahora puesto que está en otro proceso.');

      $requerimiento->codProyecto = $request->codProyecto;
      $requerimiento->justificacion = $request->justificacion;
      $requerimiento->codigoContrapartida = $request->codigoContrapartida;


      $cuenta = $request->cuentaBancariaProveedor;
      if (is_null($cuenta))
        $cuenta = "No ingresada";

      $requerimiento->cuentaBancariaProveedor = $cuenta;

      //si estaba observada, pasa a subsanada

      if ($requerimiento->verificarEstado('Observada'))
        $requerimiento->codEstadoRequerimiento = RequerimientoBS::getCodEstado('Subsanada');
      else
        $requerimiento->codEstadoRequerimiento = RequerimientoBS::getCodEstado('Creada');

      $requerimiento->save();

      $requerimiento->registrarOperacion(
        TipoOperacion::getCodTipoOperacion('REQ', 'Editar'),
        null,
        Puesto::getCodPuesto_Empleado()
      ); //siempre creará el empleado



      //$total=0;
      //borramos todos los detalles pq los ingresaremos again
      //DB::select('delete from detalle_requerimiento_bs where codRequerimiento=" '.$requerimiento->codRequerimiento.'"');
      DetalleRequerimientoBS::where('codRequerimiento', '=', $requerimiento->codRequerimiento)->delete();

      //creacion de detalles
      $vec[] = '';

      if ($request->cantElementos == 0)
        throw new Exception("No se ingresó ningún item.", 1);


      $i = 0;
      $cantidadFilas = $request->cantElementos;
      while ($i < $cantidadFilas) {
        $detalle = new DetalleRequerimientoBS();
        $detalle->codRequerimiento = $requerimiento->codRequerimiento; //ultimo insertad
        $detalle->codUnidadMedida = UnidadMedida::where('nombre', '=', $request->get('colTipo' . $i))->get()[0]->codUnidadMedida;

        $detalle->descripcion =              $request->get('colDescripcion' . $i);
        $detalle->cantidad =               $request->get('colCantidad' . $i);
        $detalle->codigoPresupuestal  =  $request->get('colCodigoPresupuestal' . $i);

        $detalle->save();
        $i = $i + 1;
      }

      $requerimiento->save();


      //SOLO BORRAMOS TODO E INSERTAMOS NUEVOS ARCHIVOS SI ES QUE SE INGRESÓ NUEVOS

      if (!is_null($request->nombresArchivos) && $request->nombresArchivos != "[]") { //SI NO ES NULO Y No está vacio

        Debug::mensajeSimple("o yara/" . $request->tipoIngresoArchivos);
        if ($request->tipoIngresoArchivos == "1") { //AÑADIR

        } else { //SOBRESRIBIR
          $requerimiento->borrarArchivosEmp();
        }

        $cantidadArchivosYaExistentes = $requerimiento->getCantidadArchivosEmp();



        //$nombresArchivos = explode(', ',$request->nombresArchivos);
        $nombresArchivos = json_decode($request->nombresArchivos); //ahora llega un vector en JSON ["archivo1.pdf","archivo2.pdf"]

        $j = 0;

        foreach ($request->file('filenames') as $archivo) {

          $nombreArchivoGuardado = $requerimiento->getNombreGuardadoNuevoArchivoEmp($cantidadArchivosYaExistentes +  $j + 1);
          Debug::mensajeSimple('el nombre de la imagen es:' . $nombreArchivoGuardado);

          $archivoReqEmp = new ArchivoReqEmp();
          $archivoReqEmp->codRequerimiento = $requerimiento->codRequerimiento;
          $archivoReqEmp->nombreDeGuardado = $nombreArchivoGuardado;
          $archivoReqEmp->nombreAparente = $nombresArchivos[$j];
          $archivoReqEmp->save();

          $fileget = \File::get($archivo);

          Storage::disk('requerimientos')->put($nombreArchivoGuardado, $fileget);
          $j++;
        }
      }



      return redirect()->route('RequerimientoBS.Empleado.Listar')
        ->with('datos', 'Se ha editado el requerimiento N°' . $requerimiento->codigoCedepas);
    } catch (\Throwable $th) {
      Debug::mensajeError('REQUERIMIENTO BS CONTROLLER UPDATE', $th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('RequerimientoBS.Empleado.Listar')->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }


  public function cancelar($id)
  {
    try {
      DB::beginTransaction();

      $requerimiento = RequerimientoBS::findOrFail($id);
      $empLogeado = Empleado::getEmpleadoLogeado();

      if (!$requerimiento->listaParaCancelar())
        return redirect()->route('RequerimientoBS.Empleado.Listar')
          ->with('datos', 'Error: el requerimiento no puede ser cancelado ahora puesto que está en otro proceso.');

      if ($requerimiento->codEmpleadoSolicitante != $empLogeado->codEmpleado)
        return redirect()->route('RequerimientoBS.Empleado.Listar')
          ->with('datos', 'Error: el requerimiento solo puede ser cancelado por la persona que lo creó.');


      $requerimiento->codEstadoRequerimiento =  RequerimientoBS::getCodEstado('Cancelada');
      $requerimiento->save();

      $requerimiento->registrarOperacion(
        TipoOperacion::getCodTipoOperacion('REQ', 'Cancelar'),
        null,
        Puesto::getCodPuesto_Empleado()
      ); //siempre contabiliza cont


      DB::commit();
      return redirect()->route('RequerimientoBS.Empleado.Listar')
        ->with('datos', 'Se canceló correctamente el requerimiento ' . $requerimiento->codigoCedepas);
    } catch (\Throwable $th) {
      Debug::mensajeError('REQUERIMIENTO BS CONTROLLER CANCELAR', $th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError($th, app('request')->route()->getAction(), $id);
      return redirect()->route('RequerimientoBS.Empleado.Listar')->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }



  /**GERENTE DE PROYECTOS */
  public function listarOfGerente(Request $request)
  {

    $empleado = Empleado::getEmpleadoLogeado();
    $proyectos = $empleado->getListaProyectos();

    if (count($proyectos) == 0)
      return redirect()->route('error')->with('datos', "No tiene ningún proyecto asignado...");

    $arrayCodProyectos = [];
    foreach ($proyectos as $itemproyecto) {
      $arrayCodProyectos[] = $itemproyecto->codProyecto;
    }


    $listaRequerimientos = RequerimientoBS::whereIn('codProyecto', $arrayCodProyectos);


    $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaRequerimientos, $request->getQueryString());

    $listaRequerimientos = UIFiltros::buildQuery($listaRequerimientos, $request->getQueryString());
    $filtros_usados = UIFiltros::getQueryValues($listaRequerimientos, $request->getQueryString());

    $listaRequerimientos = RequerimientoBS::ordenarParaGerente($listaRequerimientos)->paginate($this::PAGINATION);

    $empleados = Empleado::getListaEmpleadosPorApellido();


    return view('RequerimientoBS.Gerente.ListarRequerimientos', compact('listaRequerimientos', 'empleado', 'proyectos', 'empleados', 'filtros_usados_paginacion', 'filtros_usados'));
  }

  public function listarParaObservador(Request $request)
  {


    $empleado = Empleado::getEmpleadoLogeado();

    $listaProyectoObservador = ProyectoObservador::where('codEmpleadoObservador', $empleado->getId())->get();
    $estadosRequerimiento = EstadoRequerimientoBS::All();


    $codsProyectos = [];
    foreach ($listaProyectoObservador as $proy_obs) {
      $codsProyectos[] = $proy_obs->codProyecto;
    }

    if (count($codsProyectos) == 0)
      return redirect()->route('error')->with('datos', "No tiene ningún proyecto asignado para observar.");


    $proyectosDelObservador = Proyecto::whereIn('codProyecto', $codsProyectos)->orderBy('codigoPresupuestal', 'ASC')->get();
    $proyectosDelObservador = Proyecto::añadirNombreYcod($proyectosDelObservador);

    $listaRequerimientos = RequerimientoBS::whereIn('codProyecto', $codsProyectos);
    $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaRequerimientos, $request->getQueryString());

    $listaRequerimientos = UIFiltros::buildQuery($listaRequerimientos, $request->getQueryString());
    $filtros_usados = UIFiltros::getQueryValues($listaRequerimientos, $request->getQueryString());

    $listaRequerimientos = $listaRequerimientos->orderBy('codRequerimiento', 'DESC')->paginate($this::PAGINATION);

    $empleados = Empleado::getListaEmpleadosPorApellido();
    $listaBancos = Banco::All();

    return view('RequerimientoBS.Observador.ListarRequerimientos', compact(
      'filtros_usados_paginacion',
      'filtros_usados',
      'proyectosDelObservador',
      'estadosRequerimiento',
      'listaRequerimientos',
      'listaBancos',
      'empleado',
      'empleados',
      'estadosRequerimiento'
    ));
  }
  public function VerRequerimientoComoObservador($codRequerimiento)
  {
    $requerimiento = RequerimientoBS::findOrFail($codRequerimiento);
    $detalles = DetalleRequerimientoBS::where('codRequerimiento', '=', $codRequerimiento)->get();
    return view('RequerimientoBS.Observador.VerRequerimiento', compact('requerimiento', 'detalles'));
  }

  public function viewGeren($id)
  {

    $requerimiento = RequerimientoBS::findOrFail($id);
    $detalles = $requerimiento->detalles();
    $empleadoLogeado = Empleado::getEmpleadoLogeado();

    return view('RequerimientoBS.Gerente.EvaluarRequerimientoBS', compact('requerimiento', 'empleadoLogeado', 'detalles'));
  }

  public function VerAtender($codRequerimiento)
  {
    $requerimiento = RequerimientoBS::findOrFail($codRequerimiento);
    $detalles = DetalleRequerimientoBS::where('codRequerimiento', '=', $codRequerimiento)->get();
    return view('RequerimientoBS.Administrador.AtenderRequerimientoBS', compact('requerimiento', 'detalles'));
  }

  public function listarOfAdministrador(Request $request)
  {




    $empleado = Empleado::getEmpleadoLogeado();
    $proyectos = Proyecto::getProyectosActivos();

    $arrayCodProyectos = [];
    foreach ($proyectos as $itemproyecto) {
      $arrayCodProyectos[] = $itemproyecto->codProyecto;
    }


    $listaRequerimientos = RequerimientoBS::query();

    $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaRequerimientos, $request->getQueryString());

    $listaRequerimientos = UIFiltros::buildQuery($listaRequerimientos, $request->getQueryString());
    $filtros_usados = UIFiltros::getQueryValues($listaRequerimientos, $request->getQueryString());


    $listaRequerimientos = RequerimientoBS::ordenarParaAdministrador($listaRequerimientos)->paginate($this::PAGINATION);

    $empleados = Empleado::getListaEmpleadosPorApellido();



    return view(
      'RequerimientoBS.Administrador.ListarRequerimientos',
      compact('listaRequerimientos', 'empleado', 'proyectos', 'empleados', 'filtros_usados_paginacion', 'filtros_usados')
    );
  }



  /**CONTADOR */
  public function listarOfConta(Request $request)
  {

    $empleado = Empleado::getEmpleadoLogeado();
    $detallesProyContador = ProyectoContador::where('codEmpleadoContador', '=', $empleado->codEmpleado)->get();
    if (count($detallesProyContador) == 0)
      return redirect()->route('error')->with('datos', "No tiene ningún proyecto asignado...");


    $arrayCodProyectos = [];
    foreach ($detallesProyContador as $itemproyecto) {
      $arrayCodProyectos[] = $itemproyecto->codProyecto;
    }
    $arrayEstados = [3, 4, 5];

    $listaRequerimientos = RequerimientoBS::whereIn('codProyecto', $arrayCodProyectos)->whereIn('requerimiento_bs.codEstadoRequerimiento', $arrayEstados);

    $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaRequerimientos, $request->getQueryString());

    $listaRequerimientos = UIFiltros::buildQuery($listaRequerimientos, $request->getQueryString());
    $filtros_usados = UIFiltros::getQueryValues($listaRequerimientos, $request->getQueryString());

    $listaRequerimientos = RequerimientoBS::ordenarParaContador($listaRequerimientos)->paginate($this::PAGINATION);

    $proyectos = Proyecto::añadirNombreYcod(Proyecto::whereIn('codProyecto', $arrayCodProyectos)->get());


    $empleados = Empleado::getListaEmpleadosPorApellido();

    return view('RequerimientoBS.Contador.ListarRequerimientos', compact('listaRequerimientos', 'empleado', 'proyectos', 'empleados', 'filtros_usados', 'filtros_usados_paginacion'));
  }
  public function viewConta($id)
  {

    $requerimiento = RequerimientoBS::findOrFail($id);
    $detalles = $requerimiento->detalles();
    $empleadoLogeado = Empleado::getEmpleadoLogeado();

    return view('RequerimientoBS.Contador.ContabilizarRequerimientoBS', compact('requerimiento', 'empleadoLogeado', 'detalles'));
  }


  /* cambiar a request para subir archivos */
  public function contabilizar(Request $request)
  {
    try {
      DB::beginTransaction();

      $requerimiento = RequerimientoBS::findOrFail($request->codRequerimiento);

      if (!$requerimiento->listaParaContabilizar())
        return redirect()->route('RequerimientoBS.Listar')
          ->with('datos', 'ERROR: El requerimiento ya fue contabilizada o no está apta para serlo.');


      $requerimiento->codEstadoRequerimiento = RequerimientoBS::getCodEstado('Contabilizada');
      $empleadoLogeado = Empleado::getEmpleadoLogeado();

      $requerimiento->codEmpleadoContador = $empleadoLogeado->codEmpleado;
      $requerimiento->fechaHoraConta = new DateTime();

      $requerimiento->save();

      $requerimiento->registrarOperacion(
        TipoOperacion::getCodTipoOperacion('REQ', 'Contabilizar'),
        null,
        Puesto::getCodPuesto_Contador()
      ); //siempre contabiliza cont


      if (!is_null($request->nombresArchivos) && $request->nombresArchivos != "[]") { //SI NO ES NULO Y No está vacio

        Debug::mensajeSimple("Contabilizando /tipoIngresoArchivos = " . $request->tipoIngresoArchivos);
        if ($request->tipoIngresoArchivos == "1") { //AÑADIR

        } else { //SOBRESRIBIR
          $requerimiento->borrarArchivosEmp();
        }

        $cantidadArchivosYaExistentes = $requerimiento->getCantidadArchivosEmp();
        $nombresArchivos = json_decode($request->nombresArchivos); //ahora llega un vector en JSON ["archivo1.pdf","archivo2.pdf"]
        //$nombresArchivos = explode(', ',$request->nombresArchivos);
        $j = 0;

        foreach ($request->file('filenames') as $archivo) {

          $nombreArchivoGuardado = $requerimiento->getNombreGuardadoNuevoArchivoEmp($cantidadArchivosYaExistentes +  $j + 1);
          Debug::mensajeSimple('el nombre de la imagen es:' . $nombreArchivoGuardado);

          $archivoReqEmp = new ArchivoReqEmp();
          $archivoReqEmp->codRequerimiento = $requerimiento->codRequerimiento;
          $archivoReqEmp->nombreDeGuardado = $nombreArchivoGuardado;
          $archivoReqEmp->nombreAparente = $nombresArchivos[$j];
          $archivoReqEmp->save();

          $fileget = \File::get($archivo);

          Storage::disk('requerimientos')->put($nombreArchivoGuardado, $fileget);
          $j++;
        }
      }

      DB::commit();

      return redirect()->route('RequerimientoBS.Contador.Listar')
        ->with('datos', 'Requerimiento ' . $requerimiento->codigoCedepas . ' Contabilizado! ');
    } catch (\Throwable $th) {
      Debug::mensajeError('REQUERIMIENTO BS CONTROLLER : CONTABILIZAR', $th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('RequerimientoBS.Listar')->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }


  public function contabilizarFactura($codRequerimiento)
  {
    try {
      db::beginTransaction();

      $requerimiento = RequerimientoBS::findOrFail($codRequerimiento);
      $requerimiento->facturaContabilizada = 1;
      $requerimiento->save();

      db::commit();
      return redirect()->route('RequerimientoBS.Contador.ver', $codRequerimiento)
        ->with('datos', '¡Factura Contabilizada! ');
    } catch (\Throwable $th) {
      Debug::mensajeError('REQUERIMIENTO BS CONTROLLER : contabilizarFactura', $th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError($th, app('request')->route()->getAction(), $codRequerimiento);
      return redirect()->route('RequerimientoBS.Contador.ver', $codRequerimiento)
        ->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }

  /**CAMBIO DE ESTADOS */
  public function aprobar(Request $request)
  { //gerente
    //return $request;
    try {
      DB::beginTransaction();
      $requerimiento = RequerimientoBS::find($request->codRequerimiento);

      //AQUI TA EL ERROR
      if (!$requerimiento->listaParaAprobar())
        return redirect()->route('RequerimientoBS.Gerente.Listar')
          ->with('datos', 'Error: El requerimiento no puede ser aprobado ahora puesto que está en otro proceso.');


      $requerimiento->codEstadoRequerimiento =  RequerimientoBS::getCodEstado('Aprobada');
      $requerimiento->codEmpleadoEvaluador = Empleado::getEmpleadoLogeado()->codEmpleado;
      $requerimiento->justificacion = $request->justificacion;
      $requerimiento->fechaHoraRevision = new DateTime();
      $requerimiento->save();

      $requerimiento->registrarOperacion(
        TipoOperacion::getCodTipoOperacion('REQ', 'Aprobar'),
        null,
        Puesto::getCodPuesto_Gerente()
      ); //siempre Aprobar el gerente


      $listaDetalles = DetalleRequerimientoBS::where('codRequerimiento', '=', $requerimiento->codRequerimiento)->get();
      foreach ($listaDetalles as $itemDetalle) {
        $itemDetalle->codigoPresupuestal = $request->get('CodigoPresupuestal' . $itemDetalle->codDetalleRequerimiento);
        $itemDetalle->save();
      }



      DB::commit();

      return redirect()->route('RequerimientoBS.Gerente.Listar')
        ->with('datos', 'Se aprobó correctamente el requerimiento ' . $requerimiento->codigoCedepas);
    } catch (\Throwable $th) {
      Debug::mensajeError('REQUERIMIENTO BS APROBAR', $th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('RequerimientoBS.Listar')->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }


  public function rechazarComoGerente($id)
  { //gerente-administrador (codRequerimiento)
    try {
      DB::beginTransaction();
      $requerimiento = RequerimientoBS::findOrFail($id);

      if (!$requerimiento->listaParaRechazar())
        return redirect()->route('RequerimientoBS.Gerente.Listar')->with('datos', 'Error: el requerimiento no puede ser rechazado ahora puesto que está en otro proceso.');

      $this->rechazarGenerico($requerimiento, Puesto::getCodPuesto_Gerente());

      DB::commit();
      return redirect()->route('RequerimientoBS.Gerente.Listar')->with('datos', 'Se rechazó correctamente el requerimiento ' . $requerimiento->codigoCedepas);
    } catch (\Throwable $th) {
      Debug::mensajeError('REQUERIMIENTO BS CONTROLLER rechazarComoGerente', $th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError($th, app('request')->route()->getAction(), $id);
      return redirect()->route('RequerimientoBS.Gerente.Listar')->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }

  public function rechazarComoAdministrador($id)
  {
    try {
      DB::beginTransaction();
      $requerimiento = RequerimientoBS::findOrFail($id);

      if (!$requerimiento->listaParaRechazar())
        return redirect()->route('RequerimientoBS.Administrador.Listar')->with('datos', 'Error: el requerimiento no puede ser rechazado ahora puesto que está en otro proceso.');

      $this->rechazarGenerico($requerimiento, Puesto::getCodPuesto_Administrador());

      DB::commit();
      return redirect()->route('RequerimientoBS.Administrador.Listar')->with('datos', 'Se rechazó correctamente el requerimiento ' . $requerimiento->codigoCedepas);
    } catch (\Throwable $th) {
      Debug::mensajeError('REQUERIMIENTO BS CONTROLLER rechazarComoAdministrador', $th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError($th, app('request')->route()->getAction(), $id);
      return redirect()->route('RequerimientoBS.Administrador.Listar')->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }

  private function rechazarGenerico(RequerimientoBS $requerimiento, $codPuesto)
  {

    $requerimiento->codEstadoRequerimiento = RequerimientoBS::getCodEstado('Rechazada');
    $requerimiento->save();

    $requerimiento->registrarOperacion(
      TipoOperacion::getCodTipoOperacion('REQ', 'Rechazar'),
      null,
      $codPuesto
    );
  }




  public function observarComoGerente(Request $request)
  { //gerente-administracion
    try {
      DB::beginTransaction();


      $requerimiento = RequerimientoBS::find($request->codRequerimientoModal);

      if (!$requerimiento->listaParaObservar())
        return redirect()->route('RequerimientoBS.Gerente.Listar')->with('datos', 'Error: El requerimiento no puede ser observado ahora puesto que está en otro proceso.');

      $this->observarGenerico($requerimiento, $request->observacion, Puesto::getCodPuesto_Gerente());

      DB::commit();

      return redirect()->route('RequerimientoBS.Gerente.Listar')->with('datos', 'Se observó correctamente el requerimiento ' . $requerimiento->codigoCedepas);
    } catch (\Throwable $th) {
      DB::rollBack();
      Debug::mensajeError('REQUERIMIENTO BS CONTROLLER observarComoGerente', $th);
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('RequerimientoBS.Gerente.Listar')->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }

  public function observarComoAdministrador(Request $request)
  {
    try {
      DB::beginTransaction();

      $requerimiento = RequerimientoBS::find($request->codRequerimientoModal);

      if (!$requerimiento->listaParaObservar())
        return redirect()->route('RequerimientoBS.Administrador.Listar')->with('datos', 'Error: El requerimiento no puede ser observado ahora puesto que está en otro proceso.');

      $this->observarGenerico($requerimiento, $request->observacion, Puesto::getCodPuesto_Gerente());

      DB::commit();

      return redirect()->route('RequerimientoBS.Administrador.Listar')->with('datos', 'Se observó correctamente el requerimiento ' . $requerimiento->codigoCedepas);
    } catch (\Throwable $th) {
      DB::rollBack();
      Debug::mensajeError('REQUERIMIENTO BS CONTROLLER observarComoAdministrador', $th);
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('RequerimientoBS.Administrador.Listar')->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }



  public function observarGenerico(RequerimientoBS $requerimiento, $txtObservacion, $codPuesto)
  {
    $requerimiento->codEstadoRequerimiento = RequerimientoBS::getCodEstado('Observada');

    $requerimiento->observacion = $txtObservacion;
    $requerimiento->save();

    $requerimiento->registrarOperacion(
      TipoOperacion::getCodTipoOperacion('REQ', 'Observar'),
      $txtObservacion,
      $codPuesto
    );
  }


  /* FUNCION DEL ADMIN */
  /* Ahora esta funcion solo será para atender el requerimiento (cambiar su estado), los archivos se subiran aparte

    */
  public function atender($codRequerimiento)
  {
    try {
      DB::beginTransaction();
      $requerimiento = RequerimientoBS::findOrFail($codRequerimiento);

      if (!$requerimiento->listaParaAtender())
        return redirect()->route('RequerimientoBS.Administrador.Listar')
          ->with('datos', 'ERROR: El requerimiento ya fue atendido o no está apto para serlo.');

      $requerimiento->codEstadoRequerimiento = RequerimientoBS::getCodEstado('Atendida');
      $requerimiento->codEmpleadoAdministrador = Empleado::getEmpleadoLogeado()->codEmpleado;
      $requerimiento->fechaHoraAtendido = Carbon::now();

      //Si la factura estaba como No revisada (null), se marca como NO HABIDA.
      //Si estaba como SI HABIDA, no se cambia
      if (is_null($requerimiento->tieneFactura))
        $requerimiento->tieneFactura = 0;

      $requerimiento->save();

      $requerimiento->registrarOperacion(
        TipoOperacion::getCodTipoOperacion('REQ', 'Atender'),
        null,
        Puesto::getCodPuesto_Administrador()
      ); //siempre atendera el administrad


      DB::commit();
      return redirect()->route('RequerimientoBS.Administrador.Listar')
        ->with('datos', 'Requerimiento ' . $requerimiento->codigoCedepas . ' Atendido satisfactoriamente.');
    } catch (\Throwable $th) {
      Debug::mensajeError('REQUERIMIENTO BS CONTROLLER ATENDER', $th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError($th, app('request')->route()->getAction(), $codRequerimiento);
      return redirect()->route('RequerimientoBS.Administrador.Listar')
        ->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }


  /* Ahora la funcionalidad para subir los archivos del admin estará separada del ATENDER, proceso que solo cambiará el estado

    Esta funcion estará disponible hasta que se suba la factura
    */
  public function subirArchivosAdministrador(Request $request)
  {
    try {
      db::beginTransaction();
      $requerimiento = RequerimientoBS::findOrFail($request->codRequerimiento);

      $nombresArchivos = json_decode($request->nombresArchivos); //ahora llega un vector en JSON ["archivo1.pdf","archivo2.pdf"]

      $j = 0;

      if ($request->tipoIngresoArchivos == "1") { //AÑADIR

      } else { //SOBRESRIBIR
        $requerimiento->borrarArchivosAdmin();
      }
      $cantidadArchivosYaExistentes = $requerimiento->getCantidadArchivosAdmin();

      foreach ($request->file('filenames') as $archivo) {
        //               CDP-   000002                           -   5   .  jpg
        $nombreArchivoGuardado = $requerimiento->getNombreGuardadoNuevoArchivoAdm($cantidadArchivosYaExistentes + $j + 1);
        Debug::mensajeSimple('el nombre de la imagen es:' . $nombreArchivoGuardado);

        $archivoReqAdmin = new ArchivoReqAdmin();
        $archivoReqAdmin->codRequerimiento = $requerimiento->codRequerimiento;
        $archivoReqAdmin->nombreDeGuardado = $nombreArchivoGuardado;
        $archivoReqAdmin->nombreAparente = $nombresArchivos[$j];
        $archivoReqAdmin->save();

        $fileget = \File::get($archivo);

        Storage::disk('requerimientos')->put($nombreArchivoGuardado, $fileget);
        $j++;
      }

      $requerimiento->cantArchivosAdmin = $j;

      $requerimiento->registrarOperacion(
        TipoOperacion::getCodTipoOperacion('REQ', 'Subir archivos de administrador'),
        null,
        Puesto::getCodPuesto_Administrador()
      );

      db::commit();
      return redirect()->route('RequerimientoBS.Administrador.VerAtender', $requerimiento->codRequerimiento)
        ->with('datos', 'Archivos subidos exitosamente.');
    } catch (\Throwable $th) {
      Debug::mensajeError('REQUERIMIENTO BS CONTROLLER subirArchivosAdministrador', $th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('RequerimientoBS.Administrador.VerAtender')
        ->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }

  /* FUNCION AÑADIDA POSTERIORMENTE,
        Solamente pueden subirla cuando el requerimiento ya está contabilizada (solo este estado)
        se suben los archivos a los del admin. Es lo mismo que la funcion anterior pero este metodo puede llamarlo un empleado
    */
  public function empleado_subirFactura(Request $request)
  {
    try {

      db::beginTransaction();
      $requerimiento = RequerimientoBS::findOrFail($request->codRequerimiento);

      $nombresArchivos = json_decode($request->nombresArchivos); //ahora llega un vector en JSON ["archivo1.pdf","archivo2.pdf"]
      //$nombresArchivos = explode(', ',$request->nombresArchivos);

      $j = 0;

      if ($request->tipoIngresoArchivos == "1") { //AÑADIR

      } else { //SOBRESRIBIR
        $requerimiento->borrarArchivosAdmin();
      }
      $cantidadArchivosYaExistentes = $requerimiento->getCantidadArchivosAdmin();

      foreach ($request->file('filenames') as $archivo) {
        //               CDP-   000002                           -   5   .  jpg
        $nombreArchivoGuardado = $requerimiento->getNombreGuardadoNuevoArchivoAdm($cantidadArchivosYaExistentes + $j + 1);
        Debug::mensajeSimple('el nombre de la imagen es:' . $nombreArchivoGuardado);

        $archivoReqAdmin = new ArchivoReqAdmin();
        $archivoReqAdmin->codRequerimiento = $requerimiento->codRequerimiento;
        $archivoReqAdmin->nombreDeGuardado = $nombreArchivoGuardado;
        $archivoReqAdmin->nombreAparente = $nombresArchivos[$j];
        $archivoReqAdmin->save();

        $fileget = \File::get($archivo);

        Storage::disk('requerimientos')->put($nombreArchivoGuardado, $fileget);
        $j++;
      }

      $requerimiento->cantArchivosAdmin = $j;

      $requerimiento->registrarOperacion(
        TipoOperacion::getCodTipoOperacion('REQ', 'Subir factura'),
        null,
        Puesto::getCodPuesto_Empleado()
      );

      db::commit();
      return redirect()->route('RequerimientoBS.Empleado.ver', $requerimiento->codRequerimiento)
        ->with('datos', 'Factura subida exitosamente.');
    } catch (\Throwable $th) {
      Debug::mensajeError('REQUERIMIENTO BS CONTROLLER empleado_subirFactura', $th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        json_encode($request->toArray())
      );
      return redirect()->route('RequerimientoBS.Empleado.ver', $requerimiento->codRequerimiento)
        ->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }

  public function eliminarArchivosAdmin($codRequerimiento)
  {
    try {
      db::beginTransaction();
      $requerimiento = RequerimientoBS::findOrFail($codRequerimiento);


      $requerimiento->borrarArchivosAdmin();
      $requerimiento->cantArchivosAdmin = 0;

      $requerimiento->registrarOperacion(
        TipoOperacion::getCodTipoOperacion('REQ', 'Eliminar archivos administrador'),
        null,
        Puesto::getCodPuesto_Administrador()
      );

      db::commit();
      return redirect()->route('RequerimientoBS.Administrador.VerAtender', $requerimiento->codRequerimiento)
        ->with('datos', 'Archivos de administrador borrados exitosamente.');
    } catch (\Throwable $th) {
      Debug::mensajeError('REQUERIMIENTO BS CONTROLLER eliminarArchivosAdmin', $th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError(
        $th,
        app('request')->route()->getAction(),
        $codRequerimiento
      );
      return redirect()->route('RequerimientoBS.Administrador.VerAtender', $requerimiento->codRequerimiento)
        ->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }


  /* Funcion exclusiva para marcar si un requerimiento tiene factura o no
        no se puede marcar que ya tiene factura si no hay ningun archivo admin ingresado en ese req

    */
  public function marcarQueYaTieneFactura($codRequerimiento)
  {
    try {
      db::beginTransaction();
      $requerimiento = RequerimientoBS::findOrFail($codRequerimiento);
      $requerimiento->tieneFactura = 1;
      $requerimiento->save();

      $requerimiento->registrarOperacion(
        TipoOperacion::getCodTipoOperacion('REQ', 'Marcar factura'),
        null,
        Puesto::getCodPuesto_Administrador()
      ); //siempre contabiliza cont


      db::commit();

      return redirect()->route('RequerimientoBS.Administrador.VerAtender', $requerimiento->codRequerimiento)
        ->with('datos', 'Factura marcada como HABIDA exitosamente.');
    } catch (\Throwable $th) {
      Debug::mensajeError('REQUERIMIENTO BS CONTROLLER marcarQueYaTieneFactura', $th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError($th, app('request')->route()->getAction(), $codRequerimiento);
      return redirect()->route('RequerimientoBS.Administrador.VerAtender', $requerimiento->codRequerimiento)
        ->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }



  public function empleado_marcarQueYaTieneFactura($codRequerimiento)
  {
    try {
      db::beginTransaction();
      $requerimiento = RequerimientoBS::findOrFail($codRequerimiento);
      $requerimiento->tieneFactura = 1;
      $requerimiento->save();

      $requerimiento->registrarOperacion(
        TipoOperacion::getCodTipoOperacion('REQ', 'Marcar factura'),
        null,
        Puesto::getCodPuesto_Empleado()
      );
      db::commit();

      return redirect()->route('RequerimientoBS.Empleado.ver', $requerimiento->codRequerimiento)
        ->with('datos', 'Factura marcada como HABIDA exitosamente.');
    } catch (\Throwable $th) {
      Debug::mensajeError('REQUERIMIENTO BS CONTROLLER empleado_marcarQueYaTieneFactura', $th);
      DB::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError($th, app('request')->route()->getAction(), $codRequerimiento);
      return redirect()->route('RequerimientoBS.Empleado.ver', $requerimiento->codRequerimiento)
        ->with('datos', Configuracion::getMensajeError($codErrorHistorial));
    }
  }




  public function descargarPDF($codRequerimiento)
  {
    $requerimiento = RequerimientoBS::findOrFail($codRequerimiento);
    return $requerimiento->getPDF(true);
  }

  public function verPDF($codRequerimiento)
  {
    $requerimiento = RequerimientoBS::findOrFail($codRequerimiento);
    return $requerimiento->getPDF(false);
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



  function API_listarREQDeEmpleado($codEmpleado)
  {

    $listaRequerimientos = RequerimientoBS::where('codEmpleadoSolicitante', '=', $codEmpleado)
      ->orderBy('fechaHoraEmision', 'DESC')->get();
    $listaRequerimientos = RequerimientoBS::ordenarParaEmpleado($listaRequerimientos);

    $listaPreparada = [];
    foreach ($listaRequerimientos as $req) {
      $listaPreparada[] = $req->getVectorParaAPI();
    }

    return $listaPreparada;
  }

  function API_getREQ($codRequerimiento)
  {
    $requerimiento = RequerimientoBS::findOrFail($codRequerimiento);
    $listaDetalles = $requerimiento->getDetallesParaAPI();

    $reqPreparada = $requerimiento->getVectorParaAPI();
    $reqPreparada['listaDetalles'] = json_encode($listaDetalles);

    return json_encode($reqPreparada);
  }
}
