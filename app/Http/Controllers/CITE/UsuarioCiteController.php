<?php

namespace App\Http\Controllers\CITE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ActividadPrincipal;
use App\Configuracion;
use App\Debug;
use App\Empleado;
use App\Models\CITE\UnidadProductiva as UnidadProductiva;

use App\ErrorHistorial;
use App\Fecha;
use App\Http\Controllers\PersonaPoblacionController;
use App\Mes;
use App\Models\CITE\AsistenciaServicio;
use App\Models\CITE\ModalidadServicio;
use App\Models\CITE\RelacionUsuarioUnidad;
use App\Models\CITE\Servicio;
use App\Models\CITE\UsuarioCite;
use App\ParametroSistema;
use App\RespuestaAPI;
use App\UI\UIFiltros;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UsuarioCiteController extends Controller
{
    const PAGINATION = 25;

    public function Crear(){


        return view('CITE.Usuarios.CrearUsuario');
    }

    /* no se está usando esta */
    public function Guardar(Request $request){

        try{
            DB::beginTransaction();
            $usuario = new UsuarioCite();
            $usuario->nombres = mb_strtoupper($request->nombres);
            $usuario->dni = $request->dni;

            $usuario->apellidoMaterno = mb_strtoupper($request->apellidoMaterno);
            $usuario->apellidoPaterno = mb_strtoupper($request->apellidoPaterno);
            $usuario->telefono = $request->telefono;
            $usuario->correo = $request->correo;
            $usuario->updateNombreBusqueda();
            
            $usuario->fechaHoraCreacion = Carbon::now();
            $usuario->codEmpleadoCreador =Empleado::getEmpleadoLogeado()->getId();


            $usuario->save();

            db::commit();

            return redirect()->route('CITE.Usuarios.Ver',$usuario->getId())
                ->with('datos','Usuario '.$usuario->getNombreCompleto().' creado exitosamente.');
        } catch (\Throwable $th) {
            Debug::mensajeError('UsuarioCite CONTROLLER guardar',$th);
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                            app('request')->route()->getAction(),
                                                            json_encode($request->toArray())
                                                            );
            return redirect()->route('CITE.Usuarios.Listar')
            ->with('datos',Configuracion::getMensajeError($codErrorHistorial));
        }
    }

    public function Editar($codUsuario){
        $usuario = UsuarioCite::findOrFail($codUsuario);


        return view('CITE.Usuarios.EditarUsuario',compact('usuario'));
    }

    public function Eliminar($codUsuario){
      try {
        db::beginTransaction();
        $usuario = UsuarioCite::findOrFail($codUsuario);
        if($usuario->apareceEnOtrasTablas()){
          return RespuestaAPI::respuestaError("No se puede eliminar al usuario porque aparece en otras tablas");
        }

        $nombre = $usuario->getNombreCompleto();
        $usuario->delete();

        db::commit();
        return RespuestaAPI::respuestaOk("Se eliminó al usuario ".$nombre." de la base de datos, recargando la página para actualizar los datos...");
        
      } catch (\Throwable $th) {
        db::rollBack();

        throw $th;
      }
      
    }

    public function Actualizar(Request $request){

        try{
            DB::beginTransaction();
            $usuario = UsuarioCite::findOrFail($request->codUsuario);
            $usuario->nombres = mb_strtoupper($request->nombres);
            $usuario->dni = $request->dni;

            $usuario->apellidoMaterno = mb_strtoupper($request->apellidoMaterno);
            $usuario->apellidoPaterno = mb_strtoupper($request->apellidoPaterno);
            $usuario->telefono = $request->telefono;
            $usuario->correo = $request->correo;
            $usuario->updateNombreBusqueda();

            $usuario->fechaHoraActualizacion = Carbon::now();

            $usuario->save();

            db::commit();

            return redirect()->route('CITE.Usuarios.Ver',$usuario->getId())
                ->with('datos','Usuario '.$usuario->getNombreCompleto().' editado exitosamente.');
        } catch (\Throwable $th) {
            Debug::mensajeError('UsuarioCite CONTROLLER actualizar',$th);
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                            app('request')->route()->getAction(),
                                                            json_encode($request->toArray())
                                                            );
            return redirect()->route('CITE.Usuarios.Listar')
            ->with('datos',Configuracion::getMensajeError($codErrorHistorial));
        }

    }



    /* Le llega un JSON que tiene un vector de usuarios */
    public function listar(Request $request){

        $listaModalidades = ModalidadServicio::All();

        $listaUsuarios = UsuarioCite::orderBy('codUsuario','DESC');
        $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaUsuarios,$request->getQueryString());
        
        $listaUsuarios = UIFiltros::buildQuery($listaUsuarios,$request->getQueryString());
        $filtros_usados = UIFiltros::getQueryValues($listaUsuarios,$request->getQueryString());

        $listaUsuarios = $listaUsuarios->orderBy('codUsuario','DESC')->paginate(static::PAGINATION);
         
        
        
        return view('CITE.Usuarios.ListarUsuarios',compact('listaUsuarios','listaModalidades','filtros_usados','filtros_usados_paginacion'));
    }


    public function ver($id){
        $usuario = UsuarioCite::findOrFail($id);
        $listaServiciosEnQueNoParticipo = $usuario->getServiciosEnQueNoParticipo();

        return view('CITE.Usuarios.VerUsuario',compact('usuario','listaServiciosEnQueNoParticipo'));

    }

    function ExportarExcel(Request $request){
      if($request->fechaInicio)
          $fechaInicio = Fecha::formatoParaSQL($request->fechaInicio);
      if($request->fechaFin)
          $fechaFin = Fecha::formatoParaSQL($request->fechaFin);


      /* Join especial para ordenar por razonsocial y nombres */
      $listaAsistenciasServicio = AsistenciaServicio::where('codModalidad',$request->codModalidad)
                                ->where(Servicio::FiltroEspecialFechas($fechaInicio,$fechaFin))

                              ->join('cite-usuario','cite-usuario.codUsuario','=','cite-asistencia_servicio.codUsuario')
                              ->join('cite-servicio','cite-servicio.codServicio','=','cite-asistencia_servicio.codServicio')
                              ->join('cite-unidad_productiva','cite-servicio.codUnidadProductiva','=','cite-unidad_productiva.codUnidadProductiva')
      //ordenamiento por tabla cliente (nombrePersona,razonSocial) y luego por tabla servicio (descripcion)    luego por nombres de la persona                  
                              ->orderBy('nombrePersona','ASC')
                              ->orderBy('razonSocial','ASC')

                              ->orderBy('fechaInicio','ASC')
                               
                              ->orderBy('nombres','ASC')
                              ->get();

                              
      if($request->codModalidad==1)
        $convenio = true;
      else
        $convenio = false;

      $modalidad = ModalidadServicio::findOrFail($request->codModalidad);
      $nombreModalidad = $modalidad->nombre;

      $rangoFechas = $request->fechaInicio." al ".$request->fechaFin;
      $filename = "Reporte de usuarios CITE $rangoFechas $nombreModalidad .xls";
      $descargarExcel = ParametroSistema::exportacionExcelActivada();

      return view('CITE.Usuarios.ExportarUsuariosCite',compact('listaAsistenciasServicio','rangoFechas','fechaInicio','fechaFin','filename','descargarExcel'));

    }

    //equivalente al marcar asistencia
    function VincularServicio(Request $request){
        $servicio = Servicio::findOrFail($request->codServicio);
        $unidadProductiva = $servicio->getUnidadProductiva();

        $rela = new AsistenciaServicio();
        $rela->codUsuario = $request->codUsuario;
        $rela->codServicio= $request->codServicio;


        $externo = 1;
        if($unidadProductiva->tieneUsuarioAsociado($request->codUsuario))
            $externo = 0;
        $rela->externo = $externo;

        $rela->save();


        return redirect()->route('CITE.Usuarios.Ver',$request->codUsuario)->with('datos',"Se ha vinculado el servicio exitosamente.");
    }


    function ponerNombresYApellidosEnMayusculas(){
        try {

            db::beginTransaction();
            $listaUsuarios = UsuarioCite::All();
            foreach ($listaUsuarios as $usuario) {
                error_log($usuario->codUsuario);

                $usuario->nombres = mb_strtoupper($usuario->nombres);
                $usuario->apellidoPaterno = mb_strtoupper($usuario->apellidoPaterno);
                $usuario->apellidoMaterno = mb_strtoupper($usuario->apellidoMaterno);
                $usuario->save();

            }
            db::commit();
        } catch (\Throwable $th) {
            db::rollBack();
            throw $th;
        }

        return "listo";
    }


    /* Remplaza los nombres de los usuarios que fueron corrompidos por las tildes
    por los nombres obtenidos de la reniec
    Esta funcion solo remplaza de 100 en 100

    http://localhost:8000/CITE/remplazarNombresCorruptos?limite=2&campo=nombres
    */
    function remplazarNombresCorruptos(Request $request){
        try {



            db::beginTransaction();
            $listaUsuariosCorruptos = UsuarioCite::where($request->campo,"like","%�%")
                ->where('dni','!=','')
                ->orderBy('codUsuario','DESC')
                ->get();

            $total = count($listaUsuariosCorruptos);
            $STR = "";

            $i=0;
            foreach ($listaUsuariosCorruptos as $usuario) {

                $str = PersonaPoblacionController::ConsultarAPISunatDNI($usuario->dni);
                error_log($i." consultando ".$usuario->dni. "      ");
                $STR.= $i." consultando ".$usuario->dni. "      <br>";
                $respuesta = json_decode($str);

                if($respuesta->ok=="1"){
                    $datos = $respuesta->datos;

                    $usuario->apellidoPaterno = mb_strtoupper($datos->apellidoPaterno);
                    $usuario->apellidoMaterno = mb_strtoupper($datos->apellidoMaterno);
                    $usuario->nombres = mb_strtoupper($datos->nombres);
                    $usuario->save();
                }else{
                    $STR.= "HUBO UN ERROR PROCESANDO EL DNI ".$usuario->dni . "<br><br><br><br>";
                }

                $i++;
                if($i==$request->limite)
                    break;
            }
            db::commit();
            return "Exito, procesados ".$request->limite." registros de un inicial de ".$total.  "<br>". $STR;
        } catch (\Throwable $th) {
            error_log("OCURRIO UN ERROR, HACIENDO ROLLBACK");

            db::rollBack();
            throw $th;
        }
    }

    /* SELECT * FROM `cite-usuario` WHERE dni like 'O%' or dni like '%O' */
    function quitarOdeDNIs(){
        $usuarios = UsuarioCite::where('dni','like','O%')->orWhere('dni','like','%O')->get();
        foreach ($usuarios as $user) {
            $user->dni = str_replace("O","0",$user->dni);
            $user->save();
        }
        return count($usuarios);

    }



    function verReporteRepetidos(){

        $sql = "SELECT dni,count(codUsuario) as cantidad FROM `cite-usuario` group by dni 
          having count(codUsuario) !=1
        ";
        $usuarios_repetidos = DB::select($sql);


        $sql2 = "SELECT concat(codUsuario,'-',codUnidadProductiva)  as relacion, count(codRelacionUsuarioUnidad) as cantidad
            FROM `cite-relacion_usuario_unidad` 
            GROUP BY concat(codUsuario,'-',codUnidadProductiva)
            HAVING count(codRelacionUsuarioUnidad) > 1
        ";
        $relaciones_usuario_unidad = DB::select($sql2);

        $sql3 = "SELECT concat(codUsuario,'-',codServicio) as relacion,count(codAsistenciaServicio)  as cantidad
            FROM `cite-asistencia_servicio` 
            GROUP BY concat(codUsuario,'-',codServicio)
            HAVING count(codAsistenciaServicio) > 1
        ";

        $relaciones_usuario_servicio = DB::select($sql3);


        return view('AdminPanel.ReporteCiteRepetidos',compact('usuarios_repetidos','relaciones_usuario_unidad','relaciones_usuario_servicio')); 

    }

}
