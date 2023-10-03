<?php

namespace App\Http\Controllers\CITE;

use App\Debug;
use App\Departamento;
use App\ErrorHistorial;
use App\Http\Controllers\Controller;
use App\IndicadorActividad;
use App\Models\CITE\ActividadCite;
use App\Models\CITE\IndicadorActividadCite;
use App\Models\CITE\MesConvenioCite;
use App\Models\CITE\MetaPat;
use App\Models\CITE\ModalidadServicio;
use App\Models\CITE\RelacionTipoMedioActividad;
 
use App\Models\CITE\TipoMedioVerificacion;
use App\Models\CITE\TipoServicio;
use Illuminate\Http\Request;

use App\Models\CITE\UnidadProductiva as UnidadProductiva;
use App\RespuestaAPI;
use App\TipoFinanciamiento;
use App\UI\UIFiltros;
use Illuminate\Support\Facades\DB;

class MatrizPatController extends Controller {


    public function VerMatriz(){
      $listaActividades = ActividadCite::getActividadesConConvenio();
      $listaMeses = MesConvenioCite::All();
      
      $listaDepartamentos = Departamento::getDepartamentosParaPat();

      return view('CITE.MatrizPat.VerMatriz',compact('listaActividades','listaMeses','listaDepartamentos'));
    }

    public function Inv_Matriz(){
      $listaActividades = ActividadCite::getActividadesConConvenio();
      $listaMeses = MesConvenioCite::All();
      
      $listaDepartamentos = Departamento::getDepartamentosParaPat();

      return view('CITE.MatrizPat.Inv_Matriz',compact('listaActividades','listaMeses','listaDepartamentos'));
    }

    public function Inv_Modal($codIndicador,$codMes,$codRegion){
      $indicador = IndicadorActividadCite::findOrFail($codIndicador);
      $actividad = $indicador->getActividad();
      $query_meta = MetaPat::where('codIndicador',$codIndicador);

      $tipo_reporte = "";
      $departamento = null;
      $mes = null;

      if($codMes != 0){ //reporte tipo mes
        $mes = MesConvenioCite::findOrFail($codMes);
        $query_meta = $query_meta->where('codMes',$codMes);  
        $valor_ejecutado = $indicador->getValorEjecutado_Mes($indicador,$mes);
        $listaServicios = IndicadorActividadCite::getServicios_Mes($indicador,$mes);
        
        $titulo_modal = "Ver Meta y Avance - Mes " .$codMes;

        $tipo_reporte = "mes";

      }else{ //reporte tipo region
        $departamento = Departamento::findOrFail($codRegion);
        $query_meta = $query_meta->where('codDepartamento',$codRegion);
        $valor_ejecutado = $indicador->getValorEjecutado_Region($indicador,$departamento);
        $listaServicios = IndicadorActividadCite::getServicios_Region($indicador,$departamento);
        
        $titulo_modal = "Ver Meta y Avance - Región ".$departamento->nombre;
        $tipo_reporte = "region";
        
      }

      $listaUnidades = IndicadorActividadCite::getListadoEntidadesMediblesSegunIndicador($listaServicios,'unidades');
      $listaUsuarios = IndicadorActividadCite::getListadoEntidadesMediblesSegunIndicador($listaServicios,'usuarios');
        

      $lista_resultados_meta = $query_meta->get();

      if(count($lista_resultados_meta) == 0){
        $valor_meta = 0;
      }else{
        $meta = $lista_resultados_meta[0];
        $valor_meta = $meta->valor_meta;
      }


      return view('CITE.MatrizPat.Inv_VerMetaPat',compact('indicador','actividad','valor_meta','valor_ejecutado','listaServicios','departamento','mes','tipo_reporte','titulo_modal','listaUnidades','listaUsuarios')); 
    }

    public function Inv_ModalMetaAnual($codIndicador){
      $indicador = IndicadorActividadCite::findOrFail($codIndicador);
      $actividad = $indicador->getActividad();
      $titulo_modal = "Meta de indicador";

      return view('CITE.MatrizPat.Inv_VerMetaIndicador',compact('indicador','actividad','titulo_modal')); 
    }

    public function GuardarActualizarMeta(Request $request){
      try {
        DB::beginTransaction();
        $indicador = IndicadorActividadCite::findOrFail($request->codIndicador);
        $valor_meta_actual = $request->valor_meta_actual;

        $query_meta = MetaPat::where('codIndicador',$indicador->codIndicador);
        if($request->tipo_reporte == "mes"){
          $query_meta = $query_meta->where('codMes',$request->codMes);  
        }else{ //region
          $query_meta = $query_meta->where('codDepartamento',$request->codDepartamento);
        }

        $lista_resultados_meta = $query_meta->get();
          
        if(count($lista_resultados_meta) == 0){ // no existe
          $meta = new MetaPat();
          $meta->codIndicador = $request->codIndicador;
          $meta->tipo_meta = $request->tipo_reporte;
          $meta->codMes = $request->codMes;
          $meta->codDepartamento = $request->codDepartamento;
          
          $msj = "Guardó";
        }else{ // ya existe
          $meta = $lista_resultados_meta[0];
          $msj = "Actualizó";
        }

        $meta->valor_meta = $valor_meta_actual;
        $meta->save();

        DB::commit();

        $vista_actualizada = $this->Inv_Matriz()->render();
        return RespuestaAPI::respuestaDatosOk("Se $msj exitosamente la meta.",$vista_actualizada);

      } catch (\Throwable $th) {
        
        DB::rollBack();
        return RespuestaAPI::respuestaError("¡ERROR! Ocurrió un error inesperado");
      }

    }

    public function GuardarActualizarMetaAnual(Request $request){
      
      try {
        DB::beginTransaction();
        $indicador = IndicadorActividadCite::findOrFail($request->codIndicador);
       
        $indicador->meta_anual = $request->meta_anual;
        $indicador->save();

        DB::commit();
        
        $vista_actualizada = $this->Inv_Matriz()->render();
        return RespuestaAPI::respuestaDatosOk("Se actualizó exitosamente la meta anual.",$vista_actualizada);

      } catch (\Throwable $th) {
        Debug::mensajeError("MatrizPatController",$th);
        DB::rollBack();
        return RespuestaAPI::respuestaError("¡ERROR! Ocurrió un error inesperado x");
      }
    }
}
