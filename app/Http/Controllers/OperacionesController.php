<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\ArchivoOrdenCompra;
use App\ArchivoProyecto;
use App\ArchivoRendicion;
use App\ArchivoReposicion;
use App\ArchivoReqAdmin;
use App\ArchivoReqEmp;
use App\ArchivoSolicitud;
use App\BusquedaRepo;
use App\Configuracion;
use App\Debug;
use App\DetalleReposicionGastos;
use App\Empleado;
use App\ErrorHistorial;
use App\EstadoRendicionGastos;
use App\EstadoReposicionGastos;
use App\EstadoRequerimientoBS;
use App\EstadoSolicitudFondos;
use App\FakerCedepas;
use App\Numeracion;
use App\OperacionDocumento;
use App\ParametroSistema;
use App\Proyecto;
use App\Puesto;
use App\RendicionGastos;
use App\ReposicionGastos;
use App\RequerimientoBS;
use App\RespuestaAPI;
use App\SolicitudFondos;
use App\TipoOperacion;
use Carbon\Carbon;
use DateTime;
use Exception;
use Facade\FlareClient\Report;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\OperatingSystem;

class OperacionesController extends Controller
{
    const paginacion = 75;

    public function ListarOperaciones(Request $request){
        $buscar_codigoCedepas = $request->buscar_codigoCedepas; //esta sale de la tabla ligada
        
        $buscar_tipoDocumento = $request->buscar_tipoDocumento; //estos 2 salen de la misma tabla, normal
        $buscar_codEmpleado = $request->buscar_codEmpleado;

        $builder = OperacionDocumento::where('codOperacionDocumento','>','0')
            ->orderBy('codOperacionDocumento','DESC');//llamada a All pero como builder 
        
        if($buscar_tipoDocumento!="")
            $builder = $builder->where('codTipoDocumento','=',$buscar_tipoDocumento);

        if($buscar_codEmpleado!="")
            $builder = $builder->where('codEmpleado','=',$buscar_codEmpleado);
        
 
        if($buscar_codigoCedepas!=""){
            $lista_sof = SolicitudFondos::where('codigoCedepas','like','%'.$buscar_codigoCedepas.'%')->get()->toArray();
            $lista_ren = RendicionGastos::where('codigoCedepas','like','%'.$buscar_codigoCedepas.'%')->get()->toArray();
            $lista_rep =ReposicionGastos::where('codigoCedepas','like','%'.$buscar_codigoCedepas.'%')->get()->toArray();
            $lista_req = RequerimientoBS::where('codigoCedepas','like','%'.$buscar_codigoCedepas.'%')->get()->toArray();
            
            $vector_sof = array_column($lista_sof,'codSolicitud');
            $vector_ren = array_column($lista_ren,'codRendicionGastos');
            $vector_rep = array_column($lista_rep,'codReposicionGastos');
            $vector_req = array_column($lista_req,'codRequerimiento');
            //en vector_sof tenemos un vector en el que cada elemento en una key de una solicitud de fondos que cumple con el filtro
            
            $arraySuma = array_merge($vector_sof ,$vector_ren,$vector_rep,$vector_req);
            $builder = $builder->whereIn('codDocumento',$arraySuma);
        }




        $listaNueva = $builder->get();
        
        
        $listaOperaciones = $listaNueva->paginate(static::paginacion);
        $listaEmpleados = Empleado::All();
        return view('Operaciones.ListarOperaciones',compact('listaOperaciones','listaEmpleados',
            'buscar_codigoCedepas','buscar_tipoDocumento','buscar_codEmpleado'
            ));

    }
 
    public function EliminarOperacion($codOperacion){
        $op = OperacionDocumento::findOrFail($codOperacion);
        $cod = $op->codOperacionDocumento;
        $op->delete();
        return redirect()->route('Operaciones.Listar')->with('datos',"Se ha eliminado la operación $cod.");

    }



    /* BUSCADOR MAESTRO DE DOCUMENTOS */
    public function buscadorMaestro(){

        $listaEmpleados = Empleado::orderBy('apellidos')->get();

        return view('Operaciones.ListarMaestro',compact('listaEmpleados'));
        
    }


    //Invocable del de arriba
    function GetListadoBusqueda(Request $request){
        $buscar_codigoCedepas = $request->buscar_codigoCedepas;
        $buscar_tipoDocumento = $request->buscar_tipoDocumento;
        $buscar_codEmpleadoEmisor = $request->buscar_codEmpleadoEmisor;
        
        $listaSOF = SolicitudFondos::where('codigoCedepas','!=','0');
        $listaREN = RendicionGastos::where('codigoCedepas','!=','0');
        $listaREP = ReposicionGastos::where('codigoCedepas','!=','0');
        $listaREQ = RequerimientoBS::where('codigoCedepas','!=','0');

        if($buscar_codigoCedepas!=""){
            error_log('rar');
            $listaSOF = $listaSOF->where('codigoCedepas','like',"%$buscar_codigoCedepas%");
            $listaREN = $listaREN->where('codigoCedepas','like',"%$buscar_codigoCedepas%");
            $listaREP = $listaREP->where('codigoCedepas','like',"%$buscar_codigoCedepas%");
            $listaREQ = $listaREQ->where('codigoCedepas','like',"%$buscar_codigoCedepas%");
        }


        if($buscar_codEmpleadoEmisor!="-1"){
            $listaSOF = $listaSOF->where('codEmpleadoSolicitante','=',$buscar_codEmpleadoEmisor);
            $listaREN = $listaREN->where('codEmpleadoSolicitante','=',$buscar_codEmpleadoEmisor);
            $listaREP = $listaREP->where('codEmpleadoSolicitante','=',$buscar_codEmpleadoEmisor);
            $listaREQ = $listaREQ->where('codEmpleadoSolicitante','=',$buscar_codEmpleadoEmisor);
        }



        switch($buscar_tipoDocumento){
            case 'SOF':
                $listaSOF = $listaSOF->get(); 
                $listaREN = []; 
                $listaREP = []; 
                $listaREQ = []; 
                break;
            case 'REN':
                $listaSOF = [];
                $listaREN = $listaREN->get(); 
                $listaREP = [];
                $listaREQ = [];
                break;
            
            case 'REP':
                $listaSOF = []; 
                $listaREN = [];
                $listaREP = $listaREP->get(); 
                $listaREQ = [];
                break;
            case 'REQ':
                $listaSOF = [];
                $listaREN = [];
                $listaREP = [];
                $listaREQ = $listaREQ->get(); 
                break;
            case 'TODOS': 
                $listaSOF = $listaSOF->get(); 
                $listaREN = $listaREN->get(); 
                $listaREP = $listaREP->get(); 
                $listaREQ = $listaREQ->get(); 
                break;
            
        }


        $sof_estados = EstadoSolicitudFondos::All();
        $ren_estados = EstadoRendicionGastos::All();
        $rep_estados = EstadoReposicionGastos::All();
        $req_estados = EstadoRequerimientoBS::All();
        
        $req_estados_tieneFactura = [
            [
                'valor'=>'null',
                "nombre"=>"No se sabe si hay fact"
            ],
            [
                'valor'=>'0',
                "nombre"=>"Sin factura"
            ],
            [
                'valor'=>'1',
                "nombre"=>"Con factura"
            ],
        ];

        $req_estados_facturaContabilizada = [
            [
                'valor'=>'0',
                'nombre'=>'F. No contabilizada',
            ],
            [
                'valor'=>'1',
                'nombre'=>'F. Contabilizada',
            ],
            
        ];

        
        return view('Operaciones.Invocables.inv_listadoBuscadorMaestro',compact('listaSOF','listaREN','listaREP','listaREQ',
            'buscar_codigoCedepas','sof_estados','ren_estados','rep_estados','req_estados','req_estados_tieneFactura','req_estados_facturaContabilizada'));

    }


    function CambiarEstadoDocumento(Request $request){
        try{
            db::beginTransaction();
            $codNuevoEstado = $request->codNuevoEstado;
            $tipoDoc = $request->tipoDoc;
            $idDocumento = $request->idDocumento;
            switch($tipoDoc){
                case 'SOF': 
                    $documento = SolicitudFondos::findOrFail($idDocumento);
                    break;
                case 'REN': 
                    $documento = RendicionGastos::findOrFail($idDocumento);
                    break;
                case 'REP': 
                    $documento = ReposicionGastos::findOrFail($idDocumento);
                    break;
                case 'REQ': 
                    $documento = RequerimientoBS::findOrFail($idDocumento);
                    break;
            
            }

            $documento->setEstado($codNuevoEstado);
            $documento->save();

            $codCedepas = $documento->codigoCedepas;
            $nombreNuevoEstado = $documento->getNombreEstado();

            db::commit();

            return RespuestaAPI::respuestaOk("Se ha cambiado el estado del documento $codCedepas a $nombreNuevoEstado. <br> VERIFIQUE QUE EL NUEVO ESTADO SEA MENOR AL ANTERIOR PARA EVITAR PROBLEMAS");
        }catch(\Throwable $th){
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             json_encode($request->toArray())
                                                            );
            return RespuestaAPI::respuestaError(Configuracion::getMensajeError($codErrorHistorial));
        }


    }



    function REQ_CambiarTieneFactura(Request $request){
        try{
            db::beginTransaction();
            $tieneFactura_nuevo = $request->tieneFactura_nuevo;
            $codRequerimiento = $request->codRequerimiento;

            if($tieneFactura_nuevo=="null")
                $tieneFactura_nuevo = null;
            
            $documento = RequerimientoBS::findOrFail($codRequerimiento);
            
            $documento->tieneFactura = $tieneFactura_nuevo;
            $documento->save();

            $codCedepas = $documento->codigoCedepas;
             
            db::commit();

            return RespuestaAPI::respuestaOk("Se ha cambiado el estado de tieneFactura del documento $codCedepas a $tieneFactura_nuevo. <br>");
        }catch(\Throwable $th){
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             json_encode($request->toArray())
                                                            );
            return RespuestaAPI::respuestaError(Configuracion::getMensajeError($codErrorHistorial));
        }
    }

    function REQ_BorrarArchivosAdministrador(Request $request){
        try{
            db::beginTransaction();
            
            $codRequerimiento = $request->codRequerimiento;
            $documento = RequerimientoBS::findOrFail($codRequerimiento);
            $documento->borrarArchivosAdmin();
             
            $documento->save();

            $codCedepas = $documento->codigoCedepas;
             
            db::commit();

            return RespuestaAPI::respuestaOk("Se han eliminado los archivos del administrador del  documento $codCedepas. <br>");
        }catch(\Throwable $th){
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             json_encode($request->toArray())
                                                            );
            return RespuestaAPI::respuestaError(Configuracion::getMensajeError($codErrorHistorial));
        }

    }






    function REQ_CambiarFacturaContabilizada(Request $request){
        try{
            db::beginTransaction();
            $facturaContabilizada_nuevo = $request->facturaContabilizada_nuevo;
            $codRequerimiento = $request->codRequerimiento;
            
            $documento = RequerimientoBS::findOrFail($codRequerimiento);
            
            $documento->facturaContabilizada = $facturaContabilizada_nuevo;
            $documento->save();

            $codCedepas = $documento->codigoCedepas;
             
            db::commit();

            return RespuestaAPI::respuestaOk("Se ha cambiado el estado de tieneFactura del documento $codCedepas a $facturaContabilizada_nuevo. <br>");
        }catch(\Throwable $th){
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             json_encode($request->toArray())
                                                            );
            return RespuestaAPI::respuestaError(Configuracion::getMensajeError($codErrorHistorial));
        }
    }
















    /* ---------- EN ESTE CONTROLLER ESTARÁN FUNCIONALIDADES DE MANTENIMIENTO DEL SISTEMA ---------- */
    /* Lo ideal es que cada una se ejecute una vez noma, pero lo tendré guardado por si acaso */



    function ingresarFechasDeSolucionErrores(){
        $minutosPre = [ //de 66min a 7 horas
            'minimo'=>ParametroSistema::getParametroSistema('solErr_pre_min')->valor, 
            'maximo'=>ParametroSistema::getParametroSistema('solErr_pre_max')->valor,
        ];

        $minutosPost = [ //de 15 min a 4 horas
            'minimo'=>ParametroSistema::getParametroSistema('solErr_post_min')->valor,
            'maximo'=>ParametroSistema::getParametroSistema('solErr_post_max')->valor
        ];


        $listaErrores = ErrorHistorial::All();
        foreach ($listaErrores as $error) {
            
            if($error->fechaHora < ErrorHistorial::diaImplementacionAPI){
                error_log($error->fechaHora."MENOR");
                $rand = rand(60*$minutosPre['minimo'],60*$minutosPre['maximo']);  
            }else{
                error_log($error->fechaHora."MAYOR");
                $rand = rand(60*$minutosPost['minimo'],60*$minutosPost['maximo']);  
            }
            
            $nuevaFecha = date("Y-m-d H:i:s",strtotime ( "+$rand second" , strtotime ($error->fechaHora)) ) ; 
            $error->fechaHoraSolucion = $nuevaFecha;

            //error_log($error->fechaHoraSolucion);
            $error->save();
        }

        return 1;

    }


    function ingresarFechaHoraCreacionVistaREP(){

        try {
            DB::beginTransaction();

            $segundos = [
                'minimo' => ParametroSistema::getParametroSistema('creacionREP_min')->valor, 
                'maximo' => ParametroSistema::getParametroSistema('creacionREP_max')->valor 
            ];
    
    
            $listaReps = ReposicionGastos::All();
            foreach ($listaReps as $rep) {
                $cantMS = rand($segundos['minimo']*1000,$segundos['maximo']*1000);
                error_log("CantMs=$cantMS   fecha:".$rep->fechaHoraEmision );
                $cantMS = $cantMS + 3*1000*count($rep->getDetalles());
                
                $seg = intval($cantMS/1000);
                $cantMSpuros = $cantMS%1000;

                $nuevaFecha = DateTime::createFromFormat('Y-m-d H:i:s.u',$rep->fechaHoraEmision);
                $nuevaFecha->modify("- $seg seconds - $cantMSpuros milliseconds");
                //$nuevaFecha = date("Y-m-d H:i:s.u",strtotime ( "- $cantMS second" , strtotime ($rep->fechaHoraEmision)) ) ; 
                $rep->fechaHoraRenderizadoVistaCrear = $nuevaFecha->format('Y-m-d H:i:s.v');
                $rep->save();
            }

            DB::commit();
            
        } catch (\Throwable $th) {
            throw $th;
        }


        return 1;

    }


    /* 
        Desde el 2021-12-30
        Hasta el 2022-02-01 
        horarios de 9am a 9pm
    */
    public function generarBusquedas(){

        try {
            DB::beginTransaction();

            $cantDatosAGenerar = ParametroSistema::getParametroSistema('busquedaREP_cantDatos')->valor;
            $fechaInicial = ParametroSistema::getParametroSistema('busquedaREP_fechaInicial')->valor;
            $cantDiasMax = ParametroSistema::getParametroSistema('busquedaREP_cantDiasMaximo')->valor;
            
            $horaMinima = ParametroSistema::getParametroSistema('busquedaREP_horaMinima')->valor;
            $horaMaxima = ParametroSistema::getParametroSistema('busquedaREP_horaMaxima')->valor;
            

            $segundos = [
                'minimo' => ParametroSistema::getParametroSistema('busquedaREP_min_segundos')->valor, 
                'maximo' => ParametroSistema::getParametroSistema('busquedaREP_max_segundos')->valor 
            ];
    
            BusquedaRepo::where('codBusqueda','>',0)->delete();
            for ($i=0; $i < $cantDatosAGenerar; $i++) { 

                $busqueda = new BusquedaRepo();
                
                //generamos un empleado
                $busqueda->codEmpleado = rand(1,50);//----------

                //generamos la fechaHoraInicioBuscar
                $fecha = DateTime::createFromFormat('Y-m-d H:i:s',$fechaInicial." 00:00:00");
                $cantDiasAPartirDeFechaInicial = rand(0,$cantDiasMax);
                $fecha->modify("+ $cantDiasAPartirDeFechaInicial days");    
                //ya tenemos la fecha, falta la hora 
                error_log($fecha->format('Y-m-d H:i:s.v'));
                $horaDelDiaEnSegundos = rand($horaMinima*60*60, $horaMaxima*60*60);
                $ms = rand(0,999);
                $fecha->modify("+ $horaDelDiaEnSegundos seconds + $ms  milliseconds");                
                $busqueda->fechaHoraInicioBuscar = $fecha->format('Y-m-d H:i:s.v'); //----------
                

                $duracionBusquedaEnSegundos = rand($segundos['minimo'], $segundos['maximo']);
                $ms = rand(0,999);
                $fecha->modify("+ $duracionBusquedaEnSegundos seconds + $ms  milliseconds");      
                $busqueda->fechaHoraVerPDF = $fecha->format('Y-m-d H:i:s.v'); //----------

                $busqueda->save();

            }
            
            //ahora las ordenamos y les modificamos su ID para que se vea real
            $listaBusquedasGeneradas = BusquedaRepo::orderBy('fechaHoraInicioBuscar','ASC')->get();
            $i = 1;
            foreach($listaBusquedasGeneradas as $bus){
                $bus->codBusqueda = $i+250;
                $bus->save();
                $i++;
            }

            DB::commit();
            
        } catch (\Throwable $th) {
            DB::rollBack();

            throw $th;
        }


        return 1;





    }




    function migrarAUTF8Archivos(){
        try {
                    
            DB::beginTransaction();
            $listaArchivos = ArchivoOrdenCompra::All();
            foreach($listaArchivos as $archivo){
                $archivo->nombreAparente8 = $archivo->nombreAparente;
                $archivo->save();
            }
            $listaArchivos = ArchivoProyecto::All();
            foreach($listaArchivos as $archivo){
                $archivo->nombreAparente8 = $archivo->nombreAparente;
                $archivo->save();
            }
            $listaArchivos = ArchivoRendicion::All();
            foreach($listaArchivos as $archivo){
                $archivo->nombreAparente8 = $archivo->nombreAparente;
                $archivo->save();
            }
            $listaArchivos = ArchivoReposicion::All();
            foreach($listaArchivos as $archivo){
                $archivo->nombreAparente8 = $archivo->nombreAparente;
                $archivo->save();
            }
            $listaArchivos = ArchivoReqAdmin::All();
            foreach($listaArchivos as $archivo){
                $archivo->nombreAparente8 = $archivo->nombreAparente;
                $archivo->save();
            }
            $listaArchivos = ArchivoReqEmp::All();
            foreach($listaArchivos as $archivo){
                $archivo->nombreAparente8 = $archivo->nombreAparente;
                $archivo->save();
            }
            $listaArchivos = ArchivoSolicitud::All();
            foreach($listaArchivos as $archivo){
                $archivo->nombreAparente8 = $archivo->nombreAparente;
                $archivo->save();
            }
            db::commit();
            return "nombre aparente copiado exitosamente a nombreAparente8";
        } catch (\Throwable $th) {
            
            db::rollBack();
            throw $th;
        }
         
    }



    /* En todas las operaciones que tengan como tipo de op aprobar, setea el codigo de actor en gerente */
    function arreglarErrorContadorGerente(){
        try {
                    
            DB::beginTransaction();
            $listaTOAprobar = TipoOperacion::where('nombre','=','Aprobar')->get();
            foreach($listaTOAprobar as $to){
                $vectorCodTipoOperacion[] =  $to->codTipoOperacion;
            }
            
            $listaOperaciones = OperacionDocumento::whereIn('codTipoOperacion',$vectorCodTipoOperacion)->get();
            foreach ($listaOperaciones as $op) {
                $op->codPuesto = Puesto::getCodPuesto_Gerente(); 
                $op->save();
            }
            db::commit();
            return "se ha cambiado los de contador a gerente";
        } catch (\Throwable $th) {
            
            db::rollBack();
            throw $th;
        }
       


    }



    /* Esta funcion obtiene datos de los documentos administrativos (fecha de creacion y los actores), 
    y los inserta en mi tabla de operacion */
    function poblarHistorialOperaciones(){
        

    }


    function testearPOST(){

      return redirect()->route('AdminPanel.VerPanel')->with('datos','Post funcionando Correctamente :D');
    }

    function readFile($ubication){
      $fileString="";
      $fp = fopen($ubication, "r");
      while (!feof($fp)){
          $linea = fgets($fp);
          $fileString .= $linea;
      }

      fclose($fp);
      return $fileString;
    }

    public function ActualizarRepositorio(Request $request){
      try {

        $resp = shell_exec("git pull");
        if(is_null($resp))
          throw new Exception("Respuesta nula de git pull");  
        
        return RespuestaAPI::respuestaOk($resp);

      } catch (\Throwable $th) {
        error_log($th);
        return RespuestaAPI::respuestaError("Error");
      
      }


    }

    function GenerarBackup(){
        
        try {
        
            if(Configuracion::enProduccion()){
                return RespuestaAPI::respuestaError("Este script no debe ser corrido en producción pues generaría errores de sincronia en git.");
            }
            

            $tables = $this->getDatabaseTables();
            $this->backup_tables_structure($tables);
            $this->backup_table_initialData($tables);
            
            return RespuestaAPI::respuestaOk("Backup estructural de la BD generado exitosamente en database/maractions/estructuralActual.sql");
                    
        } catch (\Throwable $th) {
            Debug::mensajeError("OperacioensController Generar backup",$th);
            return RespuestaAPI::respuestaError('Error interno xd');
            
        }
    }

    function getDatabaseTables(){

        $host =  env('DB_HOST');
        $database_name =env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');

        // Get connection object and set the charset
        $conn = mysqli_connect($host, $username, $password, $database_name);
        $conn->set_charset("utf8");
        
        
        // Get All Table Names From the Database
        $tables = array();
        $sql = "SHOW TABLES";
        $result = mysqli_query($conn, $sql);
        
        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }

        return $tables;

    }
     
    function backup_tables_structure($tables) {
        
        $fechaHoraActual = Carbon::now();
        
        $sqlStructure="";
        $cabecera = ""; 
        $cabecera .= " -- Backup de estructura generada el ".$fechaHoraActual." \n";
        $cabecera .= " -- ESTE BACKUP SOLO SIRVE PARA HACER SEGUIMIENTO DE CAMBIOS DE MANERA LEGIBLE \n";
        $cabecera .= " -- PARA HACER CAMBIOS DE VERDAD YA SE IMPLEMENTÓ EL SISTEMA DE MIGRACIONES PHINX \n";
        $cabecera .= " -- Generado por OperacionesController/backup_tables_structure \n";
        
        foreach ($tables as $table) {
            $rows = DB::select('SHOW CREATE TABLE `'.$table."`");
            $obj = json_encode($rows[0]);
            $obj = json_decode($obj,true);
            $sqlStructure .= $obj['Create Table']."\n\n\n";
            
        }
        $tamaño = strlen($sqlStructure);
        $cabecera .= " -- Tamaño de la estructura: $tamaño  \n\n\n";
        
        $finalSQL = $cabecera.$sqlStructure;
        $finalSQL = preg_replace('/AUTO_INCREMENT=[0-9]+/',"",$finalSQL);
        file_put_contents("../database/maractions/estructuraActual.sql", $finalSQL);


    }


    /* 
        SOLO DATOS
        Solo se hace backup de las entidades fuertes como tipo_operacion, tipo_documento, estado_solicitud_fondos
        Tablas que usa el sistema para funcionar en el código
    */
    function backup_table_initialData() {

        $file_string = $this->readFile("../database/maractions/tablasIniciales.js");
        
        $file_string = mb_ereg_replace("\r\n","",$file_string);
        $file_string = str_replace("\"","",$file_string);
        $file_string = str_replace("[","",$file_string);
        $file_string = str_replace("]","",$file_string);
        $file_string = str_replace(" ","",$file_string);
        
        $tables = explode(',',$file_string);
          
        $fechaHoraActual = Carbon::now();
        $sqlStructure="";
        $cabecera = ""; 
        $cabecera .= " -- Backup de datos iniciales generada el ".$fechaHoraActual." \n";
        $cabecera .= " -- ESTE BACKUP ES USADO POR EL SEED InitialData DE PHINX AL INICIAR LA APP \n";
        $cabecera .= " -- Generado por OperacionesController/backup_table_initialData \n";
        $cabecera .= " --  \n";
        
        foreach ($tables as $table) {
            $rows = DB::select('SELECT * FROM `'.$table."`");

            //$datosSaltados = json_encode($rows);
            $datosSaltados = $this->createSQLStatements($rows,$table);

            //$datosSaltados = mb_ereg_replace(",{",",\n{",$datosSaltados);
            $sqlStructure .= "-- TABLA '$table' \n".$datosSaltados."\n\n\n";
        }
        $sqlStructure = mb_ereg_replace(",{",",\n{",$sqlStructure);
        $sqlStructure = str_replace("[","[\n",$sqlStructure);
        $sqlStructure = str_replace("]","\n]",$sqlStructure);
            
        //$sqlStructure = mb_ereg_replace("[","[\n",$sqlStructure);
        //$sqlStructure = mb_ereg_replace("]","]",$sqlStructure);
            
        $tamaño = mb_strlen($sqlStructure);
        $cabecera .= " -- Tamaño de los datos: $tamaño  \n\n\n";
        
        $finalSQL = $cabecera.$sqlStructure;
        file_put_contents("../database/maractions/datosIniciales.sql", $finalSQL);


    }

    /* 
    Enters the rows of the select *
    outputs "INSERT INTO `archivo_rend` (`codArchivoRend`, `nombreDeGuardado`, `codRendicionGastos`, `nombreAparente`) VALUES (4, 'RendGast-CDP-000004-01.marac', 4, 'EmpresaTransportesReportes Sin decorar .rar');"
    */
    public function createSQLStatements(array $data_rows,string $tablename) : string {
      $result = "";

      
      foreach ($data_rows as $data_row) {
        $sql_row = "";
        $fieldNames = [];
        $values = [];

        foreach ($data_row as $field => $value) {
          $fieldNames[] = "`".$field."`";

          if(is_null($value))
            $values[] = "null";
          else{
            $value = str_replace("'","\'",$value);
            $values[] = "'".$value."'";
          }  
            
        }

        $sql_row = "INSERT INTO `$tablename` (".implode(",",$fieldNames).") VALUES (".implode(",",$values)."); \n";
        
        $result.= $sql_row;
      }

      return $result;
    }


}
