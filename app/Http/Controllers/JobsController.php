<?php

namespace App\Http\Controllers;

use App\ActivoInventario;
use App\BusquedaRepo;
use App\Configuracion;
use App\ContratoLocacion;
use App\ContratoPlazo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Debug;
use App\DetalleDJGastosMovilidad;
use App\DetalleRevision;
use App\DJGastosMovilidad;
use App\DJGastosVarios;
use App\DJGastosViaticos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\ErrorHistorial;
use Exception;
use App\Moneda;
use App\Empleado;
use App\EmpleadoPuesto;
use App\EmpleadoRevisador;
use App\Job;
use App\LogeoHistorial;
use App\MetaEjecutada;
use App\Models\CITE\ReporteMensualCite;
use App\Models\CITE\Servicio;
use App\Models\CITE\TipoPersoneria;
use App\Models\CITE\UnidadProductiva;
use App\Models\CITE\UsuarioCite;
use App\Models\Notificaciones\Notificacion;
use App\Models\PPM\PPM_ArchivoEjecucion;
use App\Models\PPM\PPM_AsistenciaDetalleprod;
use App\Models\PPM\PPM_DetalleProducto;
use App\Models\PPM\PPM_EjecucionActividad;
use App\Models\PPM\PPM_FGE_Item;
use App\Models\PPM\PPM_FGE_Marcacion;
use App\Models\PPM\PPM_FGE_Option;
use App\Models\PPM\PPM_FGE_Segmento;
use App\Models\PPM\PPM_Organizacion;
use App\Models\PPM\PPM_Participacion;
use App\Models\PPM\PPM_Persona;
use App\Models\PPM\PPM_Inscripcion;
use App\Models\PPM\PPM_RelacionOrganizacionSemestre;
use App\Models\PPM\PPM_RelacionPersonaSemestre;
use App\Models\PPM\PPM_Sincronizador;
use App\Numeracion;
use App\OperacionDocumento;
use App\OrdenCompra;
use App\ParametroSistema;
use App\Proyecto;
use App\ProyectoContador;
use App\Puesto;
use App\RendicionGastos;
use App\ReposicionGastos;
use App\RequerimientoBS;
use App\RevisionInventario;
use App\Sede;
use App\SolicitudFondos;

class JobsController extends Controller
{
  /* 
    Este controller es para hacer operaciones específicas en la base de datos, pero que solo deban ser corridas una vez
    Cada Job está linkeado a una funcion en este controller y tiene un registro en la tabla job
    
  
  */
  
  
  public function ListarJobs(){
    $listaJobs = Job::orderBy('fechaHoraCreacion','DESC')->get();

    return view('Jobs.ListarJobs',compact('listaJobs'));
  }
  /*  */

  public function GuardarEditar(Request $request){
    
    try {
      db::beginTransaction();

      $codJob = $request->codJob;
      if($codJob=="-1"){ //nuevo
        $job = new Job();
        $job->ejecutado = 0;
        $job->fechaHoraCreacion = Carbon::now();

        $msj = "creado";
        
      }else{ //editar
        $job = Job::findOrFail($codJob);
        $msj = "editado";
      }

      $job->nombre = $request->nombre;
      $job->descripcion = $request->descripcion;
      $job->functionName = $request->functionName;

      
      $job->save();


      db::commit();

      return redirect()->route('Jobs.Listar')->with('datos',"Job $msj exitosamente");

    } catch (\Throwable $th) {
      
      db::rollBack();
      throw $th;
      
      return redirect()->route('Jobs.Listar')->with('datos',"Ocurrió un error");

    }


  }
  public function Eliminar($codJob){
    try {
      $job = Job::findOrFail($codJob);
      if($job->estaEjecutado()){
        return redirect()->route('Jobs.Listar')->with('datos',"No se puede eliminar un job que ya fue ejecutado");
      }
      $job->delete();

      return redirect()->route('Jobs.Listar')->with('datos',"Job eliminado exitosamente.");
    } catch (\Throwable $th) {
      throw $th;
      
    }


  }

  public function UnRunJob($codJob){
    $job = Job::findOrFail($codJob);

    try {
      db::beginTransaction();
      if(!$job->estaEjecutado())
        return "ERROR, el job no ha sido ejecutado";

      
      $job->fechaHoraEjecucion = null;
      $job->ejecutado = 0;
      $job->save();

      db::commit();

      return redirect()->route('Jobs.Listar')->with('datos',"Job de-ejecutado exitosamente.");
    } catch (\Throwable $th) {
      db::rollBack();

      throw $th;
    }

  }


  public function RunJob($codJob){
    $job = Job::findOrFail($codJob);

    try {
      db::beginTransaction();
      if($job->estaEjecutado())
        return "ERROR, el job ya había sido ejecutado";

      $this->ejecutarJob($job);
      $job->fechaHoraEjecucion = Carbon::now();
      $job->ejecutado = 1;
      $job->save();

      db::commit();

      return redirect()->route('Jobs.Listar')->with('datos',"Job ejecutado exitosamente.");
    } catch (\Throwable $th) {
      db::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError($th,app('request')->route()->getAction(),json_encode($codJob));
      
      throw $th;
    }

  }

  
  private function ejecutarJob(Job $job){

    /* En este switch linkeamos el nombre de la funcion obtenido de la bd con la funcion de este controller */
    switch ($job->functionName) {
      case 'PoblarCodProyectoDeRendicion': $this->poblarCodProyectoDeRendicion(); break;
      case 'migrarPuestosDeTablaEmpleadoATablaEmpleadoPuesto': $this->migrarPuestosDeTablaEmpleadoATablaEmpleadoPuesto(); break;
      case 'migrarRolesDeCITEANuevoSistemaPuestos' : $this->migrarRolesDeCITEANuevoSistemaPuestos(); break;
      case 'remplazarCodEmpleadoDePerfilesViejos' : $this->remplazarCodEmpleadoDePerfilesViejos(); break;
      case 'PPM_ClonarUnidadesAOrganizaciones' : $this->PPM_ClonarUnidadesAOrganizaciones(); break;
      case 'PPM_BorrarTodasLasTablas' : $this->PPM_BorrarTodasLasTablas(); break;
      case 'PPM_FGE_ImportarData' : $this->PPM_FGE_ImportarData(); break;
      
      
      default:
        throw new Exception("No se encontró una funcion asociada al job con el nombre ".$job->functionName);
        break;
    }  

  }





  /* ************************************************** LISTA DE JOB FUNCTIONS **************************************************  */
  /* ************************************************** LISTA DE JOB FUNCTIONS **************************************************  */
  /* ************************************************** LISTA DE JOB FUNCTIONS **************************************************  */
  /* ************************************************** LISTA DE JOB FUNCTIONS **************************************************  */
  /* ************************************************** LISTA DE JOB FUNCTIONS **************************************************  */
  /* ************************************************** LISTA DE JOB FUNCTIONS **************************************************  */
  /* ************************************************** LISTA DE JOB FUNCTIONS **************************************************  */
  /* ************************************************** LISTA DE JOB FUNCTIONS **************************************************  */
  /* ************************************************** LISTA DE JOB FUNCTIONS **************************************************  */
  /* ************************************************** LISTA DE JOB FUNCTIONS **************************************************  */
  /* ************************************************** LISTA DE JOB FUNCTIONS **************************************************  */
  /* ************************************************** LISTA DE JOB FUNCTIONS **************************************************  */
  /* ************************************************** LISTA DE JOB FUNCTIONS **************************************************  */
  /* ************************************************** LISTA DE JOB FUNCTIONS **************************************************  */
  /* ************************************************** LISTA DE JOB FUNCTIONS **************************************************  */
  /* ************************************************** LISTA DE JOB FUNCTIONS **************************************************  */
  /* ************************************************** LISTA DE JOB FUNCTIONS **************************************************  */
  /* ************************************************** LISTA DE JOB FUNCTIONS **************************************************  */
  /* ************************************************** LISTA DE JOB FUNCTIONS **************************************************  */


  private function PoblarCodProyectoDeRendicion(){
        
    $listaRendiciones = RendicionGastos::All();

    foreach ($listaRendiciones as $rendicion) {
      $rendicion->codProyecto = $rendicion->getSolicitud()->codProyecto;
      $rendicion->save();
    }

  }



    /* operacion para migrar los puestos al nuevo sistema */
  private function migrarPuestosDeTablaEmpleadoATablaEmpleadoPuesto(){

      
      EmpleadoPuesto::where('codEmpleadoPuesto','>',0)->delete();//delete all bc this function will create all

      $codPuestoEmpleado = Puesto::getCodPuesto_Empleado();
      $listaEmpleados = Empleado::All();
      foreach ($listaEmpleados as $emp) {

          //SI no tiene el rol de empleaod, se lo añadimos
          if($emp->codPuesto != $codPuestoEmpleado){
              $empPuesto1 = new EmpleadoPuesto();
              $empPuesto1->codPuesto = $codPuestoEmpleado;
              $empPuesto1->codEmpleado = $emp->getId();
              $empPuesto1->save();

          }
          $empPuesto = new EmpleadoPuesto();
          $empPuesto->codPuesto = $emp->codPuesto;
          $empPuesto->codEmpleado = $emp->getId();
          $empPuesto->save();
      }
     
    
  }


  public function migrarRolesDeCITEANuevoSistemaPuestos(){

    $codsArticuladores = explode(",",ParametroSistema::getParametroSistema("listaArticuladores")->valor); 
    $listaArticuladores = Empleado::whereIn('codEmpleado',$codsArticuladores)->get();

    $codsEquipo = explode(",",ParametroSistema::getParametroSistema("listaEquipos")->valor);
    $listaEquipos = Empleado::whereIn('codEmpleado',$codsEquipo)->get();

    $codPuestoArticulador = Puesto::getCodPuesto_Articulador();
    Debug::mensajeSimple(json_encode($listaArticuladores));

    foreach ($listaArticuladores as $articulador) {
        $empleado_puesto = new EmpleadoPuesto();
        $empleado_puesto->codPuesto = $codPuestoArticulador;
        $empleado_puesto->codEmpleado = $articulador->codEmpleado;
        $empleado_puesto->save();
        
    }
    
    $codPuestoEquipo = Puesto::getCodPuesto_Equipo();
    Debug::mensajeSimple(json_encode($listaEquipos));

    foreach ($listaEquipos as $equipo) {
      $empleado_puesto = new EmpleadoPuesto();
      $empleado_puesto->codPuesto = $codPuestoEquipo;
      $empleado_puesto->codEmpleado = $equipo->codEmpleado;
      $empleado_puesto->save();

    }


  }


  /* 
    Gianluiigui cod 3, tiene 41 REPOS
    Aparco cod 6, tiene 42 REPOS
    Eliminaré a gianluigui

    Debería quedar
    Gianluiigui 0
    Aparco 83

  */
  /* 
  Remplaza todos los cod empleados de los perfiles que fueron creados debido al anterior sistema de puestos
  Toma como entrada el parametro sistema 'relacion_codEmpleados_remplazar' que está construido así
    "15-61,12-76,13-11"
    Donde por ejemplo para el primer par 15-61, el 15 es el codEmpleado a eliminar y el 61 el que será puesto encima
  
  */
  public function remplazarCodEmpleadoDePerfilesViejos(){
    $cadena_relacion = ParametroSistema::getParametroSistema("relacion_codEmpleados_remplazar")->valor;
    $relaciones = explode(",",$cadena_relacion);
    foreach ($relaciones as $relacion) {
      $array = explode("-",$relacion);
      $codAEliminar = $array[0];
      $nuevoCod = $array[1];

      /* Lista de todos los lugares donde aparece el codEmpleado */
      /* Se exceptua el Empleado y EmpleadoPuesto */
      
      BusquedaRepo::where('codEmpleado',$codAEliminar)->update(['codEmpleado'=>$nuevoCod]);   
      ReporteMensualCite::where('codEmpleado',$codAEliminar)->update(['codEmpleado'=>$nuevoCod]);   
      Servicio::where('codEmpleadoCreador',$codAEliminar)->update(['codEmpleadoCreador'=>$nuevoCod]);   
      UnidadProductiva::where('codEmpleadoCreador',$codAEliminar)->update(['codEmpleadoCreador'=>$nuevoCod]);   
      
      UnidadProductiva::where('codEmpleadoCreador',$codAEliminar)->update(['codEmpleadoCreador'=>$nuevoCod]); 
      UsuarioCite::where('codEmpleadoCreador',$codAEliminar)->update(['codEmpleadoCreador'=>$nuevoCod]);   

      ContratoLocacion::where('codEmpleadoCreador',$codAEliminar)->update(['codEmpleadoCreador'=>$nuevoCod]); 
      ContratoPlazo::where('codEmpleadoCreador',$codAEliminar)->update(['codEmpleadoCreador'=>$nuevoCod]); 
      OrdenCompra::where('codEmpleadoCreador',$codAEliminar)->update(['codEmpleadoCreador'=>$nuevoCod]);  

      
      DJGastosMovilidad::where('codEmpleado',$codAEliminar)->update(['codEmpleado'=>$nuevoCod]); 
      DJGastosVarios::where('codEmpleado',$codAEliminar)->update(['codEmpleado'=>$nuevoCod]); 
      DJGastosViaticos::where('codEmpleado',$codAEliminar)->update(['codEmpleado'=>$nuevoCod]); 
      //EmpleadoRevisador::where('codEmpleado',$codAEliminar)->update(['codEmpleado'=>$nuevoCod]); 
      ErrorHistorial::where('codEmpleado',$codAEliminar)->update(['codEmpleado'=>$nuevoCod]); 
      LogeoHistorial ::where('codEmpleado',$codAEliminar)->update(['codEmpleado'=>$nuevoCod]); 
      MetaEjecutada::where('codEmpleado',$codAEliminar)->update(['codEmpleado'=>$nuevoCod]); 
      Notificacion::where('codEmpleado',$codAEliminar)->update(['codEmpleado'=>$nuevoCod]); 
      OperacionDocumento::where('codEmpleado',$codAEliminar)->update(['codEmpleado'=>$nuevoCod]); 
      
      Proyecto::where('codEmpleadoDirector',$codAEliminar)->update(['codEmpleadoDirector'=>$nuevoCod]);  
      ProyectoContador::where('codEmpleadoContador',$codAEliminar)->update(['codEmpleadoContador'=>$nuevoCod]); 
      
      RendicionGastos::where('codEmpleadoSolicitante',$codAEliminar)->update(['codEmpleadoSolicitante'=>$nuevoCod]); 
      RendicionGastos::where('codEmpleadoEvaluador',$codAEliminar)->update(['codEmpleadoEvaluador'=>$nuevoCod]); 
      RendicionGastos::where('codEmpleadoContador',$codAEliminar)->update(['codEmpleadoContador'=>$nuevoCod]); 

      ReposicionGastos::where('codEmpleadoSolicitante',$codAEliminar)->update(['codEmpleadoSolicitante'=>$nuevoCod]);  
      ReposicionGastos::where('codEmpleadoEvaluador',$codAEliminar)->update(['codEmpleadoEvaluador'=>$nuevoCod]); 
      ReposicionGastos::where('codEmpleadoAdmin',$codAEliminar)->update(['codEmpleadoAdmin'=>$nuevoCod]); 
      ReposicionGastos::where('codEmpleadoConta',$codAEliminar)->update(['codEmpleadoConta'=>$nuevoCod]); 


      RequerimientoBS::where('codEmpleadoSolicitante',$codAEliminar)->update(['codEmpleadoSolicitante'=>$nuevoCod]);  
      RequerimientoBS::where('codEmpleadoEvaluador',$codAEliminar)->update(['codEmpleadoEvaluador'=>$nuevoCod]); 
      RequerimientoBS::where('codEmpleadoAdministrador',$codAEliminar)->update(['codEmpleadoAdministrador'=>$nuevoCod]); 
      RequerimientoBS::where('codEmpleadoContador',$codAEliminar)->update(['codEmpleadoContador'=>$nuevoCod]); 

      SolicitudFondos::where('codEmpleadoSolicitante',$codAEliminar)->update(['codEmpleadoSolicitante'=>$nuevoCod]);  
      SolicitudFondos::where('codEmpleadoEvaluador',$codAEliminar)->update(['codEmpleadoEvaluador'=>$nuevoCod]); 
      SolicitudFondos::where('codEmpleadoAbonador',$codAEliminar)->update(['codEmpleadoAbonador'=>$nuevoCod]); 
      SolicitudFondos::where('codEmpleadoContador',$codAEliminar)->update(['codEmpleadoContador'=>$nuevoCod]); 


      //RevisionInventario::where('codEmpleadoResponsable',$codAEliminar)->update(['codEmpleadoResponsable'=>$nuevoCod]); 
      //ActivoInventario::where('codEmpleadoResponsable',$codAEliminar)->update(['codEmpleadoResponsable'=>$nuevoCod]);
      //DetalleRevision::where('codEmpleadoQueReviso',$codAEliminar)->update(['codEmpleadoQueReviso'=>$nuevoCod]); 

      Sede::where('codEmpleadoAdministrador',$codAEliminar)->update(['codEmpleadoAdministrador'=>$nuevoCod]); 
      
      
    } 



  }


  /* 
  copia el contenido de 
    UnidadProductiva -> PPM_Organizacion
    UsuarioCite -> PPM_Persona
    RelacionUsuarioUnidad -> PPM_Inscripcion
  */

  public function PPM_ClonarUnidadesAOrganizaciones(){
    try {
      db::beginTransaction();
      $listaUnidades = UnidadProductiva::GetUnidadesQueSeClonaranPPM();
    
      foreach ($listaUnidades as $unidad) {
        Debug::LogMessage("------------- Clonando unidad ".$unidad->ruc." a PPM");
        
        //creamos la organizacion
        $organizacion = $unidad->crearOrganizacionEnBase();
        $organizacion->save();

        //Enlazamos
        $unidad->activar_enlace_ppm = 1;
        $unidad->codOrganizacionEnlazadaPPM = $organizacion->getId();
        $unidad->save();
        
        // Sincronizamos los socios
        PPM_Sincronizador::SincronizarSocios($organizacion,$unidad);

      }

      db::commit();
    } catch (\Throwable $th) {
      db::rollBack();
      throw $th;
    }
   

  }



  /* Script para correr solo localmente */
  public function PPM_BorrarTodasLasTablas(){

    try {
      DB::beginTransaction();

      $entorno = ParametroSistema::getEntorno();
      if($entorno != "local"){
        throw new Exception("ESTE SCRIPT SOLO PUEDE SER EJECUTADO EN EL ENTORNO LOCAL");
      }

      PPM_AsistenciaDetalleprod::query()->delete();
      PPM_DetalleProducto::query()->delete();
      PPM_FGE_Marcacion::query()->delete();
      PPM_RelacionOrganizacionSemestre::query()->delete();
      PPM_Participacion::query()->delete();
      PPM_RelacionPersonaSemestre::query()->delete();
      PPM_Inscripcion::query()->delete();
      PPM_ArchivoEjecucion::query()->delete();
      PPM_EjecucionActividad::query()->delete();
      PPM_Organizacion::query()->delete();
      PPM_Persona::query()->delete();

      DB::commit();
      return "Se borraron las tablas de PPM exitosamente";
    } catch (\Throwable $th) {
      DB::rollBack();
      throw $th;
    }
    

  }


  public function PPM_FGE_ImportarData(){

    try {
      
      db::beginTransaction();

      $fp = fopen ("D:\Repositorios\Cedepas\Documentacion\ModuloPPM\cuestionario_fge.csv","r");
      
      while ($data = fgetcsv ($fp, 1000, ";")) {
        
        $segmento_name = $data[0];
        $item_description = $data[1];
        $option_description = $data[2];
        $valor = intval(substr($option_description,0,1));
        
        $segmento = PPM_FGE_Segmento::BuscarYSiNoExisteCrear($segmento_name);
        $item = PPM_FGE_Item::BuscarYSiNoExisteCrear($item_description,$segmento);
        $option = PPM_FGE_Option::BuscarYSiNoExisteCrear($option_description,$item,$valor);

      }

      db::commit();
    } catch (\Throwable $th) {
      db::rollBack();
      throw $th;
    }

  }
}
