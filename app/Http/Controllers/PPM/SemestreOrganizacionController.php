<?php

namespace App\Http\Controllers\PPM;

use App\Configuracion;
use App\Debug;
use App\Departamento;
use App\Empleado;
use App\ErrorHistorial;
use App\Fecha;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PersonaPoblacionController;
use App\Models\CITE\RelacionUsuarioUnidad;
use Illuminate\Http\Request;

use App\Models\CITE\UnidadProductiva as UnidadProductiva;
use App\Models\CITE\UsuarioCite;
use App\Models\PPM\PPM_ActividadEconomica;
use App\Models\PPM\PPM_AsistenciaDetalleprod;
use App\Models\PPM\PPM_DetalleProducto;
use App\Models\PPM\PPM_Importable;
use App\Models\PPM\PPM_Organizacion;
use App\Models\PPM\PPM_Persona;
use App\Models\PPM\PPM_Inscripcion;
use App\Models\PPM\PPM_RelacionOrganizacionSemestre;
use App\Models\PPM\PPM_Sexo;
use App\Models\PPM\PPM_Sincronizador;
use App\Models\PPM\PPM_Producto;
use App\Models\PPM\PPM_TipoDocumento;
use App\Models\PPM\PPM_TipoOrganizacion;
use App\Models\PPM\PPM_TipoProducto;
use App\Models\PPM\PPM_UnidadMedida;
use App\ParametroSistema;
use App\RespuestaAPI;
use App\TipoDocumento;
use App\UI\UIFiltros;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;


class SemestreOrganizacionController extends Controller
{


  



  public function GuardarProductosDetalle(Request $request){
    
    try{
      db::beginTransaction();
      $relacion = PPM_RelacionOrganizacionSemestre::findOrFail($request->codRelacion);

      $lista_detalles_front = json_decode($request->lista_detalles_front);
      $lista_ids_detalles_eliminados = json_decode($request->lista_ids_detalles_eliminados);

      foreach ($lista_detalles_front as $detalle_front) {
        
    
        
        $id = $detalle_front->codDetalleProducto;
        
        if(str_contains($id,"new")){ //nuevo
          $detalle_producto = new PPM_DetalleProducto();

          $detalle_producto->codRelacion = $relacion->codRelacion;
          $detalle_producto->codTipoProducto = PPM_TipoProducto::getCodigoDeProducto();
        }else{ //existente
          $detalle_producto = PPM_DetalleProducto::findOrFail($id);
        }
        $detalle_producto->codProducto = $request->codProductoSeleccionadoEnviar;
        
 
        $detalle_producto->NUP_cantidad = $detalle_front->NUP_cantidad;
        $detalle_producto->PTUP_cantidad = $detalle_front->PTUP_cantidad;
        $detalle_producto->PTC_cantidad = $detalle_front->PTC_cantidad;
        $detalle_producto->pventa_unidad = $detalle_front->pventa_unidad;
        $detalle_producto->costo_prod_unidad = $detalle_front->costo_prod_unidad;
        $detalle_producto->ingreso_neto22 = $detalle_front->ingreso_neto22;
        $detalle_producto->RZ_rendimiento = $detalle_front->RZ_rendimiento;
        $detalle_producto->RS_rendimiento = $detalle_front->RS_rendimiento;
        $detalle_producto->RZ_fuente = $detalle_front->RZ_fuente;
        
        
        $detalle_producto->NUP_unidad_medida = $detalle_front->NUP_unidad_medida;
        $detalle_producto->RZ_unidad_medida = $detalle_front->RZ_unidad_medida;
        $detalle_producto->RS_unidad_medida = $detalle_front->RS_unidad_medida;
        
        $detalle_producto->ingreso_semestre = $detalle_front->PTC_cantidad*($detalle_producto->pventa_unidad - $detalle_producto->costo_prod_unidad);
        
        $detalle_producto->PTUP_codUnidadMedida = $detalle_front->PTUP_codUnidadMedida;
        $detalle_producto->PTC_codUnidadMedida = $detalle_front->PTUP_codUnidadMedida;
        
        
        $detalle_producto->save();

      }

      foreach ($lista_ids_detalles_eliminados as $id_detalle_eliminado) {
        $detalle_eliminar = PPM_DetalleProducto::findOrFail($id_detalle_eliminado);
        $detalle_eliminar->delete();
      }

      $msj = "Se añadieron los nuevos productos.";
      db::commit();
      
      return redirect()->route('PPM.SemestreOrganizacion.VerAñadirProductos',$request->codRelacion)->with('datos_ok',$msj)->with('mostrar_confirmacion',1);;

    } catch (\Throwable $th) {

      DB::rollBack();
      Debug::mensajeError("OrganizacionController GuardarProductosDetalle",$th);
      $codErrorHistorial=ErrorHistorial::registrarError($th,app('request')->route()->getAction(),json_encode($request));
      $msj_error = Configuracion::getMensajeError($codErrorHistorial);

      return redirect()->route('PPM.SemestreOrganizacion.VerAñadirProductos',$request->codRelacion)->with('datos_error',$msj_error);

      

    }

  }

  public function ImportarArchivoCultivoCadena(Request $request){
    
    try {      
      db::beginTransaction();

      $relacion = PPM_RelacionOrganizacionSemestre::findOrFail($request->codRelacion);
      $organizacion = $relacion->getOrganizacion();
      
      $hay_archivos = !is_null($request->nombresArchivos) && $request->nombresArchivos!="[]";
      if(!$hay_archivos){
        return redirect()->route('PPM.SemestreOrganizacion.VerAñadirCultivoCadena',$request->codRelacion)->with('datos_error',"No se adjuntaron archivos");
      }

      $nombre_archivo = $request->nombresArchivos;
       
      if(!str_contains($nombre_archivo,".xlsx")){
        return redirect()->route('PPM.SemestreOrganizacion.VerAñadirCultivoCadena',$request->codRelacion)->with('datos_error',"El archivo a importar debe ser formato .xlsx");
      }

      $archivo = null;
      foreach ($request->file('filenames') as $archivo_iteracion){
        $archivo = $archivo_iteracion;
      }
    

      $array = Excel::toArray(new PPM_Importable, $archivo);
      $final = PPM_Importable::ProcesarArray($array);
      $msjs_errores = PPM_Importable::ValidarArray($final);

      if(count($msjs_errores) != 0){
        $msj = implode(",",$msjs_errores);
        return redirect()->route('PPM.SemestreOrganizacion.VerAñadirCultivoCadena',$request->codRelacion)->with('datos_error',"Error en el formato de importación: $msj");
      }

 
      $dnis_personas_nuevas = [];
      $dnis_personas_existentes = [];
      foreach ($final as $elemento) {
        
        $detalle_producto = new PPM_DetalleProducto();

        $detalle_producto->codRelacion = $relacion->codRelacion;
        $detalle_producto->codTipoProducto = PPM_TipoProducto::getCodigoDeCultivoCadena();

        $detalle_producto->codProducto = $request->codProductoSeleccionado;
        $detalle_producto->edad_cultivo = $request->edad_cultivo;

        $detalle_producto->PTC_cantidad = $elemento['PTC_cantidad'];
        
        $detalle_producto->pventa_unidad = $elemento['pventa_unidad'];
        $detalle_producto->costo_prod_unidad = $elemento['costo_prod_unidad'];
        $detalle_producto->ingreso_neto22 = $elemento['ingreso_neto22'];
        $detalle_producto->RZ_rendimiento = $elemento['RZ_rendimiento'];
        $detalle_producto->RZ_unidad_medida = $elemento['RZ_unidad_medida'];
        $detalle_producto->RZ_fuente = $elemento['RZ_fuente'];
        $detalle_producto->RS_rendimiento = $elemento['RS_rendimiento'];
        $detalle_producto->RS_unidad_medida = $elemento['RS_unidad_medida'];
        $detalle_producto->NUPP_numero = $elemento['NUPP_numero'];
        $detalle_producto->PTP_cantidad = $elemento['PTP_cantidad'];

        $detalle_producto->PTP_codUnidadMedida = PPM_UnidadMedida::getCodByNombre($elemento['PTP_unidad_medida_escrita']);
        $detalle_producto->PTC_codUnidadMedida = PPM_UnidadMedida::getCodByNombre($elemento['PTC_unidad_medida_escrita']);
        $detalle_producto->NUPP_codUnidadMedida = PPM_UnidadMedida::getCodByNombre($elemento['NUPP_unidad_medida_escrita']);
          
        $detalle_producto->ingreso_semestre = $detalle_producto->PTC_cantidad*($detalle_producto->pventa_unidad - $detalle_producto->costo_prod_unidad);
    
        //relacion con persona ppm
        $dni_productor = $elemento['dni'];
        

        if(PPM_Persona::existePersona($dni_productor)){
          $persona = PPM_Persona::findByDNI($dni_productor);
          $dnis_personas_existentes[] = $dni_productor;
       
        }else{
          $persona = new PPM_Persona();
          $persona->dni = $dni_productor;
          $persona->nombres = $elemento['nombres'];
          $persona->apellido_paterno = $elemento['apellido_paterno'];
          $persona->apellido_materno = $elemento['apellido_materno'];
          $persona->codEmpleadoCreador = Empleado::getEmpleadoLogeado()->getId();
          $persona->fechaHoraCreacion = Carbon::now();

          $persona->data_comprobada_reniec = 0;
          $persona->necesita_comprobacion = 1;
          
          $persona->updateNombreBusqueda();
          $persona->save();
          $dnis_personas_nuevas[] = $dni_productor;
       
        }

        $existe_inscripcion = PPM_Inscripcion::existeRelacion($organizacion->codOrganizacion,$persona->codPersona);
        if(!$existe_inscripcion){
          $inscripcion = new PPM_Inscripcion();
          $inscripcion->codPersona = $persona->codPersona;
          $inscripcion->codOrganizacion = $organizacion->codOrganizacion;
          $inscripcion->cargo = "";
          $inscripcion->save();
        }
        $detalle_producto->codPersona = $persona->codPersona;
        
        $detalle_producto->save();
      }
      
      
      $msj_personas_nuevas = "";
      if(count($dnis_personas_nuevas) > 0 ){
        $personas_nuevas = implode(",",$dnis_personas_nuevas);
        $msj_personas_nuevas = "Los siguientes productores fueron añadidos a nuestra base de datos: $personas_nuevas.";
      }

      $msj_personas_existentes = "";
      if(count($dnis_personas_existentes) > 0 ){
        $personas_existentes = implode(",",$dnis_personas_existentes);
        $msj_personas_existentes = "Los siguientes productores ya estaban en nuestra base de datos: $personas_existentes.";
      }
      
      
     
      db::commit();
      
      return redirect()->route('PPM.SemestreOrganizacion.VerAñadirCultivoCadena',$request->codRelacion)
      ->with('datos_ok',"Se importaron exitosamente los datos del excel. $msj_personas_nuevas $msj_personas_existentes")->with('mostrar_confirmacion',1);

      
    } catch (\Throwable $th) {
      db::rollBack();
      Debug::mensajeError("SemestreOrganizacionController",$th);
      $codErrorHistorial=ErrorHistorial::registrarError($th,app('request')->route()->getAction(),json_encode($request));
      $msj_error = Configuracion::getMensajeError($codErrorHistorial);
      return redirect()->route('PPM.SemestreOrganizacion.VerAñadirCultivoCadena',$request->codRelacion)->with('datos_error',$msj_error);

    }

    

  }


  /* vista de añadir por el crud complejo de JS */
  public function VerAñadirProductos($codRelacionOrganizacionSemestre, Request $request){
 
    $codProductoSeleccionado = $request->codProductoSeleccionado;
    if($codProductoSeleccionado){
      session(['abrir_modal_inicial' => 1]);
    }
    
    $relacion = PPM_RelacionOrganizacionSemestre::findOrFail($codRelacionOrganizacionSemestre);
    $organizacion = $relacion->getOrganizacion();
    $semestre = $relacion->getSemestre();

    $listaTipoProducto = PPM_TipoProducto::All();
    
    $listaProductos = PPM_Producto::getProductos_Producto();

    $codTipoProducto_Producto = PPM_TipoProducto::getCodigoDeProducto();
    $codTipoProducto_CultivoCadena = PPM_TipoProducto::getCodigoDeCultivoCadena();

    $listaUnidadesMedida = PPM_UnidadMedida::All();
    $listaDetalleProducto = PPM_DetalleProducto::where('codRelacion',$relacion->getId())->where('codTipoProducto',$codTipoProducto_Producto)->get();

   
    return view('PPM.Indicador.AñadirProductos',compact('codProductoSeleccionado','listaTipoProducto','listaDetalleProducto','listaUnidadesMedida','relacion','organizacion','semestre','listaProductos','codTipoProducto_Producto','codTipoProducto_CultivoCadena'));
  

  }


  /* vista de importar excels */
  public function VerAñadirCultivoCadena($codRelacionOrganizacionSemestre, Request $request){
    $codProductoSeleccionado = $request->codProductoSeleccionado;
    if($codProductoSeleccionado){
      session(['abrir_modal_inicial' => 1]);
    }
    
    $relacion = PPM_RelacionOrganizacionSemestre::findOrFail($codRelacionOrganizacionSemestre);
    $organizacion = $relacion->getOrganizacion();
    $semestre = $relacion->getSemestre();

    $listaTipoProducto = PPM_TipoProducto::All();
    
    $listaProductos = PPM_Producto::getProductos_CultivoCadena();

    $codTipoProducto_Producto = PPM_TipoProducto::getCodigoDeProducto();
    $codTipoProducto_CultivoCadena = PPM_TipoProducto::getCodigoDeCultivoCadena();

    $listaUnidadesMedida = PPM_UnidadMedida::All();
    $listaDetalleProducto = PPM_DetalleProducto::where('codRelacion',$relacion->codRelacion)->where('codTipoProducto',$codTipoProducto_CultivoCadena)->get();
 

    return view('PPM.Indicador.ImportarCultivosCadena',compact('codProductoSeleccionado','listaTipoProducto','listaDetalleProducto','listaUnidadesMedida','relacion','organizacion','semestre','listaProductos','codTipoProducto_Producto','codTipoProducto_CultivoCadena'));
  
  }


  public function InvModalDetalleProducto($codDetalleProducto){
    $detalle = PPM_DetalleProducto::findOrFail($codDetalleProducto);
    $listaUnidadesMedida = PPM_UnidadMedida::All();
    $codTipoProducto_Producto = PPM_TipoProducto::getCodigoDeProducto();
    if($detalle->codTipoProducto == $codTipoProducto_Producto){ //PRODUCTOS
      $productos = PPM_Producto::getProductos_Producto(); 
      return view('PPM.Indicador.Invocables.Inv_ModalProducto',compact('detalle','productos','listaUnidadesMedida'));
    }else{ //CULTIVO CADENA
      $productos = PPM_Producto::getProductos_CultivoCadena();
      $persona = $detalle->getPersona();
      return view('PPM.Indicador.Invocables.Inv_ModalCultivoCadena',compact('detalle','productos','listaUnidadesMedida','persona'));
    }

    
    
  }

  public function ActualizarDetalleProducto_producto(Request $request){

    try {
      DB::beginTransaction();
      $detalle = PPM_DetalleProducto::findOrFail($request->codDetalleProducto);
      

      $detalle->codProducto = $request->codProducto;
      $detalle->pventa_unidad = $request->pventa_unidad;
      $detalle->costo_prod_unidad = $request->costo_prod_unidad;
      $detalle->ingreso_neto22 = $request->ingreso_neto22;
      $detalle->NUP_cantidad = $request->NUP_cantidad;
      $detalle->NUP_unidad_medida = $request->NUP_unidad_medida;
      $detalle->PTUP_cantidad = $request->PTUP_cantidad;
      $detalle->PTUP_codUnidadMedida = $request->PTUP_codUnidadMedida;
      $detalle->PTC_cantidad = $request->PTC_cantidad;
      $detalle->PTC_codUnidadMedida = $request->PTUP_codUnidadMedida;
      $detalle->RZ_rendimiento = $request->RZ_rendimiento;
      $detalle->RZ_unidad_medida = $request->RZ_unidad_medida;
      $detalle->RZ_fuente = $request->RZ_fuente;
      $detalle->ingreso_semestre = $request->ingreso_semestre;
      $detalle->RS_rendimiento = $request->RS_rendimiento;
      $detalle->RS_unidad_medida = $request->RS_unidad_medida;
      $detalle->save();

      DB::commit();
      
      return redirect()->route('PPM.SemestreOrganizacion.VerAñadirProductos',$detalle->codRelacion)->with('datos_ok',"Se actualizó el producto exitosamente");

    } catch (\Throwable $th) {
      DB::rollBack();
      throw $th;
      return redirect()->route('PPM.SemestreOrganizacion.VerAñadirProductos',$detalle->codRelacion)->with('datos_error',"Hubo un error");

    }

  }


  public function ActualizarDetalleProducto_cultivocadena(Request $request){

    try {
      DB::beginTransaction();
      $detalle = PPM_DetalleProducto::findOrFail($request->codDetalleProducto);
      
      $detalle->PTP_codUnidadMedida = $request->PTP_codUnidadMedida;
      $detalle->NUPP_codUnidadMedida = $request->NUPP_codUnidadMedida;
      $detalle->PTC_codUnidadMedida = $request->PTP_codUnidadMedida;
      
      
      $detalle->codProducto = $request->codProducto;
      $detalle->edad_cultivo = $request->edad_cultivo_modal;
      

      $detalle->ingreso_neto22 = $request->ingreso_neto22;
      $detalle->NUPP_numero = $request->NUPP_numero;
      $detalle->PTP_cantidad = $request->PTP_cantidad;
      $detalle->PTC_cantidad = $request->PTC_cantidad;
      $detalle->pventa_unidad = $request->pventa_unidad;
      $detalle->costo_prod_unidad = $request->costo_prod_unidad;
      $detalle->RZ_rendimiento = $request->RZ_rendimiento;
      $detalle->ingreso_semestre = $request->ingreso_semestre;
      $detalle->RS_rendimiento = $request->RS_rendimiento;
      $detalle->RS_unidad_medida = $request->RS_unidad_medida;
      $detalle->RZ_unidad_medida = $request->RZ_unidad_medida;
      $detalle->RZ_fuente = $request->RZ_fuente;

      $detalle->save();

      DB::commit();
      
      return redirect()->route('PPM.SemestreOrganizacion.VerAñadirCultivoCadena',$detalle->codRelacion)->with('datos_ok',"Se actualizó el producto exitosamente");

    } catch (\Throwable $th) {
      DB::rollBack();
      throw $th;
      return redirect()->route('PPM.SemestreOrganizacion.VerAñadirCultivoCadena',$detalle->codRelacion)->with('datos_error',"Hubo un error");

    }

  }

  public function EliminarDetalleProducto($codDetalleProducto){
    
    try {
      DB::beginTransaction();
      $codTipoProducto_Producto = PPM_TipoProducto::getCodigoDeProducto();

      $detalle = PPM_DetalleProducto::findOrFail($codDetalleProducto);
      if($detalle->codTipoProducto == $codTipoProducto_Producto){
        $ruta = 'PPM.SemestreOrganizacion.VerAñadirProductos';
      }else{
        $ruta = 'PPM.SemestreOrganizacion.VerAñadirCultivoCadena';
      }
      
      $codRelacion = $detalle->codRelacion;

      //borramos las asistencias
      PPM_AsistenciaDetalleprod::where('codDetalleProducto',$codDetalleProducto)->delete();

      $detalle->delete();

      DB::commit();

      return redirect()->route($ruta,$codRelacion)->with('datos_ok',"Se eliminó el producto exitosamente");
    } catch (\Throwable $th) {
      //throw $th;
      DB::rollBack();
      return redirect()->route($ruta,$codRelacion)->with('datos_error',"Hubo un error");

    }
    

  }
  
   

  public function GuardarAsistenciaDetalleProd(Request $request){
    try {
      db::beginTransaction();
      $nuevo_msj = "";
      
      $persona =PPM_Persona::findOrFail($request->codPersona);
      $detalle_producto = PPM_DetalleProducto::findOrFail($request->codDetalleProducto);
      
      $ya_existe = PPM_AsistenciaDetalleprod::VerificarAsistencia($request->codPersona,$request->codDetalleProducto);
      
      
      if($request->new_value_asistencia == "true"){ //el nuevo valor es que sí
        
        if($ya_existe){
          //no hacemos nada
        }else{
          // la creamos
          $nueva = new PPM_AsistenciaDetalleprod();
          $nueva->codPersona = $request->codPersona;
          $nueva->codDetalleProducto = $request->codDetalleProducto;
          $nueva->save();

        }
        $msj = "AÑADIÓ";
      }else{ //nuevo valor es que NO
        
        if($ya_existe){ //la borramos
          $asistencia = PPM_AsistenciaDetalleprod::GetAsistenciaDetalle($request->codPersona,$request->codDetalleProducto);
          $asistencia->delete();
        }else{ 
          //no hacemos nada
        }
        
        $msj = "ELIMINÓ";
      }


      db::commit();
      
      return RespuestaAPI::respuestaOk("Se $msj la asistencia de ".$persona->getNombreCompleto());

    } catch (\Throwable $th) {
      db::rollBack();
      Debug::mensajeError("OrganizacionController ",$th);
      return RespuestaAPI::respuestaError("Ocurrió un error");

    }

  }

  public function InvModalVerNivelProductivo($codRelacion){
    $relacion = PPM_RelacionOrganizacionSemestre::findOrFail($codRelacion);
    $organizacion = $relacion->getOrganizacion();
    $semestre = $relacion->getSemestre();
    $listaProductos = PPM_Producto::All();
    $listaTipoProducto = PPM_TipoProducto::All();

    $codTipoProducto_Producto = PPM_TipoProducto::getCodigoDeProducto();
    $codTipoProducto_CultivoCadena = PPM_TipoProducto::getCodigoDeCultivoCadena();


    return view('PPM.Indicador.ModalVerNivelProductivo',compact('relacion','organizacion','semestre','listaProductos','listaTipoProducto','codTipoProducto_Producto','codTipoProducto_CultivoCadena'));

  }



  public function ProcesarPersonasReniecPendientes(){
    $cantidad_limite = ParametroSistema::getParametroSistema("cronjob_limite_usuarios_corrida")->valor;
    $lista = PPM_Persona::where('data_comprobada_reniec',0)->where('necesita_comprobacion',1)->limit($cantidad_limite)->get();
    
    
    $fecha_actual = Carbon::now();
    $cant = count($lista);
    if($cant == 0){
      Debug::CronLogMessage("-- ProcesarPersonasReniecPendientes ".$fecha_actual." NO HAY PENDIENTES DE PROCESAR");
      return "No hay pendientes de procesar";
    }
    
    Debug::CronLogMessage("-- Iniciando ProcesarPersonasReniecPendientes ".$fecha_actual."  se procesarán $cant personas");

   
    foreach ($lista as $persona) {
      Debug::CronLogMessage("Procesando persona de DNI ".$persona->dni);

      try {
        $respuesta_str = PersonaPoblacionController::ConsultarAPISunatDNI($persona->dni);
        Debug::CronLogMessage("Respuesta: ".$respuesta_str);

        $respuesta = json_decode($respuesta_str);
        $ok = $respuesta->ok;
        if($ok == "1"){

          $datos = $respuesta->datos;
          $persona->nombres = $datos->nombres;
          $persona->apellido_paterno = $datos->apellidoPaterno;
          $persona->apellido_materno = $datos->apellidoMaterno;
          $persona->data_comprobada_reniec = 1;
          $persona->save();

        }else{
          
        }
        Debug::CronLogMessage("Procesamiento correcto");
        
      } catch (\Throwable $th) {
        Debug::CronLogMessage("Procesamiento incorrecto, hubo el error siguiente");
        Debug::CronLogMessage($th);
      }
      
    
    }

    $fecha_actual = Carbon::now();
    Debug::CronLogMessage("-- Terminó ProcesarPersonasReniecPendientes ".$fecha_actual);
    
    return "OK";
  }

}