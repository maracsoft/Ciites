<?php

namespace App\Http\Controllers\CITE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ActividadPrincipal;
use App\Configuracion;
use App\Debug;
use App\Departamento;
use App\Empleado;
use App\Models\CITE\UnidadProductiva;
use App\Models\CITE\TipoPersoneria;

use App\ErrorHistorial;
use App\Http\Controllers\PersonaPoblacionController;
use App\Models\CITE\Cadena;
use App\Models\CITE\ClasificacionRangoVentas;
use App\Models\CITE\EstadoDocumento;
use App\Models\CITE\RelacionUsuarioUnidad;
use App\Models\CITE\UsuarioCite;
use App\Models\PPM\PPM_Organizacion;
use App\Models\PPM\PPM_Sincronizador;
use App\RespuestaAPI;
use App\UI\UIFiltros;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
 
class UnidadProductivaController extends Controller
{
    const PAGINATION = 25;
    
    
    public function Listar(Request $request){
         
        
        $todasLasUnidadesProduc = UnidadProductiva::All();
        foreach ($todasLasUnidadesProduc as $u) {
          $u->razonYRUC = $u->getDenominacion()." - ".$u->getRucODNI();
        }
       
        $listaUnidadesProductivas = UnidadProductiva::where('codUnidadProductiva','>',0);
        $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaUnidadesProductivas,$request->getQueryString());

        $listaUnidadesProductivas = UIFiltros::buildQuery($listaUnidadesProductivas,$request->getQueryString());
        $filtros_usados = UIFiltros::getQueryValues($listaUnidadesProductivas,$request->getQueryString());
        
        $listaUnidadesProductivas = $listaUnidadesProductivas->orderBy('codUnidadProductiva','DESC')->paginate(static::PAGINATION);
        $listaDepartamentos = Departamento::All();
        $listaCadenas = Cadena::All();
        
        return view('CITE.UnidadProductiva.ListarUnidadesProductivas',compact('listaUnidadesProductivas','filtros_usados','filtros_usados_paginacion',
            'todasLasUnidadesProduc','listaCadenas','listaDepartamentos'));

    }
    public function Ver($id){
        $unidadProductiva = UnidadProductiva::findOrFail($id);
        return view('CITE.UnidadProductiva.VerUnidadProductiva',compact('unidadProductiva'));

    }

    public function Crear(){

        $listaTipoPersoneria = TipoPersoneria::All();
        $listaDepartamentos = Departamento::All();
        $listaRangos = ClasificacionRangoVentas::All();
        $listaCadenas = Cadena::orderBy('nombre','ASC')->get();
        $listaEstadosUnidad = EstadoDocumento::All();

        $listaOrganizaciones = PPM_Organizacion::TodasParaSelect();
        

        return view('CITE.UnidadProductiva.CrearUnidadProductiva',
                compact('listaTipoPersoneria','listaDepartamentos','listaCadenas','listaRangos','listaEstadosUnidad','listaOrganizaciones'));
    }


    public function Guardar(Request $request){

        try {
            if($request->enTramite=='1')
                $enTramite = 1;
            else
                $enTramite = 0;

            if($request->tieneCadena=='1')
                $tieneCadena = 1;
            else
                $tieneCadena = 0;


            if($enTramite==0){//si ingresaron dni o ruc fijo
                if($request->codEstadoDocumento==1){ //RUC
                    if(UnidadProductiva::existeUnidadProductivaRUC($request->ruc))
                        return redirect()->route('CITE.UnidadesProductivas.Listar')
                            ->with('datos','ERROR: La unidad productiva con RUC '.$request->ruc. " ya existe en la base de datos actual.");
                }else{ //DNI
                    if(UnidadProductiva::existeUnidadProductivaDNI($request->dni))
                        return redirect()->route('CITE.UnidadesProductivas.Listar')
                            ->with('datos','ERROR: La unidad productiva con DNI '.$request->dni. " ya existe en la base de datos actual.");
                }
            }




            db::beginTransaction();

            $unidadProductiva = new UnidadProductiva();

            $unidadProductiva->codTipoPersoneria = $request->codTipoPersoneria;
            $unidadProductiva->ruc = $request->ruc;

            $unidadProductiva->razonSocial = $request->razonSocial;

            $unidadProductiva->fechaHoraCreacion = Carbon::now();
            $unidadProductiva->codEmpleadoCreador = Empleado::getEmpleadoLogeado()->getId();

            $unidadProductiva->dni = $request->dni;
            $unidadProductiva->nombrePersona = $request->nombrePersona;

            $unidadProductiva->tieneCadena = $tieneCadena;
            if($tieneCadena == "0")
                $unidadProductiva->codCadena = null;
            else
                $unidadProductiva->codCadena = $request->codCadena;


            $unidadProductiva->enTramite = $enTramite;
            $unidadProductiva->codClasificacion = $request->codClasificacion;
            $unidadProductiva->direccion = $request->direccion;
            $unidadProductiva->codDistrito = $request->ComboBoxDistrito;
            $unidadProductiva->codEstadoDocumento = $request->codEstadoDocumento;

            $unidadProductiva->nroServiciosHistorico = 0;

            $unidadProductiva->setDataFromRequest($request);
            
            $unidadProductiva->save();

            db::commit();


            return redirect()->route('CITE.UnidadesProductivas.Editar',$unidadProductiva->getId())
                ->with('datos','Unidad Productiva '.$unidadProductiva->getDenominacion().'  creado exitosamente. Por favor añada los socios correspondientes.');
        } catch (\Throwable $th) {
            Debug::mensajeError('UnidadProductivaController CONTROLLER guardar',$th);
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             json_encode($request->toArray())
                                                            );
            return redirect()->route('CITE.UnidadesProductivas.Listar')
            ->with('datos',Configuracion::getMensajeError($codErrorHistorial));
        }

    }


    public function Editar($codUnidadProductiva){

        $listaTipoPersoneria = TipoPersoneria::All();
        $listaDepartamentos = Departamento::All();
        $unidadProductiva = UnidadProductiva::findOrFail($codUnidadProductiva);
        $listaEstadosUnidad = EstadoDocumento::All();
        $listaCadenas = Cadena::orderBy('nombre','ASC')->get();
        $listaRangos = ClasificacionRangoVentas::All();

        $listaOrganizaciones = PPM_Organizacion::TodasParaSelect();
        

        $departamento = $unidadProductiva->getDepartamento();
        $provincia = $unidadProductiva->getProvincia();
        $distrito = $unidadProductiva->getDistrito();


        return view('CITE.UnidadProductiva.EditarUnidadProductiva',
            compact('listaTipoPersoneria','listaDepartamentos','unidadProductiva','listaEstadosUnidad','listaCadenas','listaRangos',
            'listaOrganizaciones',
            'departamento',
            'provincia',
            'distrito'
            ));
    }

    public function ConfigurarPresidenteGerente(Request $request){


        try {

            db::beginTransaction();

            $unidadProductiva = UnidadProductiva::findOrFail($request->codUnidadProductiva);
            $unidadProductiva->codUsuarioGerente =$request->codUsuarioGerente;
            $unidadProductiva->codUsuarioPresidente =$request->codUsuarioPresidente;

            $unidadProductiva->save();

            db::commit();


            return redirect()->route('CITE.UnidadesProductivas.Editar',$unidadProductiva->getId())
                ->with('datos','Presidente y gerente de la unidad productiva '.$unidadProductiva->getDenominacion().'  actualizados exitosamente.');
        } catch (\Throwable $th) {
            Debug::mensajeError('UnidadProductivaController CONTROLLER ConfigurarPresidenteGerente',$th);
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             json_encode($request->toArray())
                                                            );
            return redirect()->route('CITE.UnidadesProductivas.Editar',$unidadProductiva->getId())
            ->with('datos',Configuracion::getMensajeError($codErrorHistorial));
        }


    }

    public function Actualizar(Request $request){

        try {
            if($request->tieneCadena=='1')
                $tieneCadena = 1;
            else
                $tieneCadena = 0;


            db::beginTransaction();

            $unidadProductiva = UnidadProductiva::findOrFail($request->codUnidadProductiva);


            $unidadProductiva->ruc = $request->ruc;
            $unidadProductiva->razonSocial = $request->razonSocial;

            $unidadProductiva->dni = $request->dni;
            $unidadProductiva->nombrePersona = $request->nombrePersona;
            if($request->enTramite=='1') $enTramite = 1;
            else                         $enTramite = 0;
            $unidadProductiva->enTramite = $enTramite;

            $unidadProductiva->tieneCadena = $tieneCadena;
            if($tieneCadena == "0")
                $unidadProductiva->codCadena = null;
            else
                $unidadProductiva->codCadena = $request->codCadena;


            $unidadProductiva->codDistrito = $request->ComboBoxDistrito;

            $unidadProductiva->codTipoPersoneria = $request->codTipoPersoneria;
            $unidadProductiva->codClasificacion = $request->codClasificacion;
            $unidadProductiva->direccion = $request->direccion;

            $unidadProductiva->codEstadoDocumento = $request->codEstadoDocumento;

            $unidadProductiva->setDataFromRequest($request);


            $unidadProductiva->save();

            db::commit();


            return redirect()->route('CITE.UnidadesProductivas.Listar')
                ->with('datos','Unidad Productiva '.$unidadProductiva->getDenominacion().'  actualizado exitosamente.');
        } catch (\Throwable $th) {
            Debug::mensajeError('UnidadProductivaController CONTROLLER guardar',$th);
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             json_encode($request->toArray())
                                                            );
            return redirect()->route('CITE.UnidadesProductivas.Listar')
            ->with('datos',Configuracion::getMensajeError($codErrorHistorial));
        }

    }

    function AñadirGrupoDeSocios(Request $request){

        try {

            DB::beginTransaction();

            $unidad_productiva = UnidadProductiva::findOrFail($request->codUnidadProductiva);
            $listaUsuarios = $request->listaUsuariosAAgregar;
            foreach ($listaUsuarios as $user) {

                $codUsuario =$user['codUsuario'];
                if($codUsuario==0){ //usuario ingresado manualmente y no por el botón de buscar por DNI

                    //buscamos al usuario por si ya está en la bd
                    $listaUsuariosDNI = UsuarioCite::where('dni',$user['dni'])->get();
                    if(count($listaUsuariosDNI)==0){ //NUEVO USUARIO

                        $usuario = new UsuarioCite();
                        $usuario->dni = $user['dni'];
                        $usuario->nombres = mb_strtoupper($user['nombres']);
                        $usuario->apellidoPaterno = mb_strtoupper($user['apellidoPaterno']);
                        $usuario->apellidoMaterno = mb_strtoupper($user['apellidoMaterno']);
                        $usuario->telefono = $user['telefono'];
                        $usuario->correo = $user['correo'];
                        $usuario->fechaHoraCreacion = Carbon::now();
                        $usuario->codEmpleadoCreador =Empleado::getEmpleadoLogeado()->getId();
                        $usuario->updateNombreBusqueda();
            

                        $usuario->save();
                    }else{//USUARIO YA EXISTE , si se le mandan valores no vacios en los campos opcionales, remplazará a los antiguos
                        $usuario = $listaUsuariosDNI[0];
                        if($user['telefono'] != ""){
                            $usuario->telefono = $user['telefono'];
                            $usuario->fechaHoraActualizacion = Carbon::now();
                        }
                        if($user['correo'] != ""){
                            $usuario->correo = $user['correo'];
                            $usuario->fechaHoraActualizacion = Carbon::now();
                        }

                        $usuario->save();
                    }
                }else{ //usuario existente que fue encontrado en la bd
                    $usuario = UsuarioCite::findOrFail($codUsuario);
                }

                //verificamos si la relacion no existe ya (de todas maneras esta validacion tambn se hace en frontend)
                if(!RelacionUsuarioUnidad::existeRelacion($request->codUnidadProductiva,$usuario->codUsuario)){
                    $relacion = new RelacionUsuarioUnidad();
                    $relacion->codUnidadProductiva = $request->codUnidadProductiva;
                    $relacion->codUsuario = $usuario->codUsuario;
                    $relacion->save();
                }

            }

            $msj_extra = "";
            $enlace_ppm_activado = $unidad_productiva->tieneEnlacePPM();
            if($enlace_ppm_activado){
              $organizacion = $unidad_productiva->getOrganizacionEnlazada();

              $dnis_añadidos = PPM_Sincronizador::SincronizarSocios($organizacion,$unidad_productiva);
              $se_realizaron_cambios_sincronizacion = count($dnis_añadidos['dnis_añadidos_a_unidad']) > 0 || count($dnis_añadidos['dnis_añadidos_a_organizacion']);
              if($se_realizaron_cambios_sincronizacion){
                $msj_extra = "(y a la Organización gracias al enlace)";
              }
            }


            DB::commit();
            return RespuestaAPI::respuestaOk("Los nuevos usuarios fueron añadidos exitosamente a la unidad productiva $msj_extra. <br> Recargando la página...");
        } catch (\Throwable $th) {

            DB::rollBack();
            Debug::mensajeError("servicioController añadirGrupoUsuarios",$th);
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             json_encode($request->toArray())
                                                            );
            return RespuestaAPI::respuestaError(Configuracion::getMensajeError($codErrorHistorial));
        }

    }



    function EliminarRelacionUsuarioUnidad($codRelacion){
        try {
            db::beginTransaction();
            $rela = RelacionUsuarioUnidad::findOrFail($codRelacion);
            $nombre = $rela->getUsuario()->getNombreCompleto();
            $codUnidadProductiva = $rela->codUnidadProductiva;
            

            $unidad_productiva = UnidadProductiva::findOrFail($codUnidadProductiva);
            $enlace_ppm_activado = $unidad_productiva->tieneEnlacePPM();

            $msj_extra = "";
            if($enlace_ppm_activado){
              $se_elimino_del_ppm = $rela->eliminarSuscripcionPPM();
              if($se_elimino_del_ppm){
                $msj_extra = " y de la organización (el enlace PPM está activado).";
              }
            }

            
            $rela->delete();
            db::commit();

            return redirect()->route('CITE.UnidadesProductivas.Editar',$codUnidadProductiva)
                    ->with('datos_ok',"Se ha eliminado al usuario $nombre de la unidad productiva $msj_extra");

        } catch (\Throwable $th) {
            DB::rollBack();
            Debug::mensajeError("servicioController EliminarRelacionUsuarioUnidad",$th);
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             $codRelacion
                                                            );
            return redirect()->route('CITE.UnidadesProductivas.Ver',$codUnidadProductiva)
            ->with('datos_error',Configuracion::getMensajeError($codErrorHistorial));

        }


    }

    public function Eliminar($codUnidadProductiva){
      try {
        
        db::beginTransaction();
        $unidad = UnidadProductiva::findOrFail($codUnidadProductiva);
        if($unidad->apareceEnOtrasTablas()){
          return RespuestaAPI::respuestaError("No se puede eliminar la unidad productiva porque aparece en otras tablas");
        }

        if(!$unidad->usuarioLogeadoPuedeEliminar()){
          return RespuestaAPI::respuestaError("No tiene permisos para eliminar la unidad productiva");
        }

        $nombre = $unidad->getDenominacion();
        $unidad->delete();

        db::commit();
        return RespuestaAPI::respuestaOk("Se eliminó a la unidad productiva \"".$nombre."\" de la base de datos, recargando la página para actualizar los datos...");
        
      } catch (\Throwable $th) {
        db::rollBack();

        throw $th;
      }
      
    }






    //para llenar las
    function poblarDirecciones(){
        try {
            db::beginTransaction();
            $listaUnidadesProductivas = UnidadProductiva::All();
            foreach ($listaUnidadesProductivas as $unidadProductiva) {

                if(strlen($unidadProductiva->ruc) == 11){


                    $str = PersonaPoblacionController::ConsultarAPISunatRUC($unidadProductiva->ruc);
                    if($str!="1"){
                        error_log($unidadProductiva->codUnidadProductiva.") guardando a " .$str);


                        $objeto = json_decode($str);
                        if(!is_null($objeto->direccion)){
                            $unidadProductiva->direccion = $objeto->direccion;
                            $unidadProductiva->save();
                        }
                    }


                }

            }
            db::commit();

        } catch (\Throwable $th) {
            error_log("OCURRIO UN ERROR, HACIENDO ROLLBACK");

            db::rollBack();
            throw $th;
        }
    }


    function poblarRazonSocial($limit){
        try {
            db::beginTransaction();
            $listaUnidadesProductivas = UnidadProductiva::where('razonSocial',"like","%�%")
              ->orWhere('direccion','like',"%�%")
              ->get();
            $resp = "";
            $i = 1;
            foreach ($listaUnidadesProductivas as $unidadProductiva) {
              if(is_numeric($unidadProductiva->ruc)){



                if(strlen($unidadProductiva->ruc) == 11){

                  $str = PersonaPoblacionController::ConsultarAPISunatRUC($unidadProductiva->ruc);

                  $resp.= $i.") ";
                  if($str!="1"){
                      error_log($unidadProductiva->codUnidadProductiva.") guardando a " .$str);


                      $objeto = json_decode($str);
                      $unidadProductiva->razonSocial = $objeto->razonSocial;

                      if($objeto->direccion!=""){
                        error_log("DIRECCION ENCONTRADA".$objeto->direccion);
                        $unidadProductiva->direccion = $objeto->direccion;
                      }

                      $unidadProductiva->save();

                      $resp.=" ".$objeto->razonSocial;

                  }
                  $resp.="<br> ";
                }
                if(strlen($unidadProductiva->ruc) == 8){

                  $str = PersonaPoblacionController::ConsultarAPISunatDNI($unidadProductiva->ruc);
                  $respuesta = json_decode($str);

                  $resp.= $i.") ";
                  if($respuesta->ok=="1"){
                      $datos = $respuesta->datos;

                      error_log($unidadProductiva->codUnidadProductiva.") guardando a " .$str);

                      $unidadProductiva->razonSocial = "";
                      $unidadProductiva->ruc = "";

                      $unidadProductiva->nombrePersona = $datos->nombres." ".$datos->apellidoMaterno." ".$datos->apellidoPaterno;
                      $unidadProductiva->dni = $unidadProductiva->ruc;

                      $unidadProductiva->save();
                      $resp.=" ".$unidadProductiva->nombrePersona;
                  }
                  $resp.="<br> ";
                }



              }
              $i++;

              if($i>$limit){
                break;
              }
            }
            db::commit();
            return "analizadas ".$i." de inicial de ".count($listaUnidadesProductivas)." <br>".$resp;

        } catch (\Throwable $th) {
            error_log("OCURRIO UN ERROR, HACIENDO ROLLBACK");

            db::rollBack();
            throw $th;
        }
    }



    /* 
      Ya que antes no existia el booleano tiene cadena,
      esta funcion convierte todas las unidades productiva que tienen 
         codCadena = 1 (Ninguna) 
         a
         tieneCadena = 0 y codCadena = null
    
    */
    function pasarLasUnidadesDeNingunaANoTieneCadena(){
        try {
          db::beginTransaction();
          $msj = "";
          $listaUnidades = UnidadProductiva::where('codCadena','=',1)->get();
          foreach($listaUnidades as $unidadProductiva){
            $unidadProductiva->codCadena = null;
            $unidadProductiva->tieneCadena = 0;
            $unidadProductiva->save();
            $msj.=$unidadProductiva->getId().",";
          }

          db::commit();
          return "Convertidas las unidades ". $msj;
        } catch (\Throwable $th) {
          db::rollBack();
          throw $th;
        }

    }

    public function eliminarUnidadesProductivas999(){

        /*
        $listaUnidadesProductivasVacios = UnidadProductiva::where('ruc',999)->get();
        $listaUnidadesProductivasSinServicios = [];
        foreach ($listaUnidadesProductivasVacios as $unidadProductiva) {
            $cantServ = count($unidadProductiva->getServicios());
            if($cantServ==0)
                array_push($listaUnidadesProductivasSinServicios,$unidadProductiva->codUnidadProductiva);

        }
        return $listaUnidadesProductivasSinServicios;
        */

        $array = [199,200,201,202,203,204,205,206,207,208,209,210,211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237];
        try {
            DB::beginTransaction();

            UnidadProductiva::whereIn('codUnidadProductiva',$array)->delete();

            db::commit();
            return "listo";
        } catch (\Throwable $th) {
            db::rollBack();
            throw $th;
        }



    }


    function ponerRazonSocialYNombreEnMayusculas(){
        try {

            db::beginTransaction();
            $listaUnidades = UnidadProductiva::All();
            foreach ($listaUnidades as $unidadProductiva) {
                error_log($unidadProductiva->getId());

                $unidadProductiva->razonSocial = mb_strtoupper($unidadProductiva->razonSocial);
                $unidadProductiva->nombrePersona = mb_strtoupper($unidadProductiva->nombrePersona);

                $unidadProductiva->save();
            }

            db::commit();
        } catch (\Throwable $th) {
            db::rollBack();
            throw $th;
        }

        return "listo";
    }



    public function Reporte(Request $request){

        $listaUnidadesProductivas = UnidadProductiva::All();

        return view('CITE.UnidadProductiva.ExportarUnidadesProductivas',compact('listaUnidadesProductivas'));

    }

    public function SincronizarConPPM(Request $request){

      try{
        db::beginTransaction();
        $codUnidadProductiva = $request->codUnidadProductiva;
        $unidad_productiva = UnidadProductiva::findOrFail($codUnidadProductiva);
        $enlace_ppm_activado = $unidad_productiva->tieneEnlacePPM();
  
        if(!$enlace_ppm_activado){
          return redirect()->route('CITE.UnidadesProductivas.Editar',$codUnidadProductiva)->with('datos_error',"ERROR: Para sincronizar la unidad productiva con su organización de PPM, se requiere tener activado el enlace");
        }
  
        $organizacion = $unidad_productiva->getOrganizacionEnlazada();
  
        $dnis_añadidos = PPM_Sincronizador::SincronizarSocios($organizacion,$unidad_productiva);
        $msj = PPM_Sincronizador::GetMsjAñadicionOrganizacion($dnis_añadidos);
      
        db::commit();
        
        return redirect()->route('CITE.UnidadesProductivas.Editar',$codUnidadProductiva)
                      ->with('datos_ok',$msj);
         
      } catch (\Throwable $th) {
  
        DB::rollBack();
        Debug::mensajeError("OrganizacionController SincronizarConCITE",$th);
        $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                        app('request')->route()->getAction(),
                                                        $codUnidadProductiva
                                                        );
        return redirect()->route('CITE.UnidadesProductivas.Editar',$codUnidadProductiva)
        ->with('datos_error',Configuracion::getMensajeError($codErrorHistorial));
  
      }

    }
}
