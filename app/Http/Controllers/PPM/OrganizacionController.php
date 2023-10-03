<?php

namespace App\Http\Controllers\PPM;

use App\Configuracion;
use App\Debug;
use App\Departamento;
use App\Empleado;
use App\ErrorHistorial;
use App\Fecha;
use App\Http\Controllers\Controller;
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
use App\RespuestaAPI;
use App\TipoDocumento;
use App\UI\UIFiltros;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class OrganizacionController extends Controller
{
    const PAGINATION = '30';

    public function Listar(Request $request){

      $listaOrganizaciones = PPM_Organizacion::query();
      $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaOrganizaciones,$request->getQueryString());
      $listaOrganizaciones = UIFiltros::buildQuery($listaOrganizaciones,$request->getQueryString());
      $filtros_usados = UIFiltros::getQueryValues($listaOrganizaciones,$request->getQueryString());
      $listaOrganizaciones = $listaOrganizaciones->orderBy('codOrganizacion','DESC')->paginate(static::PAGINATION);

      $listaActividades = PPM_ActividadEconomica::All();
      $todasLasOrganizaciones = PPM_Organizacion::TodasParaSelect();
      $listaDepartamentos = Departamento::All();
      $listaTiposOrganizacion = PPM_TipoOrganizacion::All();

      return view('PPM.Organizacion.ListarOrganizaciones',compact('listaOrganizaciones','listaActividades','todasLasOrganizaciones','listaDepartamentos','filtros_usados','filtros_usados_paginacion','listaTiposOrganizacion'));

    }
    public function Crear(){
      
      $listaTipoOrganizacion = PPM_TipoOrganizacion::All();
      $listaTipoDocumento = PPM_TipoDocumento::All();
      $listaActividadEconomica = PPM_ActividadEconomica::All();

      $listaUnidadesProductivas = UnidadProductiva::getTodasParaFront();

      return view('PPM.Organizacion.CrearOrganizacion',compact('listaTipoOrganizacion','listaTipoDocumento','listaActividadEconomica','listaUnidadesProductivas'));
    }
    public function Editar($id){
      $organizacion = PPM_Organizacion::findOrFail($id);

      $listaTipoOrganizacion = PPM_TipoOrganizacion::All();
      $listaTipoDocumento = PPM_TipoDocumento::All();
      $listaActividadEconomica = PPM_ActividadEconomica::All();
      $tipo_doc = $organizacion->getTipoDocumento();

      $listaUnidadesProductivas = UnidadProductiva::getTodasParaFront();
      
      $relaciones_personas_asociadas = $organizacion->getRelacionesPersonasAsociadas();
      $relaciones_org_semestre = PPM_RelacionOrganizacionSemestre::where('codOrganizacion',$id)->get();

      $listaSexos = PPM_Sexo::getSexosParaSelect();
      $listaActividades = $organizacion->getEjecuciones();

      return view('PPM.Organizacion.EditarOrganizacion',compact('relaciones_personas_asociadas','organizacion','listaTipoOrganizacion','listaTipoDocumento','listaActividadEconomica','tipo_doc','listaUnidadesProductivas','listaActividades','listaSexos','relaciones_org_semestre'));
    }


    public function Guardar(Request $request){      
      try {
        DB::beginTransaction();

        if($request->ruc){
          $cant = PPM_Organizacion::where('ruc',$request->ruc)->count();
          if($cant != 0){
            return redirect()->route('PPM.Organizacion.Crear')
                ->with('datos_error',"ERROR: La organización con RUC ".$request->ruc." ya está registrada");
          }
        }

        $org = new PPM_Organizacion();

        $org->activar_enlace_cite = 0;
        
        $org->procesarRequest($request);
        $org->save();
        
        DB::commit();

        return redirect()->route('PPM.Organizacion.Editar',$org->getId())->with('datos_ok',"Organización creada exitosamente");
      } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;
      }
    }
    public function Actualizar(Request $request){
      try {
        DB::beginTransaction();

 
        $org = PPM_Organizacion::findOrFail($request->codOrganizacion);

        if($request->ruc){
           
          if($org->ruc != $request->ruc){
             
            $cant = PPM_Organizacion::where('ruc',$request->ruc)->count();
            if($cant != 0){
              return redirect()->route('PPM.Organizacion.Editar',$request->codOrganizacion)
                  ->with('datos_error',"ERROR: La organización con RUC ".$request->ruc." ya está registrada");
            }
          }
        }
          
        
        $org->procesarRequest($request);
        $org->save();
        
        DB::commit();

        return redirect()->route('PPM.Organizacion.Editar',$org->getId())->with('datos_ok',"Organización editada exitosamente");
      } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;
      }

    }
    public function Eliminar(Request $request){

    }

    
    public function Ver($id){
      $organizacion = PPM_Organizacion::findOrFail($id);

      $listaTipoOrganizacion = PPM_TipoOrganizacion::All();
      $listaTipoDocumento = PPM_TipoDocumento::All();
      $listaActividadEconomica = PPM_ActividadEconomica::All();
      $tipo_doc = $organizacion->getTipoDocumento();

      $listaUnidadesProductivas = UnidadProductiva::getTodasParaFront();
      

      $listaSexos = PPM_Sexo::getSexosParaSelect();
      $listaActividades = $organizacion->getEjecuciones();

      return view('PPM.Organizacion.VerOrganizacion',compact('organizacion','listaTipoOrganizacion','listaTipoDocumento','listaActividadEconomica','tipo_doc','listaUnidadesProductivas','listaActividades','listaSexos'));
    }




    function AñadirGrupoDeSocios(Request $request){
      
      
      try {

          DB::beginTransaction();

          $organizacion = PPM_Organizacion::findOrFail($request->codOrganizacion);

          $listaPersonas = $request->listaPersonasAAgregar;
          foreach ($listaPersonas as $persona_data) {
              
              //buscamos al usuario por si ya está en la bd
              $listaPersonasDNI = PPM_Persona::where('dni',$persona_data['dni'])->get();
              
              if(count($listaPersonasDNI)==0){ //NUEVO USUARIO
                  
                  
                  $persona_model = new PPM_Persona();

                  $persona_model->fechaHoraCreacion = Carbon::now();
                  $persona_model->codEmpleadoCreador =Empleado::getEmpleadoLogeado()->getId();
                  $persona_model->updateNombreBusqueda();

                  $persona_model->data_comprobada_reniec = 0;
                  $persona_model->necesita_comprobacion = 0;
                  
                   
              }else{//USUARIO YA EXISTE , si se le mandan valores no vacios en los campos opcionales, remplazará a los antiguos
                  $persona_model = $listaPersonasDNI[0];   
              }

              $persona_model->dni = $persona_data['dni'];
              $persona_model->nombres = mb_strtoupper($persona_data['nombres']);
              $persona_model->apellido_paterno = mb_strtoupper($persona_data['apellido_paterno']);
              $persona_model->apellido_materno = mb_strtoupper($persona_data['apellido_materno']);
              $persona_model->telefono = $persona_data['telefono'];
              $persona_model->correo = $persona_data['correo'];
              $persona_model->sexo = $persona_data['sexo']; 
              $persona_model->fecha_nacimiento = Fecha::formatoParaSQL($persona_data['fecha_nacimiento']);
              
              $persona_model->save();
                   

               
              
              //verificamos si la relacion no existe ya (de todas maneras esta validacion tambn se hace en frontend)
              if(!PPM_Inscripcion::existeRelacion($request->codOrganizacion,$persona_model->codPersona)){
                  $relacion = new PPM_Inscripcion();
                  $relacion->codOrganizacion = $request->codOrganizacion;
                  $relacion->codPersona = $persona_model->codPersona;
                  $relacion->cargo = $persona_data['cargo'];
                  $relacion->save();
              }

          }


          $msj_extra = "";
          $enlace_cite_activado = $organizacion->tieneEnlaceCite();
          if($enlace_cite_activado){
            $unidad_productiva = $organizacion->getUnidadProductivaEnlazada();
            $dnis_añadidos = PPM_Sincronizador::SincronizarSocios($organizacion,$unidad_productiva);
            $se_realizaron_cambios_sincronizacion = count($dnis_añadidos['dnis_añadidos_a_unidad']) > 0 || count($dnis_añadidos['dnis_añadidos_a_organizacion']);
            if($se_realizaron_cambios_sincronizacion){
              $msj_extra = "(y a la Unidad Productiva gracias al enlace)";
            }
          }


          DB::commit();
          return RespuestaAPI::respuestaOk("Los nuevos usuarios fueron añadidos exitosamente a la organización $msj_extra . <br> Recargando la página...");
      } catch (\Throwable $th) {

          DB::rollBack();
          Debug::mensajeError("OrganizacionController añadirGrupoUsuarios",$th);
          $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                           app('request')->route()->getAction(),
                                                           json_encode($request->toArray())
                                                          );
          return RespuestaAPI::respuestaError(Configuracion::getMensajeError($codErrorHistorial));
      }

  }

 

  public function EliminarRelacionPersonaOrganizacion($codRelacion){
    try {
      db::beginTransaction();
      $rela = PPM_Inscripcion::findOrFail($codRelacion);
      $persona = $rela->getPersona(); 
      $nombre = $persona->getNombreCompleto();
      $codOrganizacion = $rela->codOrganizacion;
      
      $organizacion = PPM_Organizacion::findOrFail($codOrganizacion);
      $enlace_cite_activado = $organizacion->tieneEnlaceCite();

      $msj_extra = "";
      if($enlace_cite_activado){
        $se_elimino_del_cite = $rela->eliminarSuscripcionCITE();
        if($se_elimino_del_cite){
          $msj_extra = " y de la unidad productiva (el enlace CITE está activado).";
        }
      }
      
      $rela->delete();


      db::commit();

      return redirect()->route('PPM.Organizacion.Editar',$codOrganizacion)
              ->with('datos_ok',"Se ha eliminado al usuario $nombre de la organización $msj_extra");

    } catch (\Throwable $th) {
        DB::rollBack();
        Debug::mensajeError("OrganizacionController EliminarRelacionPersonaOrganizacion",$th);
        $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                        app('request')->route()->getAction(),
                                                        $codRelacion
                                                        );
        return redirect()->route('PPM.Organizacion.Editar',$codOrganizacion)
        ->with('datos_error',Configuracion::getMensajeError($codErrorHistorial));

    }

  }


  public function SincronizarConCITE(Request $request){

    try{
      db::beginTransaction();
      $codOrganizacion = $request->codOrganizacion;

      $organizacion = PPM_Organizacion::findOrFail($codOrganizacion);
      $enlace_cite_activado = $organizacion->tieneEnlaceCite();

      if(!$enlace_cite_activado){
        return redirect()->route('PPM.Organizacion.Editar',$codOrganizacion)->with('datos_error',"ERROR: Para sincronizar la organización con su unidad productiva del CITE, se requiere tener activado el enlace");
      }

      $unidad_productiva = $organizacion->getUnidadProductivaEnlazada();

      $dnis_añadidos = PPM_Sincronizador::SincronizarSocios($organizacion,$unidad_productiva);
      $msj = PPM_Sincronizador::GetMsjAñadicionOrganizacion($dnis_añadidos);
      

      db::commit();
      
      return redirect()->route('PPM.Organizacion.Editar',$codOrganizacion)
                    ->with('datos_ok',$msj);
       
    } catch (\Throwable $th) {

      DB::rollBack();
      Debug::mensajeError("OrganizacionController SincronizarConCITE",$th);
      $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                      app('request')->route()->getAction(),
                                                      $codOrganizacion
                                                      );
      return redirect()->route('PPM.Organizacion.Editar',$codOrganizacion)
      ->with('datos_error',Configuracion::getMensajeError($codErrorHistorial));

    }


  }

  public function ActualizarCargo(Request $request){

    try{
      db::beginTransaction();
      $relacion = PPM_Inscripcion::findOrFail($request->codRelacion);
      $relacion->cargo = $request->cargo;
      $relacion->save();

      db::commit();
      
      return RespuestaAPI::respuestaOk("Se actualizó el cargo exitosamente. Recargando la página");
    } catch (\Throwable $th) {

      DB::rollBack();
      Debug::mensajeError("OrganizacionController ActualizarCargo",$th);
      $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                      app('request')->route()->getAction(),
                                                      ""
                                                      );
      return RespuestaAPI::respuestaError(Configuracion::getMensajeError($codErrorHistorial));

    }
  }








 



}
