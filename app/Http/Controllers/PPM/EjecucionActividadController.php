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
use App\Models\PPM\PPM_ActividadEconomica;
use App\Models\PPM\PPM_ArchivoEjecucion;
use App\Models\PPM\PPM_AsistenciaDetalleprod;
use App\Models\PPM\PPM_DetalleProducto;
use Illuminate\Http\Request;

 
 
use App\Models\PPM\PPM_EjecucionActividad;
use App\Models\PPM\PPM_FGE_Marcacion;
use App\Models\PPM\PPM_Indicador;
use App\Models\PPM\PPM_Objetivo;
use App\Models\PPM\PPM_Organizacion;
use App\Models\PPM\PPM_Participacion;
use App\Models\PPM\PPM_Persona;
use App\Models\PPM\PPM_RelacionOrganizacionSemestre;
use App\Models\PPM\PPM_Inscripcion;
use App\Models\PPM\PPM_RelacionPersonaSemestre;
use App\Models\PPM\PPM_Sexo;
use App\ParametroSistema;
use App\RespuestaAPI;
use App\Semestre;
use App\TipoArchivoGeneral;
use App\UI\UIFiltros;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EjecucionActividadController extends Controller
{
    const PAGINATION = '20';

    public function Listar(Request $request){

 
      $listaActividades = PPM_EjecucionActividad::query();
      $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaActividades,$request->getQueryString());
      
      $listaActividades = UIFiltros::buildQuery($listaActividades,$request->getQueryString());
      $filtros_usados = UIFiltros::getQueryValues($listaActividades,$request->getQueryString());
       
      $listaActividades = $listaActividades->orderBy('codEjecucionActividad','DESC')->paginate(static::PAGINATION);

      $TodasLasOrganizaciones = PPM_Organizacion::TodasParaSelect();

      $listaEmpleados = Empleado::getListaEmpleadosPorApellido();
      $listaDepartamentos = Departamento::All();
      $listaMesAño = MesAño::getMesesDeEsteAñoYAnterior();

      return view('PPM.EjecucionActividad.ListarEjecuciones',compact('listaActividades','listaEmpleados','listaDepartamentos','listaMesAño','TodasLasOrganizaciones','filtros_usados','filtros_usados_paginacion'));

    }
    public function Crear(){
      
      $listaOrganizaciones = PPM_Organizacion::All();
      $listaMesesAño = MesAño::getMesesDeEsteAñoYAnterior();
      $codMesAñoActual = MesAño::getActual()->getId();
   
      $listaObjetivos = PPM_Objetivo::todosParaFront();
      $listaSemestres = Semestre::TodosParaFront();

      return view('PPM.EjecucionActividad.CrearEjecucion',compact('listaOrganizaciones','listaMesesAño','codMesAñoActual','listaObjetivos','listaSemestres'));
    }
    public function Editar($id){
      $ejecucion = PPM_EjecucionActividad::findOrFail($id);

      $listaOrganizaciones = PPM_Organizacion::All();
      $listaMesesAño = MesAño::getMesesDeEsteAñoYAnterior();
      $codMesAñoActual = MesAño::getActual()->getId();
      $listaSemestres = Semestre::TodosParaFront();

      $listaObjetivos = PPM_Objetivo::todosParaFront();
      $listaSexos = PPM_Sexo::getSexosParaSelect();
      
      $link_drive = ParametroSistema::getParametroSistema("ppm_actividad_link_drive")->valor;
      $listaUsuariosYAsistencia = $ejecucion->getSociosYAsistencia();

      $organizacion = $ejecucion->getOrganizacion();
      $objetivo = $ejecucion->getObjetivo();
      $indicador = $ejecucion->getIndicador();
      $actividad = $ejecucion->getActividad();

      return view('PPM.EjecucionActividad.EditarEjecucion',compact('ejecucion','listaOrganizaciones','listaMesesAño','codMesAñoActual','listaUsuariosYAsistencia','listaObjetivos','link_drive','listaSexos','listaSemestres','organizacion','objetivo','indicador','actividad'));

    }

    public function CrearEnBaseAOtro($id){
      $ejecucion = PPM_EjecucionActividad::findOrFail($id);

      $listaOrganizaciones = PPM_Organizacion::All();
      $listaMesesAño = MesAño::getMesesDeEsteAñoYAnterior();
      $codMesAñoActual = MesAño::getActual()->getId();
      $listaSemestres = Semestre::TodosParaFront();

      $listaObjetivos = PPM_Objetivo::todosParaFront();
      $listaSexos = PPM_Sexo::getSexosParaSelect();
      
      $link_drive = ParametroSistema::getParametroSistema("ppm_actividad_link_drive")->valor;
      $listaUsuariosYAsistencia = $ejecucion->getSociosYAsistencia();

      $organizacion = $ejecucion->getOrganizacion();
      $objetivo = $ejecucion->getObjetivo();
      $indicador = $ejecucion->getIndicador();
      $actividad = $ejecucion->getActividad();

      return view('PPM.EjecucionActividad.CrearEjecucionEnBase',compact('ejecucion','listaOrganizaciones','listaMesesAño','codMesAñoActual','listaUsuariosYAsistencia','listaObjetivos','link_drive','listaSexos','listaSemestres','organizacion','objetivo','indicador','actividad'));

    }
     

    public function Guardar(Request $request){
      try {
        $logeado = Empleado::getEmpleadoLogeado();
        DB::beginTransaction();

        $ejec = new PPM_EjecucionActividad();
        $ejec->setDataFromRequest($request,true);

        $ejec->codEmpleadoCreador = $logeado->codEmpleado;
        $ejec->fechaHoraCreacion = Carbon::now();

        $ejec->save();
        

        $ejec->crearRelacionOrganizacionSemestre_NoExistentes();

        
        if( !is_null($request->nombresArchivos) && $request->nombresArchivos!="[]" ){ //SI NO ES NULO Y No está vacio

          $nombresArchivos = json_decode($request->nombresArchivos); //ahora llega un vector en JSON ["archivo1.pdf","archivo2.pdf"]

          $j=0;
          $codTipoArchivo = TipoArchivoGeneral::getCodigo('EjecucionActividadPPM');
          foreach ($request->file('filenames') as $archivo){
          
            //Primero guardamos el archivo para obtener su id
            $archivoGen = new ArchivoGeneral();
            $archivoGen->nombreGuardado = "nombreTemporal.marac";
            $archivoGen->nombreAparente = $nombresArchivos[$j];
            $archivoGen->codTipoArchivo = $codTipoArchivo;
            $archivoGen->save();

            $nombreArchivoGuardado = ArchivoGeneral::formatoNombre($archivoGen->getId(),$nombresArchivos[$j]);
            Debug::mensajeSimple('el nombre de guardado de la imagen es:'.$nombreArchivoGuardado);
            $archivoGen->nombreGuardado = $nombreArchivoGuardado;
            $archivoGen->save();

            $archivoEjecucion = new PPM_ArchivoEjecucion();
            $archivoEjecucion->codEjecucionActividad = $ejec->getId();
            $archivoEjecucion->codArchivo = $archivoGen->getId();
            $archivoEjecucion->save();

            $fileget = \File::get( $archivo );

            Storage::disk('archivoGeneral')->put($nombreArchivoGuardado,$fileget );
            $j++;
          }
        }
        
        DB::commit();

        return redirect()->route('PPM.Actividad.Editar',$ejec->getId())->with('datos_ok',"Actividad creada exitosamente");
      } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;

      }
    }

    public function Actualizar(Request $request){

      try {
         
        DB::beginTransaction();

        
        $ejec = PPM_EjecucionActividad::findOrFail($request->codEjecucionActividad);
        $ejec->setDataFromRequest($request,false);

        $ejec->save();
        
        if( !is_null($request->nombresArchivos) && $request->nombresArchivos!="[]" ){ //SI NO ES NULO Y No está vacio

          $nombresArchivos = json_decode($request->nombresArchivos); //ahora llega un vector en JSON ["archivo1.pdf","archivo2.pdf"]

          $j=0;
          $codTipoArchivo = TipoArchivoGeneral::getCodigo('EjecucionActividadPPM');
          foreach ($request->file('filenames') as $archivo){
          
            //Primero guardamos el archivo para obtener su id
            $archivoGen = new ArchivoGeneral();
            $archivoGen->nombreGuardado = "nombreTemporal.marac";
            $archivoGen->nombreAparente = $nombresArchivos[$j];
            $archivoGen->codTipoArchivo = $codTipoArchivo;
            $archivoGen->save();

            $nombreArchivoGuardado = ArchivoGeneral::formatoNombre($archivoGen->getId(),$nombresArchivos[$j]);
            Debug::mensajeSimple('el nombre de guardado de la imagen es:'.$nombreArchivoGuardado);
            $archivoGen->nombreGuardado = $nombreArchivoGuardado;
            $archivoGen->save();

            $archivoEjecucion = new PPM_ArchivoEjecucion();
            $archivoEjecucion->codEjecucionActividad = $ejec->getId();
            $archivoEjecucion->codArchivo = $archivoGen->getId();
            $archivoEjecucion->save();

            $fileget = \File::get( $archivo );

            Storage::disk('archivoGeneral')->put($nombreArchivoGuardado,$fileget );
            $j++;
          }
        }
        
        DB::commit();

        return redirect()->route('PPM.Actividad.Editar',$ejec->getId())->with('datos_ok',"Actividad editada exitosamente");
      } catch (\Throwable $th) {
        DB::rollBack();
        
        throw $th;

      }

    }
    public function Eliminar($codEjecucion){
        
      try{
        DB::beginTransaction();
        
        
        $ejecucion = PPM_EjecucionActividad::findOrFail($codEjecucion);

        $lista_relaciones = PPM_RelacionOrganizacionSemestre::where('codsEjecuciones','like',"%(".$codEjecucion.")%")->get();
        foreach ($lista_relaciones as $relacion) {
          $relacion->quitarEjecucionQueSustenta($ejecucion);
        }
        

        $cant1 = PPM_Participacion::where('codEjecucionActividad',$codEjecucion)->delete();
        $cant2 = PPM_ArchivoEjecucion::where('codEjecucionActividad',$codEjecucion)->delete();
        $desc = $ejecucion->descripcion;
        $ejecucion->delete();

        DB::commit();
        
        return redirect()->route('PPM.Actividad.Listar')->with('datos_ok',"Se eliminó por completo la ejecución $desc");
      } catch (\Throwable $th) {
        DB::rollBack();
        Debug::mensajeError("EjecucionActividadController Eliminar",$th);
        $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                        app('request')->route()->getAction(),
                                                        ""
                                                        );
        return redirect()->route('PPM.Actividad.Listar')->with('datos_error',Configuracion::getMensajeError($codErrorHistorial));

      }
      


    }
    
    public function Ver($id){
      $ejecucion = PPM_EjecucionActividad::findOrFail($id);

      $listaOrganizaciones = PPM_Organizacion::All();
      $listaMesesAño = MesAño::getMesesDeEsteAñoYAnterior();
      $codMesAñoActual = MesAño::getActual()->getId();
   
      $listaObjetivos = PPM_Objetivo::todosParaFront();
      
      $link_drive = ParametroSistema::getParametroSistema("ppm_actividad_link_drive")->valor;
      $listaUsuariosYAsistencia = $ejecucion->getSociosYAsistencia();

      return view('PPM.EjecucionActividad.VerEjecucion',compact('ejecucion','listaOrganizaciones','listaMesesAño','codMesAñoActual','listaUsuariosYAsistencia','listaObjetivos','link_drive'));

    }

    public function Inv_Participaciones($codEjecucionActividad){
      $ejecucion = PPM_EjecucionActividad::findOrFail($codEjecucionActividad);
      $participaciones = $ejecucion->getParticipaciones();

      return view('PPM.EjecucionActividad.Inv_Participaciones',compact('ejecucion','participaciones'));

    }



    function EliminarArchivo($codArchivoEjecucion){

      try {
          db::beginTransaction();
          $archivoEjecucion = PPM_ArchivoEjecucion::findOrFail($codArchivoEjecucion);

          $codEjecucion = $archivoEjecucion->codEjecucionActividad;
          $nombre = $archivoEjecucion->getArchivo()->nombreAparente;
          $archivoEjecucion->eliminarArchivo();

          db::commit();

          return redirect()->route('PPM.Actividad.Editar',$codEjecucion)->with('datos_ok',"Se ha eliminado al archivo $nombre de la actividad");

      } catch (\Throwable $th) {
          DB::rollBack();
          Debug::mensajeError("EjecucionActividadController EliminarArchivo",$th);
          $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                           app('request')->route()->getAction(),
                                                           $codArchivoEjecucion
                                                          );
          return redirect()->route('PPM.Actividad.Editar',$codEjecucion)
          ->with('datos_error',Configuracion::getMensajeError($codErrorHistorial));

      }

    }
 

    public function EliminarParticipacion($codParticipacion){
      try {
        db::beginTransaction();
        $participacion = PPM_Participacion::findOrFail($codParticipacion);
        $persona = $participacion->getPersona();
        $nombre = $participacion->getPersona()->getNombreCompleto();
        $codEjecucion = $participacion->codEjecucionActividad;
        $ejecucion = $participacion->getEjecucionActividad();

        $participacion->delete();

        PPM_RelacionPersonaSemestre::EliminarRelacionPersonaSemestre_NoSustentadas($persona,$ejecucion);
       
        db::commit();
        return redirect()->route('PPM.Actividad.Editar',$codEjecucion)->with('datos_ok',"Se eliminó correctamente la participación de $nombre");
      } catch (\Throwable $th) {
        
        DB::rollBack();
        Debug::mensajeError("EjecucionActividadController EliminarParticipacion",$th);
        $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                          app('request')->route()->getAction(),
                                                          $codEjecucion
                                                        );
        return redirect()->route('PPM.Actividad.Editar',$codEjecucion)
        ->with('datos_error',Configuracion::getMensajeError($codErrorHistorial));

      }

    }


    
    /*
      Le llega un array de objetos
      cada uno es un UsuarioCite, pero con un booleano extra 'asistencia'
    */

    public function GuardarAsistenciaInterna(Request $request){

      try {

          DB::beginTransaction();
          $ejecucion = PPM_EjecucionActividad::findOrFail($request->codEjecucionActividad);
          $persona = PPM_Persona::findOrFail($request->codPersona);
          
          $ya_existe = PPM_Participacion::VerificarParticipacion($request->codPersona,$request->codEjecucionActividad);
          
          if($request->new_value_asistencia == "true"){ //el nuevo valor es que sí
            
            if($ya_existe){
              //no hacemos nada
            }else{
              // la creamos
              $nueva = new PPM_Participacion();
              $nueva->codPersona = $request->codPersona;
              $nueva->codEjecucionActividad = $request->codEjecucionActividad;
              $nueva->externo = 0;
              $nueva->save();

              
            }

            $ejecucion->verificarYGenerarRelacionPersonaSemestre($persona);

            $msj = "AÑADIÓ";
          }else{ //nuevo valor es que NO
            
            if($ya_existe){ //la borramos
              $asistencia = PPM_Participacion::GetParticipacion($request->codPersona,$request->codEjecucionActividad);
              
              $asistencia->delete();

              
            }else{ 
              //no hacemos nada
            }
            PPM_RelacionPersonaSemestre::EliminarRelacionPersonaSemestre_NoSustentadas($persona,$ejecucion);

            
            $msj = "ELIMINÓ";
            
          }


           


          DB::commit();

          return RespuestaAPI::respuestaOk("Se $msj la asistencia de ".$persona->getNombreCompleto());
      } catch (\Throwable $th) {

          DB::rollBack();
          Debug::mensajeError("EjecucionActividadController GuardarAsistenciaInterna",$th);
          $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                           app('request')->route()->getAction(),
                                                           json_encode($request->toArray())
                                                          );
          return RespuestaAPI::respuestaError(Configuracion::getMensajeError($codErrorHistorial));
      }
    }








        /*
    Le llegan todos los datos del usuario,
        dni
        telefono
        correo
        nombres
        apellidoPaterno
        apellidoMaterno
        fecha_nacimiento
        sexo

    */
    public function AgregarAsistenciaExterna(Request $request){
      try {
          DB::beginTransaction();
          if($request->inscribirEnUnidad=='1')
              $inscribirEnUnidad = 1;
          else
              $inscribirEnUnidad = 0;

          $lista = PPM_Persona::where('dni',$request->dni)->get();
          if(count($lista) == 0){ //si no existe, lo crearemos
              $persona = new PPM_Persona();

              $persona->procesarRequest($request);
              
              $persona->codEmpleadoCreador =Empleado::getEmpleadoLogeado()->getId();
              $persona->fechaHoraCreacion = Carbon::now();
              
              $persona->data_comprobada_reniec = 0;
              $persona->necesita_comprobacion = 0;

              $persona->save();

          }else{ //ya existe y solo lo referenciamos con los datos que tenemos
              $persona = $lista[0];
              if($persona->telefono != ""){
                  $persona->telefono = $persona->telefono;
                  $persona->fechaHoraActualizacion = Carbon::now();
              }
              if($persona->correo != ""){
                  $persona->correo = $persona->correo;
                  $persona->fechaHoraActualizacion = Carbon::now();
              }
              $persona->save();

          }

          //creamos la asistencia
          $participacion = new PPM_Participacion();
          $participacion->codPersona = $persona->codPersona;
          $participacion->codEjecucionActividad = $request->codEjecucionActividad;
          if($inscribirEnUnidad==1)
            $participacion->externo = 0;
          else
            $participacion->externo = 1;


          $msjInscripcion = "";
          $ejecucion = PPM_EjecucionActividad::findOrFail($request->codEjecucionActividad);
          $organizacion = $ejecucion->getOrganizacion();
          
          
          if(!$organizacion->tienePersonaAsociada($persona->codPersona)){ //si no es socio ya, lo inscribimos a la unidad productiva
              if($inscribirEnUnidad == 1){
                  //ahora sí lo inscribimos
                  $inscripcion = new PPM_Inscripcion();
                  $inscripcion->codPersona = $persona->codPersona;
                  $inscripcion->codOrganizacion = $organizacion->getId();
                  $inscripcion->cargo = $request->cargo_organizacion;
                  $inscripcion->save();
                  $msjInscripcion = " y se le inscribió a la organización.";
              }
          }
          
          $ejecucion->verificarYGenerarRelacionPersonaSemestre($persona);


          $participacion->save();
          $nombre = $participacion->getPersona()->getNombreCompleto();
          DB::commit();
          return redirect()->route('PPM.Actividad.Editar',$request->codEjecucionActividad)->with('datos_ok',"Se ha añadido al usuario externo $nombre $msjInscripcion. ");
      } catch (\Throwable $th) {
          DB::rollBack();
          Debug::mensajeError("EjecucionActividadController AgregarAsistenciaExterna",$th);
          $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                           app('request')->route()->getAction(),
                                                           json_encode($request->toArray())
                                                          );
          return redirect()->route('PPM.Actividad.Editar',$request->codEjecucionActividad)->with('datos_error',Configuracion::getMensajeError($codErrorHistorial));

      }

    }



    function verDashboard(Request $request){
        
      $fechaInicio = $request->fechaInicio; 
      $fechaTermino = $request->fechaTermino; 
      $codActividadEconomica = $request->codActividadEconomica;
      $año_actual = date("Y");

      if(!$request->fechaInicio){
        $fechaInicio = "01/01/$año_actual";
      }
      if(!$request->fechaTermino){
        $año_siguiente = $año_actual + 1;
        $fechaTermino = "01/01/$año_siguiente";
      }

      $fechaInicio_sql = Fecha::formatoParaSQL($fechaInicio);
      $fechaTermino_sql = Fecha::formatoParaSQL($fechaTermino);


      $ejecucionesPorRegion_obj = PPM_EjecucionActividad::getReporteServiciosPorRegion($fechaInicio_sql,$fechaTermino_sql,$codActividadEconomica);
      $ejecucionesPorProvincia_obj = PPM_EjecucionActividad::getReporteServiciosPorProvincia($fechaInicio_sql,$fechaTermino_sql,$codActividadEconomica);
      $ejecucionesPorUnidad_obj = PPM_EjecucionActividad::getReporteServiciosPorUnidad($fechaInicio_sql,$fechaTermino_sql,$codActividadEconomica);
      $ejecucionesPorObjetivo_obj = PPM_EjecucionActividad::getReporteServiciosPorObjetivo($fechaInicio_sql,$fechaTermino_sql,$codActividadEconomica);
      $ejecucionesPorActividad_obj = PPM_EjecucionActividad::getReporteServiciosPorActividad($fechaInicio_sql,$fechaTermino_sql,$codActividadEconomica);

      
      $listaDepartamentos = Departamento::All();
      $listaActividadesEcon = PPM_ActividadEconomica::All();
      
      $empLogeado = Empleado::getEmpleadoLogeado();

      return view('PPM.DashboardPPM',compact('listaDepartamentos','fechaInicio','fechaTermino','listaActividadesEcon','ejecucionesPorActividad_obj',
              'ejecucionesPorRegion_obj','ejecucionesPorProvincia_obj','ejecucionesPorUnidad_obj','empLogeado','codActividadEconomica','ejecucionesPorObjetivo_obj'));
    }


}
