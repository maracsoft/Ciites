<?php

namespace App\Http\Controllers\CITE;

use App\Debug;
use App\ErrorHistorial;
use App\Http\Controllers\Controller;
use App\Models\CITE\ActividadCite;
use App\Models\CITE\IndicadorActividadCite;
use App\Models\CITE\RelacionTipoMedioActividad;
use App\Models\CITE\TipoMedioVerificacion;
use App\Models\CITE\TipoServicio;
use Illuminate\Http\Request;

use App\Models\CITE\UnidadProductiva as UnidadProductiva;
use App\RespuestaAPI;
use App\UI\UIFiltros;
use Illuminate\Support\Facades\DB;

class ActividadCiteController extends Controller
{
    
    public function Listar(Request $request){


      $listaActividades = ActividadCite::query();

      $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaActividades,$request->getQueryString());
        
      $listaServicios = UIFiltros::buildQuery($listaActividades,$request->getQueryString());
      $filtros_usados = UIFiltros::getQueryValues($listaServicios,$request->getQueryString());


      $listaActividades = $listaActividades
      ->where('codModalidad','=',1)
      ->join('cite-tipo_servicio','cite-tipo_servicio.codTipoServicio','=','cite-actividad.codTipoServicio')
      ->orderBy('indice','asc')
      ->get();
      $listaTiposServicio = TipoServicio::All();
      

      return view('CITE.Actividades.ListarActividades',compact('listaActividades','listaTiposServicio','filtros_usados','filtros_usados_paginacion'));
    }
  
    public function Crear(){

      
      $listaTiposServicio = TipoServicio::All();
      
      $tipos_medios = TipoMedioVerificacion::TodosOrdenadosPorFormato();
      foreach ($tipos_medios as $tipo) {
        $tipo['nombre_front'] = $tipo->indice_formato." ". $tipo->nombre;
      }

      return view('CITE.Actividades.CrearActividad',compact('listaTiposServicio','tipos_medios'));
    
    }
    public function Guardar(Request $request){
            
      try {

        DB::beginTransaction();
        $actividad = new ActividadCite();

        $actividad->nombre = $request->nombre;
        $actividad->indice = $request->indice;
        $actividad->codTipoServicio = $request->codTipoServicio;
        $actividad->descripcion = $request->descripcion;
        $actividad->save();


        DB::commit();
        return redirect()->route('CITE.Actividades.Editar',$actividad->codActividad)->with('datos_ok',"Se guardó exitosamente la actividad, ya puede vincularle formatos");

      } catch (\Throwable $th) {

          DB::rollBack();
          Debug::mensajeError("servicioController Guardar",$th);
          $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                          app('request')->route()->getAction(),
                                                          json_encode($request->toArray())
                                                          );
          return redirect()->route('CITE.Actividades.Listar')->with('datos_error',"Hubo un error");
        
      }
      
    }

    public function Editar($id){

      $actividad = ActividadCite::findOrFail($id);
      $listaTiposServicio = TipoServicio::All();
      
      $tipos_medios = TipoMedioVerificacion::TodosOrdenadosPorFormato();
      foreach ($tipos_medios as $tipo) {
        $tipo['nombre_front'] = $tipo->indice_formato." ". $tipo->nombre;
      }

      return view('CITE.Actividades.EditarActividad',compact('actividad','listaTiposServicio','tipos_medios'));
    
    }
    
    public function Actualizar(Request $request){
            
      try {

        DB::beginTransaction();
        $actividad = ActividadCite::findOrFail($request->codActividad);

        $actividad->nombre = $request->nombre;
        $actividad->indice = $request->indice;
        $actividad->codTipoServicio = $request->codTipoServicio;
        $actividad->descripcion = $request->descripcion;
        $actividad->save();


        DB::commit();
        return redirect()->route('CITE.Actividades.Editar',$request->codActividad)->with('datos_ok',"Se actualizó exitosamente la actividad");

      } catch (\Throwable $th) {

          DB::rollBack();
          Debug::mensajeError("servicioController AñadirFormato",$th);
          $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                          app('request')->route()->getAction(),
                                                          json_encode($request->toArray())
                                                          );
          return redirect()->route('CITE.Actividades.Editar',$request->codActividad)->with('datos_error',"Hubo un error");
        
      }
      
    }


    public function ActualizarNumeroOrden(Request $request){
      try {

        DB::beginTransaction();
        $relacion = RelacionTipoMedioActividad::findOrFail($request->codRelacion);
        $relacion->nro_orden = $request->nro_orden;
        $relacion->save();

        DB::commit();
        return RespuestaAPI::respuestaOk("Se actualizó exitosamente");

      } catch (\Throwable $th) {

          DB::rollBack();
          Debug::mensajeError("ActividadCiteController ActualizarNumeroOrden",$th);
          $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                          app('request')->route()->getAction(),
                                                          json_encode($request->toArray())
                                                          );
        return RespuestaAPI::respuestaError("error");

      }

    }

    public function AñadirFormatos(Request $request){
            
      try {

        DB::beginTransaction();
        
        $actividad = ActividadCite::findOrFail($request->codActividad);
        $codsTipoMedioVerificacion = explode(",",$request->codsTipoMedioVerificacion);

        foreach ($codsTipoMedioVerificacion as $codTipoMedioVerificacion) {
          $tipo_medio = TipoMedioVerificacion::findOrFail($codTipoMedioVerificacion);

          $existe = RelacionTipoMedioActividad::VerificarExistencia($actividad->codActividad,$tipo_medio->codTipoMedioVerificacion);
          if(!$existe){
            $nuevo = new RelacionTipoMedioActividad();
            $nuevo->codActividad = $request->codActividad;
            $nuevo->codTipoMedioVerificacion = $codTipoMedioVerificacion;
            $nuevo->nro_orden = 0;
            
            $nuevo->save();
          }
        }


        DB::commit();
        return redirect()->route('CITE.Actividades.Editar',$request->codActividad)->with('datos_ok',"Se añadieron exitosamente los formatos");

      } catch (\Throwable $th) {

          DB::rollBack();
          Debug::mensajeError("servicioController AñadirFormato",$th);
          $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                          app('request')->route()->getAction(),
                                                          json_encode($request->toArray())
                                                          );
          return redirect()->route('CITE.Actividades.Editar',$request->codActividad)->with('datos_error',"Hubo un error");
        
      }
      
    }

    
    public function QuitarFormatoDeActividad($id){
 
      try {

        DB::beginTransaction();
        $rela = RelacionTipoMedioActividad::findOrFail($id);
        $actividad = $rela->getActividad();
        $rela->delete();

        

        DB::commit();
        return redirect()->route('CITE.Actividades.Editar',$actividad->getId())->with('datos_ok',"Se eliminó exitosamente el formato");

      } catch (\Throwable $th) {

        DB::rollBack();
        Debug::mensajeError("servicioController QuitarFormatoDeActividad",$th);
        $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                        app('request')->route()->getAction(),
                                                        $id
                                                        );
        return redirect()->route('CITE.Actividades.Listar')->with('datos_error',"Hubo un error");
        
      }
      

    }

    public function Eliminar($codActividad){

      try {
        DB::beginTransaction();
        $actividad = ActividadCite::findOrFail($codActividad);
        
        $actividad->delete();

        DB::commit();
        return redirect()->route('CITE.Actividades.Listar')->with('datos_ok',"Se eliminó exitosamente la actividad");

      } catch (\Throwable $th) {

        DB::rollBack();
        Debug::mensajeError("servicioController Eliminar",$th);
        $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                        app('request')->route()->getAction(),
                                                        ""
                                                        );
        return redirect()->route('CITE.Actividades.Listar')->with('datos_error',"Hubo un error");
        
      }

    }


    public function GuardarActualizarIndicador(Request $request){

      try {
        DB::beginTransaction();
        if($request->codIndicador == 0){
          $indicador = new IndicadorActividadCite();
          $indicador->codActividad = $request->codActividad;
          $indicador->meta_anual = 0;
        }else{
          $indicador = IndicadorActividadCite::findOrFail($request->codIndicador);
        }
        
        $indicador->descripcion = $request->descripcion;
        $indicador->orden = $request->orden;
        $indicador->tipo_reporte = $request->tipo_reporte;
        $indicador->save();

        DB::commit();
        return redirect()->route('CITE.Actividades.Editar',$request->codActividad)->with('datos_ok',"Se guardó exitosamente la actividad");

      } catch (\Throwable $th) {

        DB::rollBack();
        Debug::mensajeError("servicioController AñadirFormato",$th);
        $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                        app('request')->route()->getAction(),
                                                        json_encode($request->toArray())
                                                        );
        return redirect()->route('CITE.Actividades.Editar',$request->codActividad)->with('datos_error',"Hubo un error");
        
      }

    }

    public function EliminarIndicador($codIndicador){
      
      try {
        DB::beginTransaction();
        $indicador = IndicadorActividadCite::findOrFail($codIndicador);
        $actividad = ActividadCite::findOrFail($indicador->codActividad);
        $codActividad = $actividad->getId();
        $indicador->delete();

        DB::commit();
        return redirect()->route('CITE.Actividades.Editar',$codActividad)->with('datos_ok',"Se eliminó exitosamente el indicador");

      } catch (\Throwable $th) {

        DB::rollBack();
        Debug::mensajeError("servicioController Eliminar",$th);
        $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                        app('request')->route()->getAction(),
                                                        ""
                                                        );
        return redirect()->route('CITE.Actividades.Editar',$codActividad)->with('datos_error',"Hubo un error");
        
      }
    }
}
