<?php

namespace App\Http\Controllers\PPM;

use App\ArchivoGeneral;
use App\Configuracion;
use App\Debug;
use App\Departamento;
use App\Empleado;
use App\ErrorHistorial;
use App\Fecha;
use App\Http\Controllers\Controller;
use App\MesAño;
use App\Models\CITE\ArchivoServicio;
use App\Models\PPM\PPM_ArchivoEjecucion;
use Illuminate\Http\Request;

 
 
use App\Models\PPM\PPM_EjecucionActividad;
use App\Models\PPM\PPM_FGE_Item;
use App\Models\PPM\PPM_FGE_Marcacion;
use App\Models\PPM\PPM_FGE_Option;
use App\Models\PPM\PPM_FGE_Segmento;
use App\Models\PPM\PPM_Indicador;
use App\Models\PPM\PPM_Objetivo;
use App\Models\PPM\PPM_Organizacion;
use App\Models\PPM\PPM_Participacion;
use App\Models\PPM\PPM_Persona;
use App\Models\PPM\PPM_RealizoAccionOption;
use App\Models\PPM\PPM_RelacionOrganizacionSemestre;
use App\Models\PPM\PPM_Inscripcion;
use App\Models\PPM\PPM_Producto;
use App\Models\PPM\PPM_RelacionPersonaSemestre;
use App\Models\PPM\PPM_Sexo;
use App\Models\PPM\PPM_TipoProducto;
use App\ParametroSistema;
use App\RespuestaAPI;
use App\Semestre;
use App\TipoArchivoGeneral;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class IndicadorPPMController extends Controller
{

  public function VerRegistrar(){
    $listaObjetivos = PPM_Objetivo::todosParaFront();
    $listaRegiones = Departamento::All();
    $listaEmpleados = Empleado::prepararParaSelect(Empleado::getListaEmpleadosPorApellido());

    $listaSemestres = Semestre::TodosParaFront();

    $descargarExcel = ParametroSistema::getParametroSistema("activarReportesAExcel")->valor;
    
    $listaOptions = PPM_FGE_Option::All();
    $listaItems = PPM_FGE_Item::All();
    $listaSegmentos = PPM_FGE_Segmento::All();
    foreach ($listaSegmentos as $segmento) {
      $segmento['items'] = $segmento->getItems();
    }

    $listaProductos = PPM_Producto::All();
    $listaTipoProducto = PPM_TipoProducto::All();

    $codTipoProducto_Producto = PPM_TipoProducto::getCodigoDeProducto();
    $codTipoProducto_CultivoCadena = PPM_TipoProducto::getCodigoDeCultivoCadena();    

    return view('PPM.Indicador.RegistrarIndicadoresPPM',compact('listaOptions','listaSemestres','listaObjetivos','listaRegiones','listaEmpleados','descargarExcel','listaItems','listaSegmentos','listaProductos',
    'listaTipoProducto',
    'codTipoProducto_Producto',
    'codTipoProducto_CultivoCadena',));
    
  }


  private function GetListaRelacionesPorRequest(Request $request){

    $array_semestres = explode(",",$request->codsSemestres);

    if($request->codIndicador == "5"){ //caso 3.1, este reporte es por organizaciones
      $query = PPM_RelacionOrganizacionSemestre::query();
    }else{//caso normal
      $query = PPM_RelacionPersonaSemestre::query();
    }

    $lista_ejecuciones_query = PPM_EjecucionActividad::where('codIndicador',$request->codIndicador);
    
    if($request->codsUsuarios){
      $codsEmpleados = explode(",",$request->codsUsuarios);
      $lista_ejecuciones_query = $lista_ejecuciones_query->whereIn('codEmpleadoCreador',$codsEmpleados);
    }
    if($request->codsRegiones){
      $codsDepartamentos = explode(",",$request->codsRegiones);
      $lista_ejecuciones_query = $lista_ejecuciones_query->whereIn('codDepartamento',$codsDepartamentos);
    }

    $lista_ejecuciones_validas = $lista_ejecuciones_query->get();
    $array_codsEjecucionesValidas = [];
    foreach ($lista_ejecuciones_validas as $ejec) {
      $array_codsEjecucionesValidas[] = "(".$ejec->getId().")";
    }
    


    $lista_relaciones = $query->whereIn('codSemestre',$array_semestres)
      ->get();
    
    
    $relaciones_validas = new Collection();
    //ahora cruzamos las relaciones
    foreach ($lista_relaciones as $rela) {
      //verificamos si la relacion es sustentada por alguna de las ejecuciones válidas segun la búsqueda
      $array_codsEjecuciones_relacion = explode(",",$rela->codsEjecuciones);
      

      //para que esto se de, ambos arrays deben tener al menos un elemento en comun
      $coincidencias = array_intersect($array_codsEjecucionesValidas,$array_codsEjecuciones_relacion);
      if(count($coincidencias) == 0){//ninguno en comun

      }else{ //si tienen uno en comun, sí sustentada y se tomará en cuenta para el filtro
        $relaciones_validas->push($rela);
      }

    }
     
    

    return $relaciones_validas;
  }

  public function Inv_VerTabla(Request $request){
    
    $indicador = PPM_Indicador::findOrFail($request->codIndicador);
    $listaRelaciones = static::GetListaRelacionesPorRequest($request);

    
    switch ($indicador->getCodigo()) {
      case '1.1':
        return static::GetTablaIndicador11($listaRelaciones);
      case '1.2':
        return static::GetTablaIndicador12($listaRelaciones);
      case '2.1':
        return static::GetTablaIndicador21($listaRelaciones);
      case '2.2':
        return static::GetTablaIndicador22($listaRelaciones);
      case '3.1':
        return static::GetTablaIndicador31($listaRelaciones);
        break;
    
      case '3.2':
        return static::GetTablaIndicador32($listaRelaciones);
      default:
        # code...
        break;
    }
     
  }




  private static function GetTablaIndicador11($listaRelaciones){
    return view('PPM.Indicador.Invocables.Inv_VerTabla11',compact('listaRelaciones'));
  } 
  private static function GetTablaIndicador12($listaRelaciones){
    return view('PPM.Indicador.Invocables.Inv_VerTabla12',compact('listaRelaciones'));
  } 
  private static function GetTablaIndicador21($listaRelaciones){
    return view('PPM.Indicador.Invocables.Inv_VerTabla21',compact('listaRelaciones'));
  } 

  private static function GetTablaIndicador22($listaRelaciones){
    $options22 = PPM_RealizoAccionOption::All();

    return view('PPM.Indicador.Invocables.Inv_VerTabla22',compact('listaRelaciones','options22'));
  } 
  private static function GetTablaIndicador31($listaRelaciones){
    return view('PPM.Indicador.Invocables.Inv_VerTabla31',compact('listaRelaciones'));
  }
  private static function GetTablaIndicador32($listaRelaciones){
    return view('PPM.Indicador.Invocables.Inv_VerTabla32',compact('listaRelaciones'));
  } 

  /* REPORTES ------------------ */
  public function DescargarReporteIndicador(Request $request){
    
    $indicador = PPM_Indicador::findOrFail($request->codIndicador);
    $listaRelaciones = static::GetListaRelacionesPorRequest($request);

    $descargarExcel = ParametroSistema::getParametroSistema("activarReportesAExcel")->valor;
    $descargarExcel = ($descargarExcel == 'true');


    $array_semestres = explode(",",$request->codsSemestres);
    $semestres_filtro = Semestre::whereIn("codSemestre",$array_semestres)->get();
    $semestre_label = [];
    foreach ($semestres_filtro as $sem) {
      $semestre_label[] = $sem->getTexto();
    }
    $semestre_label = implode(", ",$semestre_label);


    $array_regiones = explode(",",$request->codsRegiones);
    $regiones_filtro = Departamento::whereIn("codDepartamento",$array_regiones)->get();
    $regiones_label = [];
    foreach ($regiones_filtro as $dep) {
      $regiones_label[] = $dep->nombre;
    }
    $regiones_label = implode(", ",$regiones_label);


    $array_usuarios = explode(",",$request->codsUsuarios);
    $usuarios_filtro = Empleado::whereIn("codEmpleado",$array_usuarios)->get();
    $empleados_label = [];
    foreach ($usuarios_filtro as $empleado) {
      $empleados_label[] = $empleado->getNombreCompleto();
    }
    $empleados_label = implode(", ",$empleados_label);


    

    $data_compactada = compact('listaRelaciones','descargarExcel','indicador','semestre_label','regiones_label','empleados_label');

    switch ($indicador->getCodigo()) {
      case '1.1':
        return static::GetReporteIndicador11($data_compactada);
      case '1.2':
        return static::GetReporteIndicador12($data_compactada);
      case '2.1':
        return static::GetReporteIndicador21($data_compactada);
      case '2.2':
        return static::GetReporteIndicador22($data_compactada);
      case '3.1':
        return static::GetReporteIndicador31($data_compactada);
      case '3.2':
        return static::GetReporteIndicador32($data_compactada);
      default:
        # code...
        break;
    }
     
  }
  

  private static function GetReporteIndicador11($data_compactada){
    return view('PPM.Indicador.Reportes.Rep_VerTabla11',$data_compactada);
  }
  private static function GetReporteIndicador12($data_compactada){
    return view('PPM.Indicador.Reportes.Rep_VerTabla12',$data_compactada);
  }
  private static function GetReporteIndicador21($data_compactada){
    return view('PPM.Indicador.Reportes.Rep_VerTabla21',$data_compactada);
  }
  private static function GetReporteIndicador22($data_compactada){
    return view('PPM.Indicador.Reportes.Rep_VerTabla22',$data_compactada);
  }
  private static function GetReporteIndicador32($data_compactada){
    return view('PPM.Indicador.Reportes.Rep_VerTabla32',$data_compactada);
  }
  private static function GetReporteIndicador31($data_compactada){
    return view('PPM.Indicador.Reportes.Rep_VerTabla31',$data_compactada);
  }
  
  

  private static function StringToBooleanInt($string) : int{
    return $string == "true" ? 1 : 0;
  }

  public function GuardarIndicadores11(Request $request){
    
    try {
      db::beginTransaction();

      $relaciones = $request->relaciones;

      foreach ($relaciones as $data) {
        $relacion = PPM_RelacionPersonaSemestre::findOrFail($data['codRelacion']);

         
        $relacion->ind11_realizo_actividad_incidencia = static::StringToBooleanInt($data['ind11_realizo_actividad_incidencia']);
        $relacion->ind11_descripcion_actividad = $data['ind11_descripcion_actividad'];
        $relacion->ind11_descripcion_resultado = $data['ind11_descripcion_resultado'];
        $relacion->save();
        
      }
      db::commit();
      return RespuestaAPI::respuestaOk("Se guardaron los indicadores correctamente");
      
    } catch (\Throwable $th) {
      db::rollBack();

    }
  }

  public function GuardarIndicadores12(Request $request){
     
    try {
      db::beginTransaction();

      $relaciones = $request->relaciones;

      foreach ($relaciones as $data) {
        $relacion = PPM_RelacionPersonaSemestre::findOrFail($data['codRelacion']);

        $relacion->ind12_temas_capacitacion = $data['ind12_temas_capacitacion'];
        $relacion->save();        
      }

       
      db::commit();
      return RespuestaAPI::respuestaOk("Se guardaron los indicadores correctamente");

    } catch (\Throwable $th) {
      db::rollBack();
    }
  }

  public function GuardarIndicadores21(Request $request){
    
    try {
      db::beginTransaction();
      
      $relaciones = $request->relaciones;

      foreach ($relaciones as $data) {
        $relacion = PPM_RelacionPersonaSemestre::findOrFail($data['codRelacion']);

         
        $relacion->ind21_realizaron_mecanismos = static::StringToBooleanInt($data['ind21_realizaron_mecanismos']);
        $relacion->ind21_descripcion_mecanismos = $data['ind21_descripcion_mecanismos'];
        $relacion->ind21_estado_implementacion = $data['ind21_estado_implementacion'];
        $relacion->ind21_beneficiarios = $data['ind21_beneficiarios'];
        
        $relacion->save();
        
      }
      db::commit();
      return RespuestaAPI::respuestaOk("Se guardaron los indicadores correctamente");
      
    } catch (\Throwable $th) {
      db::rollBack();

    }
  }


  public function GuardarIndicadores22(Request $request){
    
    try {
      db::beginTransaction();
      
      $relaciones = $request->relaciones;

      foreach ($relaciones as $data) {
        $relacion = PPM_RelacionPersonaSemestre::findOrFail($data['codRelacion']);

        
        $relacion->ind22_realizo_accion_id = $data['ind22_realizo_accion_id'];
        $relacion->ind22_descripcion_accion = $data['ind22_descripcion_accion'];
        $relacion->save();
        
      }
      db::commit();
      return RespuestaAPI::respuestaOk("Se guardaron los indicadores correctamente");
      
    } catch (\Throwable $th) {
      throw $th;
      db::rollBack();

    }
  }


  public function GuardarIndicadores32(Request $request){
    
    try {
      db::beginTransaction();
      
      $relaciones = $request->relaciones;

      foreach ($relaciones as $data) {
        $relacion = PPM_RelacionPersonaSemestre::findOrFail($data['codRelacion']);

        $relacion->ind32_tiene_manejo_registros = static::StringToBooleanInt($data['ind32_tiene_manejo_registros']);

        $relacion->ind32_tiempo_cuidado = $data['ind32_tiempo_cuidado'];
        $relacion->ind32_tiempo_remunerado = $data['ind32_tiempo_remunerado'];
        $relacion->ind32_actividad_economica = $data['ind32_actividad_economica'];
        $relacion->ind32_inversiones = $data['ind32_inversiones'];
        $relacion->ind32_manera_registros = $data['ind32_manera_registros'];
        
        $relacion->save();
        
      }
      db::commit();
      return RespuestaAPI::respuestaOk("Se guardaron los indicadores correctamente");
      
    } catch (\Throwable $th) {
      db::rollBack();

    }
  }


  public function GetModalFichaGestionEmpresarial($codRelacion){
    
    
    $relacion = PPM_RelacionOrganizacionSemestre::findOrFail($codRelacion);
    $organizacion = $relacion->getOrganizacion();
    $segmentos = PPM_FGE_Segmento::All();

    return view('PPM.Indicador.Invocables.Inv_ModalFGE',compact('relacion','segmentos','organizacion'));
  }

  public function ActualizarFichaGestionEmpresarial(Request $request){

    try {
      db::beginTransaction();
      
      $relacion = PPM_RelacionOrganizacionSemestre::findOrFail($request->codRelacion);
      $items_data = $request->ListaItems;

      //recorremos cada pregunta
      foreach ($items_data as $item_data) {
        $item = PPM_FGE_Item::findOrFail($item_data['codItem']);

        $existe = PPM_FGE_Marcacion::existeRelacionItem($relacion,$item);
        if($existe){
          $marcacion = PPM_FGE_Marcacion::getByRelacionItem($relacion,$item);
          
        }else{
          $marcacion = new PPM_FGE_Marcacion();
          $marcacion->codRelacion = $relacion->codRelacion;
          $marcacion->codItem = $item_data['codItem'];
        }

        $marcacion->codOptionSeleccionada = $item_data['codOptionSeleccionada'];
        $marcacion->save();
        
      }

      $relacion->nivel_gestion_empresarial = $relacion->calcularNivelGestionEmpresarial();
      $relacion->save();

      $valor = number_format($relacion->nivel_gestion_empresarial,2);

      db::commit();
      return RespuestaAPI::respuestaOk("Se guardó la ficha de gestión empresarial correctamente. El nuevo valor es: $valor");
    } catch (\Throwable $th) {
      db::rollBack();
      throw $th;
      return RespuestaAPI::respuestaError("ERROR");
      
    }

  }


  public function ExportarFichasGestionEmpresarial(Request $request){
     
    $array_codsRelacion = explode(",",$request->array_codsRelacion);
    $listaRelaciones = PPM_RelacionOrganizacionSemestre::whereIn('codRelacion',$array_codsRelacion)->get();
    $listaSegmentos = PPM_FGE_Segmento::All();

    $descargarExcel = ParametroSistema::getParametroSistema("activarReportesAExcel")->valor;
    $descargarExcel = ($descargarExcel == 'true');

    $nombre_archivo = "Reporte Fichas gestion empresarial.xls";

    return view('PPM.Indicador.Reportes.Rep_ExportarFGE',compact('listaRelaciones','descargarExcel','listaSegmentos','nombre_archivo'));
  }
}
