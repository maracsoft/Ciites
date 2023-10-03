<?php

namespace App\Http\Controllers\CITE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ActividadPrincipal;
use App\ArchivoGeneral;
use App\CDP;
use App\Configuracion;
use App\Debug;
use App\Departamento;
use App\Empleado;
use App\Models\CITE\UnidadProductiva as UnidadProductiva;
use App\Fecha;
use App\ErrorHistorial;
use App\Mes;
use App\MesAño;
use App\Models\CITE\ArchivoServicio;
use App\Models\CITE\ModalidadServicio;
use App\Models\CITE\Servicio;
use App\Models\CITE\TipoAcceso;
use App\Models\CITE\TipoServicio;
use App\Models\CITE\UsuarioCite;
use App\Models\CITE\AsistenciaServicio;
use App\ParametroSistema;
use App\Models\CITE\ActividadCite;
use App\Models\CITE\Cadena;
use App\Models\CITE\RelacionTipoMedioActividad;
use App\Models\CITE\RelacionUsuarioUnidad;

use App\Models\CITE\TipoMedioVerificacion;
use App\RespuestaAPI;
use App\TipoArchivoGeneral;
use App\UI\UIFiltros;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;
use ZipArchive;

class ServicioController extends Controller
{
    const PAGINATION = 25;

    public function Listar(Request $request){
        $empleadoLogeado = Empleado::getEmpleadoLogeado();

        $listaActividades = ActividadCite::All();

        $listaServicios = Servicio::where('codServicio','>','0');
        $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaServicios,$request->getQueryString());
        
        $listaServicios = UIFiltros::buildQuery($listaServicios,$request->getQueryString());
        $filtros_usados = UIFiltros::getQueryValues($listaServicios,$request->getQueryString());
         
        $listaServicios = $listaServicios->orderBy('codServicio','DESC')->paginate(static::PAGINATION);

        $listaTiposServicio = TipoServicio::where('codModalidad',1)->get();
       
        $listaTipoMedioVerificacion = TipoMedioVerificacion::All();

        $todasLasUnidadesProduc = UnidadProductiva::All();
        foreach ($todasLasUnidadesProduc as $u) {
          $u->razonYRUC = $u->getDenominacion()." - ".$u->getRucODNI();
        }
        $listaDepartamentos = Departamento::All();
       
        $listaEmpleados = Empleado::getListaEmpleadosPorApellido();
        $listaModalidades = ModalidadServicio::All();
        return view('CITE.Servicios.ListarServicios',compact('listaServicios','listaDepartamentos','filtros_usados','filtros_usados_paginacion','listaTipoMedioVerificacion',
                'listaModalidades','listaEmpleados','todasLasUnidadesProduc','listaActividades','listaTiposServicio','empleadoLogeado'));

    }


    public function Ver($id){

        $servicio = Servicio::findOrFail($id);
        $unidadProductiva = $servicio->getUnidadProductiva();

        return view('CITE.Servicios.VerServicio',compact('servicio','unidadProductiva'));

    }

    public function Crear(){

        $listaUnidadesProductivas = UnidadProductiva::orderBy('razonSocial')->orderBy('nombrePersona')->get();
        $listaTipoServicio = TipoServicio::All();
        $listaModalidades = ModalidadServicio::All();
        $listaTipoAcceso = TipoAcceso::All();
        $listaDepartamentos = Departamento::All();

        $listaActividades = ActividadCite::All();
 
        $listaMesesAño = MesAño::getMesesDeEsteAñoYAnterior();
        $listaTipoCDP = CDP::All();


        $empleadoLogeado = Empleado::getEmpleadoLogeado();
      

        return view('CITE.Servicios.CrearServicio',compact('listaUnidadesProductivas','listaTipoServicio',
            'listaModalidades',
            'listaTipoAcceso',
            'listaDepartamentos',
            'listaMesesAño','listaTipoCDP','listaActividades','empleadoLogeado'
    ));
    }


    public function Guardar(Request $request){

        try {

            db::beginTransaction();

            $servicio = new Servicio();
            $servicio->codUnidadProductiva = $request->codUnidadProductiva;
            $servicio->codTipoServicio = $request->codTipoServicio;
            $servicio->codActividad = $request->codActividad;


            $servicio->codModalidad = $request->codModalidad;
            $servicio->codTipoAcceso = $request->codTipoAcceso;
            $servicio->codDistrito = $request->ComboBoxDistrito;
   
            $servicio->descripcion = $request->descripcion;
            $servicio->cantidadServicio = $request->cantidadServicio;
            
            $servicio->nroHorasEfectivas = $request->nroHorasEfectivas;
            
            
            if($request->codTipoCDP){
              if($request->codTipoCDP != "-1"){
                $servicio->codTipoCDP = $request->codTipoCDP;
              }
            }
              
            $servicio->baseImponible = $request->baseImponible;
            $servicio->igv = $request->igv;
            $servicio->total = $request->total;
            $servicio->nroComprobante = $request->nroComprobante;


            $servicio->fechaHoraCreacion = Carbon::now();
            $servicio->codEmpleadoCreador = Empleado::getEmpleadoLogeado()->getId();

            $servicio->fechaInicio = Fecha::formatoParaSQL($request->fechaInicio);
            $servicio->fechaTermino = Fecha::formatoParaSQL($request->fechaTermino);

            $servicio->save();


            db::commit();


            return redirect()->route('CITE.Servicios.Editar',$servicio->getId())->with('datos_ok','Servicio creado exitosamente.');
        } catch (\Throwable $th) {
            Debug::mensajeError('ServicioController CONTROLLER guardar',$th);
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             json_encode($request->toArray())
                                                            );
            return redirect()->route('CITE.Servicios.Listar')
            ->with('datos',Configuracion::getMensajeError($codErrorHistorial));
        }

    }


    public function Editar($codServicio){

        $servicio = Servicio::findOrFail($codServicio);
        $listaUnidadesProductivas = UnidadProductiva::All();
        $listaTipoServicio = TipoServicio::All();
        $listaModalidades = ModalidadServicio::All();
        $listaTipoAcceso = TipoAcceso::All();
        $listaDepartamentos = Departamento::All();
        $listaActividades = ActividadCite::All();
        $listaTipoArchivos = TipoMedioVerificacion::TodosOrdenadosPorFormato();
 
        $listaMesesAño = MesAño::getMesesDeEsteAñoYAnterior();
        $listaTipoCDP = CDP::All();

        $listaRelacionUsuariosAsociados = $servicio->getRelaAsistenciaServicio();
        $listaUsuariosYAsistencia = $servicio->getUsuariosYAsistencia();

        //$listaUsuariosNoAsistentes = $servicio->getUsuariosExternosNoAsistentes();

        $departamento = $servicio->getDepartamento();
        $provincia = $servicio->getProvincia();
        $distrito = $servicio->getDistrito();

        $linkDrive = ParametroSistema::getParametroSistema('cite-servicio-link-drive')->valor;

 
        $empleadoLogeado = Empleado::getEmpleadoLogeado();
      

        return view('CITE.Servicios.EditarServicio',compact('listaUnidadesProductivas','listaTipoServicio',
                'listaModalidades','listaTipoArchivos',
                'listaTipoAcceso',
                'listaDepartamentos','listaTipoCDP',
                'listaMesesAño','linkDrive','empleadoLogeado',
                'servicio','departamento','provincia','distrito',
                'listaRelacionUsuariosAsociados','listaUsuariosYAsistencia','listaActividades'
            ));
    }


    public function Duplicar($codServicio){

        $servicio = Servicio::findOrFail($codServicio);
        $listaUnidadesProductivas = UnidadProductiva::All();
        $listaTipoServicio = TipoServicio::All();
        $listaModalidades = ModalidadServicio::All();
        $listaTipoAcceso = TipoAcceso::All();
        $listaDepartamentos = Departamento::All();
        $listaActividades = ActividadCite::All();

        $listaMesesAño = MesAño::getMesesDeEsteAñoYAnterior();
        $listaTipoCDP = CDP::All();

        $listaRelacionUsuariosAsociados = $servicio->getRelaAsistenciaServicio();
        $listaUsuariosYAsistencia = $servicio->getUsuariosYAsistencia();

        //$listaUsuariosNoAsistentes = $servicio->getUsuariosExternosNoAsistentes();

        $departamento = $servicio->getDepartamento();
        $provincia = $servicio->getProvincia();
        $distrito = $servicio->getDistrito();

        return view('CITE.Servicios.DuplicarServicio',compact('listaUnidadesProductivas','listaTipoServicio',
                'listaModalidades',
                'listaTipoAcceso',
                'listaDepartamentos','listaTipoCDP',
                'listaMesesAño',
                'servicio','departamento','provincia','distrito',
                'listaRelacionUsuariosAsociados','listaUsuariosYAsistencia','listaActividades'
            ));
    }


    public function Actualizar(Request $request){

        try {

            db::beginTransaction();

            $servicio = Servicio::findOrFail($request->codServicio);

            $servicio->codUnidadProductiva = $request->codUnidadProductiva;
            $servicio->codTipoServicio = $request->codTipoServicio;
            $servicio->codActividad = $request->codActividad;
            $servicio->codModalidad = $request->codModalidad;
            $servicio->codTipoAcceso = $request->codTipoAcceso;
            $servicio->codDistrito = $request->ComboBoxDistrito;
     
            $servicio->descripcion = $request->descripcion;
            $servicio->cantidadServicio = $request->cantidadServicio;
            
            $servicio->nroHorasEfectivas = $request->nroHorasEfectivas;
            
            if($request->codTipoCDP){
              if($request->codTipoCDP != "-1"){
                $servicio->codTipoCDP = $request->codTipoCDP;
              }
            }
            
            $servicio->baseImponible = $request->baseImponible;
            $servicio->igv = $request->igv;
            $servicio->total = $request->total;
            $servicio->nroComprobante = $request->nroComprobante;


            $servicio->fechaInicio = Fecha::formatoParaSQL($request->fechaInicio);
            $servicio->fechaTermino = Fecha::formatoParaSQL($request->fechaTermino);

            $servicio->save();

            $nombre = $servicio->descripcion;
            db::commit();

            return redirect()->route('CITE.Servicios.Editar',$servicio->codServicio)->with('datos_ok',"Servicio '$nombre' actualizado exitosamente.");
        } catch (\Throwable $th) {
            Debug::mensajeError('ServicioController CONTROLLER guardar',$th);
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             json_encode($request->toArray())
                                                            );
            return redirect()->route('CITE.Servicios.Listar')
            ->with('datos_error',Configuracion::getMensajeError($codErrorHistorial));
        }

    }

    public function SubirArchivos(Request $request){
       
      try{

        DB::beginTransaction();
        $codServicio = $request->codServicio;
        $codTipoMedioVerificacion = $request->codTipoMedioVerificacion;

        $servicio = Servicio::findOrFail($codServicio);

        if( is_null($request->nombreArchivo) || $request->nombreArchivo=="" ){
          redirect()->route('CITE.Servicios.Editar',$codServicio)->with('datos_error',"ERROR: No se adjuntó ningún archivo");
        }

        $nombreArchivo = json_decode($request->nombreArchivo)[0];  
        
        $codTipoArchivo = TipoArchivoGeneral::getCodigo('ServicioCite');

        $archivo = null;
        foreach ($request->file('file_serv') as $ar) {
          $archivo = $ar;
        }
       
        //Primero guardamos el archivo para obtener su id
        $archivoGen = new ArchivoGeneral();
        $archivoGen->nombreGuardado = "nombreTemporal.marac";
        $archivoGen->nombreAparente = $nombreArchivo;
        $archivoGen->codTipoArchivo = $codTipoArchivo;
        $archivoGen->save();

        $nombreArchivoGuardado = ArchivoGeneral::formatoNombre($archivoGen->getId(),$nombreArchivo);
        
        $archivoGen->nombreGuardado = $nombreArchivoGuardado;
        $archivoGen->save();

        $archivoServicio = new ArchivoServicio();
        $archivoServicio->codServicio = $servicio->codServicio;
        $archivoServicio->codTipoMedioVerificacion = $request->codTipoMedioVerificacion;
        $archivoServicio->codArchivo = $archivoGen->getId();
        $archivoServicio->save();

        $fileget = \File::get($archivo);

        Storage::disk('archivoGeneral')->put($nombreArchivoGuardado,$fileget );

        $proyect_folder_path = ParametroSistema::getParametroSistema("proyect_folder_path")->valor;

        //hasta aqui ya está guardado el archivo, pero debemos verificar si es un PDF compatible con nuestra librería de compresiones.
        $ruta_documento_test = $proyect_folder_path."/tests/test_merge_pdf.pdf";
        $ruta_archivo_subido = $proyect_folder_path."/storage/app/archivoGeneral/".$archivoGen->nombreGuardado;
        $ruta_destino = $proyect_folder_path."/tests/archivo_generado_test.pdf";

        try {
          $pdf = new \Jurosh\PDFMerge\PDFMerger;
          
          $pdf->addPDF($ruta_documento_test, 'all');
          $pdf->addPDF($ruta_archivo_subido, 'all');
          
          $pdf->merge('file', $ruta_destino);
        } catch (\Throwable $th) {
          DB::rollBack();
          return redirect()->route('CITE.Servicios.Editar',$codServicio)->with('mostrar_modal_archivo_nocompatible',"1");
        }
        
        DB::commit();
          
        return redirect()->route('CITE.Servicios.Editar',$codServicio)->with('datos_ok',"Se ha subido el archivo $nombreArchivo exitosamente");
      } catch (\Throwable $th) {
        Debug::mensajeError('ServicioController CONTROLLER SubirArchivos',$th);
        DB::rollBack();
        $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                        app('request')->route()->getAction(),
                                                        json_encode($request->toArray())
                                                        );
        return redirect()->route('CITE.Servicios.Editar',$codServicio)
        ->with('datos',Configuracion::getMensajeError($codErrorHistorial));
      }



    }

    public function ActualizarTipoDeUnArchivo(Request $request){
      
      try {

        DB::beginTransaction();
       
        $archivo_servicio = ArchivoServicio::findOrFail($request->codArchivoServicio);
        $servicio = $archivo_servicio->getServicio();

        if($request->codTipoMedioVerificacion){
          $tipo_archivo_servicio = TipoMedioVerificacion::findOrFail($request->codTipoMedioVerificacion);
          $formato_name = $tipo_archivo_servicio->nombre;
          $archivo_servicio->codTipoMedioVerificacion = $tipo_archivo_servicio->getId(); 
        }else{
          $archivo_servicio->codTipoMedioVerificacion = null; 
          $formato_name = "Ningun tipo de archivo";
        }
        
        $archivo_servicio->save();

        $archivo_gen = $archivo_servicio->getArchivo();
        $name = $archivo_gen->nombreAparente;

        //ahora calculamos los archivos que le faltan al servicio segun su actividad
        $mensaje_archivos_faltantes = $servicio->getMensajeArchivosFaltantes();
        DB::commit();



        return RespuestaAPI::respuestaDatosOk("Se actualizó el tipo de archivo de \"$name\" a \"$formato_name\" exitosamente.",$mensaje_archivos_faltantes);
      } catch (\Throwable $th) {

          DB::rollBack();
          Debug::mensajeError("servicioController ActualizarTipoDeUnArchivo",$th);
          $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                          app('request')->route()->getAction(),
                                                          json_encode($request->toArray())
                                                          );
          return RespuestaAPI::respuestaError(Configuracion::getMensajeError($codErrorHistorial));
      }
    }

    public function ExportarExcel(Request $request){

        if($request->fechaInicio)
            $fechaInicio = Fecha::formatoParaSQL($request->fechaInicio);
        if($request->fechaFin)
            $fechaFin = Fecha::formatoParaSQL($request->fechaFin);


        /* Join especial para ordenar por razonsocial y nombres */
        /* Los function anidados son para generar la logica de filtro por fecha inicio y fecha fin, ver diagrama  */
        $listaServicios = Servicio::where('codModalidad',$request->codModalidad)
                                ->where('fechaTermino','>=',$fechaInicio)
                                ->where('fechaInicio','<=',$fechaFin)

                                ->where(Servicio::FiltroEspecialFechas($fechaInicio,$fechaFin))
                                ->join('cite-unidad_productiva','cite-unidad_productiva.codUnidadProductiva','=','cite-servicio.codUnidadProductiva')
      //ordenamiento por tabla cliente (nombrePersona,razonSocial) y luego por tabla servicio (descripcion)
                                ->orderBy('nombrePersona','ASC')
                                ->orderBy('razonSocial','ASC')

                                ->orderBy('fechaInicio','ASC')
                                 
                                ->get();


        if($request->codModalidad==1)
            $convenio = true;
        else
            $convenio = false;

        $modalidad = ModalidadServicio::findOrFail($request->codModalidad);
        $nombreModalidad = $modalidad->nombre;

        $rangoFechas = $request->fechaInicio." al ".$request->fechaFin;
        $filename = "Reporte de servicios CITE $rangoFechas $nombreModalidad.xls";

        $descargarExcel = ParametroSistema::exportacionExcelActivada();

        return view('CITE.Servicios.ExportarServicios',compact('convenio','listaServicios','fechaInicio','fechaFin','modalidad','filename','rangoFechas','descargarExcel'));


    }




    /*
    Le llega un array de objetos
    cada uno es un UsuarioCite, pero con un booleano extra 'asistencia'
    */
    public function GuardarAsistencias(Request $request){

        try {

            DB::beginTransaction();
            $servicio = Servicio::findOrFail($request->codServicio);
            $unidadProductiva  = $servicio->getUnidadProductiva();

            $listaUsuarios = $request->listaUsuariosYAsistencia;
            foreach ($listaUsuarios as $user) {

                if($user['asistencia'] != $user['nuevaAsistencia']){ //si hubo un cambio


                    if($user['nuevaAsistencia']=="true"){ //se va a crear el obj AsistenciaServicio
                        $asistenciaServicio = new AsistenciaServicio();
                        $asistenciaServicio->codServicio = $request->codServicio;
                        $asistenciaServicio->codUsuario = $user['codUsuario'];

                        $externo = 1;
                        if($unidadProductiva->tieneUsuarioAsociado($user['codUsuario']))
                            $externo = 0;
                        $asistenciaServicio->externo = $externo;

                        $asistenciaServicio->save();


                    }else{ //se va a destruir el obj AsistenciaServicio
                        $asistenciaServicio = AsistenciaServicio::where('codServicio',$request->codServicio)
                            ->where('codUsuario',$user['codUsuario'])->get()[0];
                        $asistenciaServicio->delete();


                    }


                }







            }


            DB::commit();
            return RespuestaAPI::respuestaOk("La lista de asistencia fue actualizada exitosamente. <br> Recargando la página...");
        } catch (\Throwable $th) {

            DB::rollBack();
            Debug::mensajeError("servicioController GuardarAsistencias",$th);
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

    */
    public function agregarAsistenciaExterna(Request $request){
        try {
            DB::beginTransaction();
            if($request->inscribirEnUnidad=='1')
                $inscribirEnUnidad = 1;
            else
                $inscribirEnUnidad = 0;

            $lista = UsuarioCite::where('dni',$request->dni)->get();
            if(count($lista) == 0){ //si no existe, lo crearemos
                $usuario = new UsuarioCite();
                $usuario->dni = $request->dni;
                $usuario->telefono = $request->telefono;
                $usuario->correo = $request->correo;
                $usuario->nombres = mb_strtoupper($request->nombres);
                $usuario->apellidoPaterno = mb_strtoupper($request->apellidoPaterno);
                $usuario->apellidoMaterno = mb_strtoupper($request->apellidoMaterno);
                $usuario->updateNombreBusqueda();
                
                $usuario->codEmpleadoCreador =Empleado::getEmpleadoLogeado()->getId();
                $usuario->fechaHoraCreacion = Carbon::now();

                $usuario->save();

            }else{ //ya existe y solo lo referenciamos con los datos que tenemos
                $usuario = $lista[0];
                if($usuario->telefono != ""){
                    $usuario->telefono = $usuario->telefono;
                    $usuario->fechaHoraActualizacion = Carbon::now();
                }
                if($usuario->correo != ""){
                    $usuario->correo = $usuario->correo;
                    $usuario->fechaHoraActualizacion = Carbon::now();
                }
                $usuario->save();

            }

            //creamos la asistencia
            $asistenciaServicio = new AsistenciaServicio();
            $asistenciaServicio->codUsuario = $usuario->codUsuario;
            $asistenciaServicio->codServicio = $request->codServicio;
            if($inscribirEnUnidad==1)
              $asistenciaServicio->externo = 0;
            else
              $asistenciaServicio->externo = 1;


            $msjInscripcion = "";
            $servicio = Servicio::findOrFail($request->codServicio);
            $unidad = $servicio->getUnidadProductiva();
            if(!$unidad->tieneUsuarioAsociado($usuario->codUsuario)){ //si no es socio ya, lo inscribimos a la unidad productiva
                if($inscribirEnUnidad == 1){
                    //ahora sí lo inscribimos
                    $inscripcion = new RelacionUsuarioUnidad();
                    $inscripcion->codUsuario = $usuario->codUsuario;
                    $inscripcion->codUnidadProductiva = $unidad->getId();
                    $inscripcion->save();
                    $msjInscripcion = " y se le inscribió a la unidad productiva.";
                }
            }



            $asistenciaServicio->save();
            $nombre = $asistenciaServicio->getUsuario()->getNombreCompleto();
            DB::commit();
            return redirect()->route('CITE.Servicios.Editar',$request->codServicio)->with('datos',"Se ha añadido al usuario externo $nombre $msjInscripcion. ");
        } catch (\Throwable $th) {
            DB::rollBack();
            Debug::mensajeError("servicioController agregarAsistenciaExterna",$th);
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             json_encode($request->toArray())
                                                            );
            return redirect()->route('CITE.Servicios.Editar',$request->codServicio)->with('datos',Configuracion::getMensajeError($codErrorHistorial));

        }

    }


    function buscarUsuarioCite($dni){
        $resultado = [
            'usuario' => '',
            'encontrado' => false,
        ];


        $lista = UsuarioCite::where('dni',$dni)->get();
        if(count($lista) > 0){ //encontramos a uno
            $resultado['usuario'] = $lista[0];
            $resultado['encontrado'] = true;
        }else{
            $resultado['encontrado'] = false;
        }
        return $resultado;


    }







    function EliminarRelacionUsuario($codRelacion){
        try {
            db::beginTransaction();
            $rela = AsistenciaServicio::findOrFail($codRelacion);
            $nombre = $rela->getUsuario()->getNombreCompleto();
            $codServicio = $rela->codServicio;
            $rela->delete();
            db::commit();

            return redirect()->route('CITE.Servicios.Editar',$codServicio)
                    ->with('datos_ok',"Se ha eliminado al usuario $nombre del servicio");

        } catch (\Throwable $th) {
            DB::rollBack();
            Debug::mensajeError("servicioController añadirGrupoUsuarios",$th);
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             $codRelacion
                                                            );
            return redirect()->route('CITE.Servicios.Editar',$codServicio)
            ->with('datos_error',Configuracion::getMensajeError($codErrorHistorial));

        }


    }



    function EliminarArchivo($codArchivoServicio){

        try {
            db::beginTransaction();
            $archivoServicio = ArchivoServicio::findOrFail($codArchivoServicio);
            $codServicio = $archivoServicio->codServicio;
            $nombre = $archivoServicio->getArchivo()->nombreAparente;
            $nombreServ = $archivoServicio->getServicio()->descripcion;
            $archivoServicio->eliminarArchivo();

            db::commit();

            return redirect()->route('CITE.Servicios.Editar',$codServicio)
                    ->with('datos_ok',"Se ha eliminado al archivo $nombre del servicio $nombreServ");

        } catch (\Throwable $th) {
            DB::rollBack();
            Debug::mensajeError("servicioController EliminarArchivo",$th);
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             $codArchivoServicio
                                                            );
            return redirect()->route('CITE.Servicios.Editar',$codServicio)
            ->with('datos',Configuracion::getMensajeError($codErrorHistorial));

        }

    }





    public function eliminarTotalmente($codServicio){
        try{
            db::beginTransaction();
            $servicio = Servicio::findOrFail($codServicio);
            $nombre = $servicio->descripcion;

            if(!$servicio->sePuedeEliminar()){
                return redirect()->route('CITE.Servicios.Listar')
                    ->with('datos',"no tiene permisos suficientes para eliminar el servicio '$nombre'.");
            }

            $listaArchivosServicio = $servicio->getListaArchivoServicio();
            foreach ($listaArchivosServicio as $archivoServicio) {
                $archivoServicio->eliminarArchivo();
            }

            AsistenciaServicio::where('codServicio',$codServicio)->delete();
            $servicio->delete();
            db::commit();

            return redirect()->route('CITE.Servicios.Listar')
                ->with('datos_ok',"Se ha eliminado TOTALMENTE el servicio '$nombre', esto implica sus archivos,asistencias y el servicio mismo.");
        } catch (\Throwable $th) {
            DB::rollBack();
            Debug::mensajeError("servicioController EliminarArchivo",$th);
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             $codServicio
                                                            );
            return redirect()->route('CITE.Servicios.Listar')
            ->with('datos_error',Configuracion::getMensajeError($codErrorHistorial));

        }

    }



    function verDashboard(Request $request){
        
      $fechaInicio = $request->fechaInicio; 
      $fechaTermino = $request->fechaTermino; 

      if($request->codsCadena != ""){
        $codsCadena = explode(",",$request->codsCadena);
      }else{
        $codsCadena = [];
      }
      
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


      $serviciosPorRegion_obj = Servicio::getReporteServiciosPorRegion($fechaInicio_sql,$fechaTermino_sql,$codsCadena);
      $serviciosPorProvincia_obj = Servicio::getReporteServiciosPorProvincia($fechaInicio_sql,$fechaTermino_sql,$codsCadena);
      $serviciosPorUnidad_obj = Servicio::getReporteServiciosPorUnidad($fechaInicio_sql,$fechaTermino_sql,$codsCadena);
      $serviciosPorActividad_obj = Servicio::getReporteServiciosPorActividad($fechaInicio_sql,$fechaTermino_sql,$codsCadena);

      $serviciosPorCadena_obj = Servicio::getReporteServiciosPorCadena($fechaInicio_sql,$fechaTermino_sql,$codsCadena);

      
      $listaDepartamentos = Departamento::All();
      $listaCadenas = Cadena::All();
      
      $empLogeado = Empleado::getEmpleadoLogeado();
      $codsCadena = $request->codsCadena;
      return view('CITE.DashboardCITE',compact('listaDepartamentos','fechaInicio','fechaTermino','listaCadenas',
              'serviciosPorRegion_obj','serviciosPorProvincia_obj','serviciosPorUnidad_obj','empLogeado','codsCadena','serviciosPorActividad_obj','serviciosPorCadena_obj'));
    }


    
    public function DescargarReporteHitos(Request $request){
      $listaTipoServicio = TipoServicio::All();
      $fechaInicio = Fecha::formatoParaSQL($request->fechaInicio);
      $fechaFin = Fecha::formatoParaSQL($request->fechaFin);

      $descargarExcel = ParametroSistema::exportacionExcelActivada();

      $rangoFechas = $request->fechaInicio." al ".$request->fechaFin;
      $filename = "Reporte de HITOS CITE $rangoFechas .xls";


      return view('CITE.Servicios.ReporteHitos',compact('listaTipoServicio','fechaInicio','fechaFin','descargarExcel','filename'));

    }

    /* 
    Genera 1 pdf por cada servicio que calza en los filtros que se le manda

    */
    public static function GenerarPdfsUnidos($codActividad,$fecha_inicio,$fecha_fin){
     
      $proyect_folder_path = ParametroSistema::getParametroSistema("proyect_folder_path")->valor;

      // Obtenemos el listado de servicios que trabajaremos
      $listaServicios = Servicio::where('codActividad',$codActividad)->where('fechaTermino','>',$fecha_inicio)->where('fechaTermino','<',$fecha_fin)->get();
      //para cada servicio, obtenemos sus archivos generales y los unificamos en un solo PDF

      foreach ($listaServicios as $servicio) {
        
        $tiene_archivos = $servicio->tieneArchivosExportables();
        if($tiene_archivos){
          
          
          $actividad = $servicio->getActividadPAT();
          $lista_relacion_tipomedio = RelacionTipoMedioActividad::where('codActividad',$actividad->codActividad)->orderBy('nro_orden','ASC')->get();


          $folder_archivosgen = $proyect_folder_path."/storage/app/archivoGeneral/";
          $pdf = new \Jurosh\PDFMerge\PDFMerger;
          
          foreach ($lista_relacion_tipomedio as $relacion_tipomedio) {
            
            $archivo_serv = $servicio->getArchivoServicio_SegunTipoMedioVerificacion($relacion_tipomedio->codTipoMedioVerificacion);
            if($archivo_serv){
              $archivo_general = $archivo_serv->getArchivo();

              $ruta_archivogen = $folder_archivosgen.$archivo_general->nombreGuardado; 
              
              $pdf->addPDF($ruta_archivogen, 'all');
              
            }else{
              
            }
          }
          $pdf->merge('file', $proyect_folder_path.'/storage/app/pdfs_unidos/MediosVerificacionServicio_'.$servicio->getId().'.pdf');
        }else{
          

        }

      }
      return $listaServicios;
    }


    public function GenerarComprimidoDeArchivos(Request $request){
      
      $codActividad = $request->codActividad;       
      $fecha_inicio = Fecha::formatoParaSQL($request->fecha_inicio); 
      $fecha_fin = Fecha::formatoParaSQL($request->fecha_fin); 

      $listaServicios = static::GenerarPdfsUnidos($codActividad,$fecha_inicio,$fecha_fin);
      
      $proyect_folder_path = ParametroSistema::getParametroSistema("proyect_folder_path")->valor;
      $carpeta_archivos_pdfs_unidos = $proyect_folder_path."/storage/app/pdfs_unidos/";

      $carpeta_destino = $proyect_folder_path."/storage/app/comprimidos/";

      $fecha = date("Y_m_d___H_i_s");
      $nombre_comprimido = "medios_verificacion_$fecha.zip";
      $zip = new ZipArchive();
      $res = $zip->open($carpeta_destino.$nombre_comprimido, ZipArchive::CREATE);
      
      if(!($res === TRUE)){
        return RespuestaAPI::respuestaError("Ocurrio un error al comprimir los archivos");
      }

      if(count($listaServicios) == 0){
        return RespuestaAPI::respuestaError("No hay ningún servicio que cumpla con los filtros ingresados.");
      }

    
      $algun_servicio_tiene_archivos = false;

      foreach ($listaServicios as $servicio) {
        
        $tiene_archivos = $servicio->tieneArchivosExportables();

        if($tiene_archivos){
          $algun_servicio_tiene_archivos = true;
          $id = $servicio->getId();
          // Añadimos un archivo en la raiz del zip.
          $archivo_name = $carpeta_archivos_pdfs_unidos."/MediosVerificacionServicio_$id.pdf";
           
          
          $existe = file_exists($archivo_name);
          if(!$existe){
            return RespuestaAPI::respuestaError("Ocurrio un error al comprimir los archivos, servicio $id");
          }
          $res2 = $zip->addFile($archivo_name,"MediosVerificacionServicio_$id.pdf");
          
          if(!$res2){
            return RespuestaAPI::respuestaError("Ocurrio un error al comprimir los archivos, servicio $id");
          }
        }
      }

      if(!$algun_servicio_tiene_archivos){ //si ningun servicio resulto tener archivos, mandamos error
        return RespuestaAPI::respuestaError("Ninguno de los servicios que cumplen con el criterio de búsqueda tiene archivos");
      }

      $res3 = $zip->close();
      if(!$res3){
        return RespuestaAPI::respuestaError("Ocurrio un error al comprimir los archivos");
      }

      $vista = view('CITE.Servicios.Inv_ServiciosCoincidentes',compact('listaServicios','nombre_comprimido'))->render();
      
      return RespuestaAPI::respuestaDatosOk("Se generó el archivo comprimido exitosamente",$vista);

    }


    function DescargarArchivoComprimido($nombre_archivo){
      
      return Storage::download("/comprimidos/".$nombre_archivo);

    }

    /* --------------------------- FUNCIONES OPERACIONES ------------------------  */
    /* --------------------------- FUNCIONES OPERACIONES ------------------------  */
    /* --------------------------- FUNCIONES OPERACIONES ------------------------  */
    /* --------------------------- FUNCIONES OPERACIONES ------------------------  */
    /* --------------------------- FUNCIONES OPERACIONES ------------------------  */
    /* --------------------------- FUNCIONES OPERACIONES ------------------------  */
    /* --------------------------- FUNCIONES OPERACIONES ------------------------  */
    /* --------------------------- FUNCIONES OPERACIONES ------------------------  */
    /* --------------------------- FUNCIONES OPERACIONES ------------------------  */



    function convertirFechasAFormatoSQL(){//convierte las fechas que están en formato 1/02/2020 y 10/02/2020 a 2020-02-10
        try {
            db::beginTransaction();
            $listaServicios = Servicio::All();
            foreach ($listaServicios as $serv) {
                $fecha = $serv->fechaInicio;
                $tamaño = strlen($fecha);
                if($tamaño==9){
                    $fecha = "0".$fecha;
                }

                $serv->fechaInicio = Fecha::formatoParaSQL($fecha);

                $fecha = $serv->fechaTermino;
                $tamaño = strlen($fecha);
                if($tamaño==9){
                    $fecha = "0".$fecha;
                }
                $serv->fechaTermino = Fecha::formatoParaSQL($fecha);
                $serv->save();

            }
            db::commit();
            return "yes";
        } catch (\Throwable $th) {
            db::rollBack();
            throw $th;


        }


    }





    function separarUsuarios(){

        //Pasaremos el contenido de la tabla usuario a la tabla usuario_servicio
        try {
            db::beginTransaction();
            $listaUsuarios = UsuarioCite::All();
            foreach ($listaUsuarios as $user) {
                $usuarioServicio = new AsistenciaServicio();
                $usuarioServicio->codUsuario = $user->codUsuario;
                $usuarioServicio->codServicio = $user->codServicio;
                $usuarioServicio->save();
            }
            db::commit();
            return "yes";
        } catch (\Throwable $th) {
            db::rollBack();
            throw $th;


        }


    }


    /*
        SELECT count(codUsuario) FROM `cite-usuario` group by dni having count(codUsuario)>1
    */
    //Esta lista bota todas las ids repetidas incluidas las primeras apariciones de cada usuario
    function mostrarUsuariosRepetidos(){
        $listaUsuarios = UsuarioCite::where('dni','!=','')->orderBy('dni','DESC')->get();
        $idsARemplazar = [];
        $dniAnterior = "";
        $idAnterior = "";

        foreach ($listaUsuarios as $usuario) {

            if($usuario->dni == $dniAnterior){
                error_log($usuario->dni."   ant=".$dniAnterior);
                array_push($idsARemplazar, $usuario->getId());
                if(!in_array($idAnterior,$idsARemplazar )){
                    array_push($idsARemplazar,$idAnterior);
                }
            }

            $dniAnterior = $usuario->dni;
            $idAnterior = $usuario->getId();
        }



        return $idsARemplazar;


    }




    //antes de correr esta funcion, actualizar el parametro sistema
    function eliminarUsuariosRepetidos(){
        try {
            db::beginTransaction();

            $listaIdsUsuariosRepetidos = explode(',',ParametroSistema::getParametroSistema('listaIdsUsuariosRepetidos')->valor );

            foreach ($listaIdsUsuariosRepetidos as $id) {

                //encontramos el usuario a eliminar
                $user = UsuarioCite::findOrFail($id);
                //encontramos la id del usuario que remplazará a este
                $primeraid = UsuarioCite::where('dni',$user->dni)->first()->codUsuario;
                if($primeraid != $id){//solo eliminamos si este no es el usuario
                    error_log("BORRANDO USER ". $id . " remplazando por " . $primeraid);
                    //remplazamos las apariciones y borramos finalmente
                    AsistenciaServicio::where('codUsuario',$id)->update(['codUsuario'=>$primeraid]);
                    RelacionUsuarioUnidad::where('codUsuario',$id)->update(['codUsuario'=>$primeraid]);
                    $user->delete();
                }
            }
            db::commit();
            return "READY";
        } catch (\Throwable $th) {
            db::rollBack();
            throw $th;
        }
    }


      //antes de correr esta funcion, actualizar el parametro sistema
      function eliminarRelacionUsuarioUnidadRepetidos(){
        try {
            db::beginTransaction();

            $listaRelacionesUsuarioUnidadRepetidas = explode(',',ParametroSistema::getParametroSistema('listaRelacionesUsuarioUnidadRepetidas')->valor );

            foreach ($listaRelacionesUsuarioUnidadRepetidas as $par) {
                echo "iterando el par $par <br>"; 
                $vector = explode('-',$par);
                $codUsuario = $vector[0];
                $codUnidadProductiva = $vector[1];


                //encontramos la relacion a eliminar
                $relaciones = RelacionUsuarioUnidad::where('codUsuario',$codUsuario)->where('codUnidadProductiva',$codUnidadProductiva)->get();


                if(count($relaciones) > 1){ 
                  $primeraRelacion = $relaciones[0]; // esta no se eliminara
                  foreach ($relaciones as $relacion) {
                    if($relacion->getId() != $primeraRelacion->getId()){ //si no es la primera, eliminamos
                      echo "Eliminando relacion ".$relacion->getId()."<br>";
                      $relacion->delete();
                    }
                  }
                }else{
                  echo "No están repetidas, saltando al siguiente <br>";
                }
                 
            }
            db::commit();
            return "READY";
        } catch (\Throwable $th) {
            db::rollBack();
            throw $th;
        }
      }

      function eliminarRelacionAsistenciasRepetidos(){
        try {
            db::beginTransaction();

            $listaRelacionesAsistenciaRepetidas = explode(',',ParametroSistema::getParametroSistema('listaRelacionesAsistenciaRepetidas')->valor );

            foreach ($listaRelacionesAsistenciaRepetidas as $par) {
                echo "iterando el par $par <br>"; 
                $vector = explode('-',$par);
                $codUsuario = $vector[0];
                $codServicio = $vector[1];


                //encontramos la relacion a eliminar
                $relaciones = AsistenciaServicio::where('codUsuario',$codUsuario)->where('codServicio',$codServicio)->get();


                if(count($relaciones) > 1){ 
                  $primeraRelacion = $relaciones[0]; // esta no se eliminara
                  foreach ($relaciones as $relacion) {
                    if($relacion->getId() != $primeraRelacion->getId()){ //si no es la primera, eliminamos
                      echo "Eliminando relacion ".$relacion->getId()."<br>";
                      $relacion->delete();
                    }
                  }
                }else{
                  echo "No están repetidas, saltando al siguiente <br>";
                }
                 
            }
            db::commit();
            return "READY";
        } catch (\Throwable $th) {
            db::rollBack();
            throw $th;
        }
      }



    function ponerDescripcionEnMayusculas(){
        try {

            db::beginTransaction();
            $listaServicios = Servicio::All();
            foreach ($listaServicios as $servicio) {
                error_log($servicio->getId());

                $servicio->descripcion = mb_strtoupper($servicio->descripcion);
                $servicio->save();

            }
            db::commit();
        } catch (\Throwable $th) {
            db::rollBack();
            throw $th;
        }

        return "listo";
    }



    /* retorna los servicios que tienen el codTipoCDP en null pero están como tipo acceso "pagado" */
    public function GetServiciosInvalidos(){
      
      $tipo_acceso_pagado = TipoAcceso::where('nombre','Pagado')->first();
      echo "codsServicios invalidos: <br>";
      $lista = Servicio::whereNull('codTipoCDP')->where('codTipoAcceso','=',$tipo_acceso_pagado->codTipoAcceso)->get();
      foreach ($lista as $servicio) {
        echo $servicio->getId()."<br>";
      }
      echo "<br> <br> LISTO";

      return;
    }


}
