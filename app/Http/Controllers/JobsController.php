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


  public function ListarJobs()
  {
    $listaJobs = Job::orderBy('fechaHoraCreacion', 'DESC')->get();

    return view('Jobs.ListarJobs', compact('listaJobs'));
  }
  /*  */

  public function GuardarEditar(Request $request)
  {

    try {
      db::beginTransaction();

      $codJob = $request->codJob;
      if ($codJob == "-1") { //nuevo
        $job = new Job();
        $job->ejecutado = 0;
        $job->fechaHoraCreacion = Carbon::now();

        $msj = "creado";
      } else { //editar
        $job = Job::findOrFail($codJob);
        $msj = "editado";
      }

      $job->nombre = $request->nombre;
      $job->descripcion = $request->descripcion;
      $job->functionName = $request->functionName;


      $job->save();


      db::commit();

      return redirect()->route('Jobs.Listar')->with('datos', "Job $msj exitosamente");
    } catch (\Throwable $th) {

      db::rollBack();
      throw $th;

      return redirect()->route('Jobs.Listar')->with('datos', "Ocurrió un error");
    }
  }
  public function Eliminar($codJob)
  {
    try {
      $job = Job::findOrFail($codJob);
      if ($job->estaEjecutado()) {
        return redirect()->route('Jobs.Listar')->with('datos', "No se puede eliminar un job que ya fue ejecutado");
      }
      $job->delete();

      return redirect()->route('Jobs.Listar')->with('datos', "Job eliminado exitosamente.");
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function UnRunJob($codJob)
  {
    $job = Job::findOrFail($codJob);

    try {
      db::beginTransaction();
      if (!$job->estaEjecutado())
        return "ERROR, el job no ha sido ejecutado";


      $job->fechaHoraEjecucion = null;
      $job->ejecutado = 0;
      $job->save();

      db::commit();

      return redirect()->route('Jobs.Listar')->with('datos', "Job de-ejecutado exitosamente.");
    } catch (\Throwable $th) {
      db::rollBack();

      throw $th;
    }
  }


  public function RunJob($codJob)
  {
    $job = Job::findOrFail($codJob);

    try {
      db::beginTransaction();
      if ($job->estaEjecutado())
        return "ERROR, el job ya había sido ejecutado";

      $this->ejecutarJob($job);
      $job->fechaHoraEjecucion = Carbon::now();
      $job->ejecutado = 1;
      $job->save();

      db::commit();

      return redirect()->route('Jobs.Listar')->with('datos', "Job ejecutado exitosamente.");
    } catch (\Throwable $th) {
      db::rollBack();
      $codErrorHistorial = ErrorHistorial::registrarError($th, app('request')->route()->getAction(), json_encode($codJob));

      throw $th;
    }
  }


  private function ejecutarJob(Job $job)
  {

    /* En este switch linkeamos el nombre de la funcion obtenido de la bd con la funcion de este controller */
    switch ($job->functionName) {
      case 'GenerarPdfsSolicitud':
        $this->GenerarPdfsSolicitud();
        break;

      default:
        throw new Exception("No se encontró una funcion asociada al job con el nombre " . $job->functionName);
        break;
    }
  }

  public function GenerarPdfsSolicitud()
  {
    $listaSolicitudes = SolicitudFondos::query()->limit(30)->get();
    foreach ($listaSolicitudes as $sof) {
      if (!$sof->archivoPdfYaExiste()) {
        Debug::LogMessage("Generando pdf de " . $sof->codigoCedepas);
        $sof->guardarPdfStorage();
      }
    }
  }
}
