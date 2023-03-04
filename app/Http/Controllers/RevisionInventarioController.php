<?php

namespace App\Http\Controllers;

use App\ActivoInventario;
use App\Configuracion;
use App\Debug;
use App\DetalleRevision;
use App\Empleado;
use App\EmpleadoRevisador;
use App\ErrorHistorial;
use App\EstadoActivoInventario;
use App\Http\Controllers\Controller;
use App\RespuestaAPI;
use App\RevisionInventario;
use App\Sede;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevisionInventarioController extends Controller
{
    


    public function listarRevisiones(Request $request){
        $listaRevisiones = RevisionInventario::orderBy('fechaHoraInicio','DESC')->get();
        

        return view('Inventario.Revisiones.ListarRevisiones',compact('listaRevisiones'));

    }




    public function verRevision($codRevision){

        $empleados = Empleado::getListaEmpleadosPorApellido();
        $revision = RevisionInventario::findOrFail($codRevision);
        $listaDetalles = $revision->getDetalles();
        $estadosActivo = EstadoActivoInventario::All();
        $sedes = Sede::All();

        return view('Inventario.Revisiones.VerRevision',compact('revision','listaDetalles','estadosActivo','empleados','sedes'));



    }


    public function crear(){
        $empleados = Empleado::getListaEmpleadosPorApellido();
        $añoActual = date("Y");

        return view('Inventario.Revisiones.RegistrarRevision',compact('empleados','añoActual'));
    }

    public function guardar(Request $request){
        try{
            DB::beginTransaction();

            $revision = new RevisionInventario();
            $revision->año = $request->año;
            $revision->fechaHoraInicio = Carbon::now();
            $revision->descripcion = $request->descripcion;
            $revision->codEmpleadoResponsable = $request->codEmpleadoResponsable;
            $revision->save();
            $año = $revision->año;


            //solamente añadiremos a la tabla detalle_Revision a aquellos que aparezcan como DISPONIBLE en el inventario
            //los demás, deberán ser añadidos manualmente mediante el código de activo
            $listaActivosARevisar = ActivoInventario::where('codEstado',1)->get();
            foreach ($listaActivosARevisar as $activo) {
                $detRevision = new DetalleRevision();
                $detRevision->codActivo = $activo->codActivo;
                $detRevision->codRevision = $revision->codRevision;
                $detRevision->codEstado = 0; //aun no lo revisa
                $detRevision->save();
            }

            DB::commit();  
            return redirect()->route('RevisionInventario.Listar')
                ->with('datos',"Revisión del $año registrada exitosamente. Ya puede actualizar el estado de sus activos.");

        }catch(\Throwable $th){
            Debug::mensajeError('REVISION INVENTARIOCONTROLLER : GUARDAR',$th);
            
            DB::rollback();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             json_encode($request->toArray())
                                                            );
            return redirect()
                ->route('RevisionInventario.Listar')
                ->with('datos',Configuracion::getMensajeError($codErrorHistorial));
        }


    }


    public function Cerrar($codRevision){
        try{
            DB::beginTransaction();

            $revision = RevisionInventario::findOrFail($codRevision);
            $revision->fechaHoraCierre = Carbon::now();
            $revision->save();
            $año = $revision->año;
 
            DB::commit();  
 
            return redirect()->route('RevisionInventario.Ver',$codRevision)
                ->with('datos',"Revisión del año $año cerrada exitosamente.");
        }catch(\Throwable $th){
            Debug::mensajeError('REVISION INVENTARIO CONTROLLER : Cerrar',$th);
            
            DB::rollback();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                            $codRevision
                                                            );
            return redirect()
                ->route('RevisionInventario.Ver',$codRevision)
                ->with('datos',Configuracion::getMensajeError($codErrorHistorial));
        }
    }

    


    public function VistaMiniGrupoRevision(){
        return view('Inventario.Revisiones.VistaMiniGrupoRevision');


    }


    /* CRUD DE EMPS REVISORES */
    public function AñadirRevisorARevision(Request $request){

        try {
            
            db::beginTransaction();
            $revision = RevisionInventario::findOrFail($request->codRevision);

            if($revision->tieneAEmpleado($request->codEmpleado))
                return RespuestaAPI::respuestaError("El empleado seleccionado ya figura como revisador en esta revisión");


            $emp_revisador = new EmpleadoRevisador();
            $emp_revisador->codRevision =$request->codRevision;
            $emp_revisador->codEmpleado =$request->codEmpleado;
            $emp_revisador->codSede =$request->codSede;
            $emp_revisador->save();

            $nombre = $emp_revisador->getEmpleado()->getNombreCompleto();

            db::commit();

            return RespuestaAPI::respuestaOk("El empleado $nombre ha sido añadido exitosamente.");
        } catch (\Throwable $th) {
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             json_encode($request->toArray())
                                                            );
            return RespuestaAPI::respuestaError(Configuracion::getMensajeError($codErrorHistorial));
            
        }

    }

    public function QuitarRevisor($codEmpleadoRevisor){
        try {
            db::beginTransaction();
            $empRev  = EmpleadoRevisador::findOrFail($codEmpleadoRevisor);
            $nombre = $empRev->getEmpleado()->getNombreCompleto();
            $empRev->delete();
            db::commit();

            return RespuestaAPI::respuestaOk("El empleado $nombre ha sido eliminado exitosamente de la revisión.");
        } catch (\Throwable $th) {
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             $codEmpleadoRevisor
                                                            );
                                                            
            return RespuestaAPI::respuestaError(Configuracion::getMensajeError($codErrorHistorial));
            
        }

    }



    public function ObtenerHTMLRevisores($codRevision){


        $revision = RevisionInventario::findOrFail($codRevision);
        $listaEmpleadosRevisores = EmpleadoRevisador::where('codRevision','=',$revision->codRevision)->get();

        return view('Inventario.Revisiones.Invocables.Inv_Revisores',compact('revision','listaEmpleadosRevisores'));


    }






    public function CambiarEstadoDetalle(Request $request){

        try {
            db::beginTransaction();
            $det = DetalleRevision::findOrFail($request->codDetalleRevision);
            
            $det->codEstado = $request->codEstado;
            $det->save();

            $nombre = $det->getActivo()->nombre;
            $nombreEstado = $det->getEstado()->nombre;

            db::commit();

            return RespuestaAPI::respuestaOk("El activo '$nombre' ha sido cambiado al estado $nombreEstado.");
        } catch (\Throwable $th) {
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                            json_encode($request)
                                                            );
                                                            
            return RespuestaAPI::respuestaError(Configuracion::getMensajeError($codErrorHistorial));
            
        }

    }

    public function regenerarActivos($codRevision){


        try {
            db::beginTransaction();
            $revision = RevisionInventario::findOrFail($codRevision);
            $vectorCodigosActivos = $revision->getVectorCodigosActivos();     
            
            //solamente añadiremos a la tabla detalle_Revision a aquellos que aparezcan como DISPONIBLE en el inventario
            //los demás, deberán ser añadidos manualmente mediante el código de activo
            $listaActivosARevisar = ActivoInventario::where('codEstado',1)->get();
            
            $cant=0;
            foreach ($listaActivosARevisar as $activo) {
                if( !in_array( $activo->codActivo,$vectorCodigosActivos)){ //si no está en el array, lo añadimos

                    $detRevision = new DetalleRevision();
                    $detRevision->codActivo = $activo->codActivo;
                    $detRevision->codRevision = $revision->codRevision;
                    $detRevision->codEstado = 0; //aun no lo revisa
                    $detRevision->save();
                    $cant++;
                }
            }
            db::commit();

            return RespuestaAPI::respuestaOk("Se han generado $cant relaciones con los activos que se encuentran HABIDOS de la revisión anterior.");
        } catch (\Throwable $th) {
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                            $codRevision
                                                            );
                                                            
            return RespuestaAPI::respuestaError(Configuracion::getMensajeError($codErrorHistorial));
            
        }

    }

    

    /* API */
    public function API_ListarRevisiones(){
        $lista =  RevisionInventario::orderBy('fechaHoraInicio','DESC')->get();

        foreach ($lista as $rev) {
            $rev['anio'] = $rev->año;
            $rev['empleadoResponsable'] = $rev->getResponsable();
        }

        return $lista;
    }


    public function API_VerRevision($codRevision){

        $revision = RevisionInventario::findOrFail($codRevision);
        $revision['anio'] = $revision->año;
        $revision['detalles'] = $revision->getDetallesAPI();
        $revision['empleadoResponsable'] = $revision->getResponsable();
        $revision['nombre_empleadoResponsable'] = $revision->getResponsable()->getNombreCompleto();
        if($revision->estaAbierta()){
            $revision['fechaHoraCierre'] = "Revisión abierta";
        }

        return $revision;

    }



    public function API_marcarDetalleComoHabido(Request $request){
        try {
            db::beginTransaction();
            $revision = RevisionInventario::getRevisionActiva();

            //hallamos el activo
            $listaActivos = ActivoInventario::where('codigoAparente','=',$request->codigoAparente)->get();
            if(count($listaActivos)==0){
                return RespuestaAPI::respuestaError("No se encontró al activo con este código '".$request->codigoAparente."'");
            }
            $activo = $listaActivos[0];

            //hallamos el detalle revision
            $listaDet = DetalleRevision::where('codActivo',$activo->codActivo)
                ->where('codRevision',$revision->codRevision)->get();
            if(count($listaDet)==0){
                return RespuestaAPI::respuestaError("El activo no se encuentra en la revisión actual, regenere.");
            }

            $detalleRevision = $listaDet[0];

            $detalleRevision->codEstado = 1;
            $detalleRevision->save();

            $nombre = $detalleRevision->getActivo()->nombre;
            $nombreEstado = $detalleRevision->getEstado()->nombre;

            db::commit();

            return RespuestaAPI::respuestaOk("El activo '$nombre' ha sido marcado como HABIDO.");
        } catch (\Throwable $th) {
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                            json_encode($request)
                                                            );
                                                            
            return RespuestaAPI::respuestaError(Configuracion::getMensajeError($codErrorHistorial));
            
        }

    }

    public function API_marcarVariosDetallesConEstado(Request $request){
        try {
            db::beginTransaction();
            $revision = RevisionInventario::getRevisionActiva();
            $estado = EstadoActivoInventario::findOrFail($request->codEstado);

            $listaCodigos = json_decode($request->listaCodigos);
            $stringsNombres = [];
            foreach ($listaCodigos as $codigoAparente) {
                
                //hallamos el activo
                $listaActivos = ActivoInventario::where('codigoAparente','=',$codigoAparente)->get();
                if(count($listaActivos)==0)
                    return RespuestaAPI::respuestaError("No se encontró al activo con este código '".$codigoAparente."'");
                
                $activo = $listaActivos[0];

                //hallamos el detalle revision
                $listaDet = DetalleRevision::where('codActivo',$activo->codActivo)
                    ->where('codRevision',$revision->codRevision)->get();
                if(count($listaDet)==0)
                    return RespuestaAPI::respuestaError("El activo no se encuentra en la revisión actual, regenere.");
                

                $detalleRevision = $listaDet[0];

                $detalleRevision->codEstado = $request->codEstado;
                $detalleRevision->fechaHoraUltimoCambio = Carbon::now();
                $detalleRevision->save();

                $nombre = $detalleRevision->getActivo()->nombre;
                $stringsNombres[] = $nombre;
            }

            $stringsNombres = implode(", ",$stringsNombres);
            db::commit();

            return RespuestaAPI::respuestaOk("Los activos '$stringsNombres' ha sido marcado como ".$estado->nombre.".");
        } catch (\Throwable $th) {
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                            json_encode($request)
                                                            );
                                                            
            return RespuestaAPI::respuestaError(Configuracion::getMensajeError($codErrorHistorial));
            
        }


    }

}
