<?php

namespace App\Http\Controllers\PPM;

use App\ArchivoGeneral;
use App\Configuracion;
use App\Debug;
use App\Empleado;
use App\ErrorHistorial;
use App\Fecha;
use App\Http\Controllers\Controller;
use App\MesAño;
use App\Models\CITE\ArchivoServicio;
use App\Models\PPM\PPM_ArchivoEjecucion;
use Illuminate\Http\Request;

 
 
use App\Models\PPM\PPM_EjecucionActividad;
use App\Models\PPM\PPM_Indicador;
use App\Models\PPM\PPM_Objetivo;
use App\Models\PPM\PPM_Organizacion;
use App\Models\PPM\PPM_Participacion;
use App\Models\PPM\PPM_Persona;
use App\Models\PPM\PPM_Inscripcion;
use App\Models\PPM\PPM_RelacionPersonaSemestre;
use App\Models\PPM\PPM_Sexo;
use App\ParametroSistema;
use App\TipoArchivoGeneral;
use App\UI\UIFiltros;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PersonaPPMController extends Controller
{
    const PAGINATION = '40';

    public function Listar(Request $request){

      $listaPersonas = PPM_Persona::query();
      $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaPersonas,$request->getQueryString());
      
      $listaPersonas = UIFiltros::buildQuery($listaPersonas,$request->getQueryString());
      $filtros_usados = UIFiltros::getQueryValues($listaPersonas,$request->getQueryString());

      $listaPersonas = $listaPersonas->orderBy('codPersona','DESC')->paginate(static::PAGINATION);
       

      return view('PPM.Persona.ListarPersonasPPM',compact('listaPersonas','filtros_usados','filtros_usados_paginacion'));

    }
    public function Ver($id){
      $persona = PPM_Persona::findOrFail($id);
       
      $listaParticipaciones =  PPM_Participacion::where('codPersona',$id)->get();
      $listaAsociaciones = PPM_Inscripcion::where('codPersona',$id)->get();
      $listaOrganizaciones = PPM_Organizacion::All();
      return view('PPM.Persona.VerPersonaPPM',compact('persona','listaParticipaciones','listaAsociaciones','listaOrganizaciones'));
    }

    public function Crear(){
      $listaOrganizaciones = PPM_Organizacion::All();
      $listaSexos = PPM_Sexo::getSexosParaSelect();

      return view('PPM.Persona.CrearPersonaPPM',compact('listaSexos','listaOrganizaciones'));
    }

    public function Editar($id){
      $persona = PPM_Persona::findOrFail($id);
      $listaSexos = PPM_Sexo::getSexosParaSelect();
      $listaOrganizaciones = PPM_Organizacion::All();
      $listaParticipaciones =  PPM_Participacion::where('codPersona',$id)->get();
      $listaAsociaciones = PPM_Inscripcion::where('codPersona',$id)->get();

      return view('PPM.Persona.EditarPersonaPPM',compact('persona','listaSexos','listaParticipaciones','listaAsociaciones','listaOrganizaciones'));
    }

    
      

    public function Guardar(Request $request){

      try {
        $logeado = Empleado::getEmpleadoLogeado();

        if($request->dni){
          $search = PPM_Persona::where('dni',$request->dni)->count();
          if($search > 0){
            return redirect()->route('PPM.Persona.Listar')->with('datos_error',"ERROR: La persona con el DNI ".$request->dni." ya está registrada en el sistema.");
          }
        }
        
        DB::beginTransaction();
        $persona = new PPM_Persona();
        $persona->procesarRequest($request);

        $persona->codEmpleadoCreador = $logeado->codEmpleado;
        $persona->fechaHoraCreacion = Carbon::now();

        $persona->save();

        $relacion = new PPM_Inscripcion();
        $relacion->codOrganizacion = $request->codOrganizacion;
        $relacion->codPersona = $persona->codPersona;
        $relacion->cargo = $request->cargo;
        $relacion->save();
        
        DB::commit();
        return redirect()->route('PPM.Persona.Editar',$persona->getId())->with('datos_ok',"Persona creada exitosamente");
        
      } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;
      }

    }
 

    public function Actualizar(Request $request){
      try {
        DB::beginTransaction();

        if($request->dni){
          $search = PPM_Persona::where('dni',$request->dni)->where('codPersona','!=',$request->codPersona)->count();
          if($search > 0){
            return redirect()->route('PPM.Persona.Editar',$request->codPersona)->with('datos_error',"Error al actualizar, la persona con el DNI ".$request->dni." ya está registrada en el sistema.");
          }
        }

        $persona = PPM_Persona::findOrFail($request->codPersona);


        $persona->procesarRequest($request);
        
        $persona->save();
        
        DB::commit();
        return redirect()->route('PPM.Persona.Editar',$persona->getId())->with('datos_ok',"Persona editada exitosamente");
        
      } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;
      }
      
    }

    
    public function AsociarAOrganizacion(Request $request){
      try {
        DB::beginTransaction();

        $ya_existe = PPM_Inscripcion::existeRelacion($request->codOrganizacionAsociar,$request->codPersonaAsociar);
        if($ya_existe){
          return redirect()->route('PPM.Persona.Editar',$request->codPersonaAsociar)->with('datos_error',"ERROR: La persona ya está enlazada a la organización");
        }
        $persona = PPM_Persona::findOrFail($request->codPersonaAsociar);

        $relacion = new PPM_Inscripcion();
        $relacion->cargo = $request->cargo_organizacion;
        $relacion->codPersona = $request->codPersonaAsociar;
        $relacion->codOrganizacion = $request->codOrganizacionAsociar;
        $relacion->save();
      
        $nombre = $relacion->getOrganizacion()->razon_social;
        
        DB::commit();
        return redirect()->route('PPM.Persona.Editar',$persona->getId())->with('datos_ok',"Persona enlazada a la organización \"$nombre\" exitosamente");
        
      } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;
      }
      
    }


    public function Eliminar($id){
      try {
        DB::beginTransaction();
 
        $persona = PPM_Persona::findOrFail($id);
        $nombre = $persona->getNombreCompleto();

        $cant_relaciones = PPM_Participacion::where('codPersona',$id)->count();
        if($cant_relaciones){
          return redirect()->route('PPM.Persona.Listar')->with('datos_error',"ERROR: La persona \"$nombre\" no puede ser eliminada porque participó en actividades.");
        }

        
        $persona->delete();
        
        DB::commit();
        return redirect()->route('PPM.Persona.Listar')->with('datos_ok',"Persona \"$nombre\" eliminada exitosamente");
      } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;
      }
      
    }

    
    function BuscarPorDni($dni){
      $resultado = [
          'persona' => '',
          'encontrado' => false,
      ];

      $lista = PPM_Persona::where('dni',$dni)->get();
      if(count($lista) > 0){ //encontramos a uno
          $resultado['persona'] = $lista[0];
          if($resultado['persona']->fecha_nacimiento){
            $resultado['persona']['fecha_nacimiento_formateada'] = Fecha::formatoParaVistas($resultado['persona']->fecha_nacimiento); 
          }else{
            $resultado['persona']['fecha_nacimiento_formateada'] = "";
          }
          
          $resultado['encontrado'] = true;
      }else{
          $resultado['encontrado'] = false;
      }
      return $resultado;
    }


}
