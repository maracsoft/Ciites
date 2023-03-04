<?php

namespace App\Http\Controllers;
use App\Configuracion;
use App\ArchivoReposicion;
use App\Banco;
use App\BusquedaRepo;
use App\CDP;
use App\Debug;
use App\DetalleReposicionGastos;
use App\Empleado;
use App\ErrorHistorial;
use App\EstadoReposicionGastos;
use App\EstadoSolicitudFondos;
use App\Http\Controllers\Controller;
use App\Moneda;
use App\Proyecto;
use App\ProyectoContador;
use Exception;
use App\Puesto;
use App\ReposicionGastos;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Numeracion;
use App\ProyectoObservador;
use App\SolicitudFondos;
use App\TipoOperacion;
use App\UI\UIFiltros;
use Illuminate\Support\Collection;

class ReposicionGastosController extends Controller
{
    const PAGINATION = 20;

    public function listarReposiciones(){

        $empleado = Empleado::getEmpleadoLogeado();
        $msj = session('datos');
        $datos='';
        if($msj!='')
            $datos = 'datos';

        if($empleado->esGerente()){
            return redirect()->route('ReposicionGastos.Gerente.Listar')->with($datos,$msj);
        }
        if($empleado->esJefeAdmin()){
            return redirect()->route('ReposicionGastos.Administracion.Listar')->with($datos,$msj);
        }
        if($empleado->esContador()){
            return redirect()->route('ReposicionGastos.Contador.Listar')->with($datos,$msj);
        }
        return redirect()->route('ReposicionGastos.Empleado.Listar')->with($datos,$msj);

    }

    //funcion servicio, será consumida solo por javascript
    public function listarDetalles($idReposicion){
        $vector = [];
        $listaDetalles = DetalleReposicionGastos::where('codReposicionGastos','=',$idReposicion)->get();
        for ($i=0; $i < count($listaDetalles) ; $i++) { 
            
            $itemDet = $listaDetalles[$i];
            $itemDet['nombreTipoCDP'] = $itemDet->getNombreTipoCDP(); //tengo que pasarlo aqui pq en el javascript no hay manera de calcularlo, de todas maneras no lo usaré como Modelo (objeto)
            
                // formato dado por sql 2021-02-11   
                //formato requerido por mi  12/02/2020
                $fechaDet = $itemDet->fechaComprobante;
                //DAMOS VUELTA A LA FECHA
                                // DIA                  MES                 AÑO
            $nuevaFecha=substr($fechaDet,8,2).'/'.substr($fechaDet,5,2).'/'.substr($fechaDet,0,4);
            $itemDet['fechaFormateada'] = $nuevaFecha;
            array_push($vector,$itemDet);            
        }
        return $vector  ;
    }



    function rellernarCerosIzq($numero, $nDigitos){
        return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);
    }
    /**EMPLEADO */


    public function ListarConFiltroDeEmpleado(Request $request){

        if(!BusquedaRepo::hayBusquedaActiva())
            BusquedaRepo::iniciarBusqueda();

        return $this->listarOfEmpleado($request);
    }

    public function listarOfEmpleado(Request $request){

        $empleado=Empleado::getEmpleadoLogeado();
          
        $listaReposiciones = ReposicionGastos::where('codEmpleadoSolicitante','=',$empleado->getId());
        
        $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaReposiciones,$request->getQueryString());
          
        $listaReposiciones = UIFiltros::buildQuery($listaReposiciones,$request->getQueryString());
        $filtros_usados = UIFiltros::getQueryValues($listaReposiciones,$request->getQueryString());

        $listaReposiciones = ReposicionGastos::ordenarParaEmpleado($listaReposiciones)->paginate($this::PAGINATION);
 
        $proyectos=Proyecto::getProyectosActivos();
         
        return view('ReposicionGastos.Empleado.ListarReposiciones',
            compact('listaReposiciones','empleado','proyectos','filtros_usados_paginacion','filtros_usados' ));
    }


    public function view($id){
         
        $reposicion=ReposicionGastos::find($id);
        $detalles=$reposicion->detalles();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();

        if($reposicion->codEmpleadoSolicitante != Empleado::getEmpleadoLogeado()->codEmpleado){
            return redirect()->route('error')->with('datos','Las reposiciones solo pueden ser vistas por su creador.');
        }

        return view('ReposicionGastos.Empleado.VerReposicionGastos',compact('reposicion','empleadoLogeado','detalles'));
    }


    public function create(){
        $listaCDP = CDP::All();
        $proyectos = Proyecto::getProyectosActivos();
        $monedas=Moneda::All();
        $bancos=Banco::All();
        $empleadosEvaluadores=Empleado::where('activo','!=',0)->get();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();
        $objNumeracion = Numeracion::getNumeracionREP();

        $now = DateTime::createFromFormat('U.u', microtime(true));
        $now->modify("- 5 hours"); //para pasarlo a UTC-5
        $fechaHoraRenderizadoVistaCrear = $now->format("Y-m-d H:i:s.v");
        //error_log($fechaHoraRenderizadoVistaCrear);

        return view('ReposicionGastos.Empleado.CrearReposicionGastos',compact('empleadoLogeado','listaCDP','proyectos',
            'objNumeracion','empleadosEvaluadores','monedas','bancos','fechaHoraRenderizadoVistaCrear'));
    }


    public function editar($id){
        $reposicion = ReposicionGastos::findOrFail($id);
        $listaCDP = CDP::All();
        $proyectos = Proyecto::getProyectosActivos();
        $monedas=Moneda::All();
        $bancos=Banco::All();
        $empleadosEvaluadores=Empleado::where('activo','!=',0)->get();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();

        if($reposicion->codEmpleadoSolicitante != Empleado::getEmpleadoLogeado()->codEmpleado){
            return redirect()->route('error')->with('datos','Las reposiciones solo pueden ser editadas por su creador.');
        }

        return view('ReposicionGastos.Empleado.EditarReposicionGastos',compact('empleadoLogeado','listaCDP','proyectos',
            'empleadosEvaluadores','monedas','bancos','reposicion'));


    }




    /*  
    ALMACENAR LOS DATOS Y LOS ARCHIVOS DE DETALLES QUE ESTAN SUBIENDO
    CADA ARCHIVO ES UNA FOTO DE UN CDP, pero están independientes xd o sea un archivo no está ligado necesariamente a un item de gasto 

    https://www.itsolutionstuff.com/post/laravel-7-multiple-file-upload-tutorialexample.html
    */
    public function store(Request $request){
         
        try{
            DB::beginTransaction(); 
            $reposicion=new ReposicionGastos();
            $reposicion->codEstadoReposicion=1;
            $reposicion->codEmpleadoSolicitante=Empleado::getEmpleadoLogeado()->codEmpleado;
            //$reposicion->codEmpleadoEvaluador=Proyecto::find($request->codProyecto)->codEmpleadoDirector;
            $reposicion->codProyecto=$request->codProyecto;
            $reposicion->codMoneda=$request->codMoneda;
            
            $reposicion->fechaHoraRenderizadoVistaCrear = $request->fechaHoraRenderizadoVistaCrear;

            $now = DateTime::createFromFormat('U.u', microtime(true));
            $now->modify("- 5 hours"); //para pasarlo a UTC-5
            $reposicion->fechaHoraEmision= $now->format("Y-m-d H:i:s.v");

            $reposicion->girarAOrdenDe=$request->girarAOrdenDe;
            $reposicion->numeroCuentaBanco=$request->numeroCuentaBanco;
            $reposicion->codigoContrapartida=$request->codigoContrapartida;
            
            $reposicion->codBanco=$request->codBanco;
            $reposicion->resumen=$request->resumen;
            $reposicion->fechaHoraRevisionGerente=null;
            $reposicion->fechaHoraRevisionAdmin=null;
            $reposicion->observacion=null;
    
            $reposicion->codigoCedepas = ReposicionGastos::calcularCodigoCedepas(Numeracion::getNumeracionREP());
            Numeracion::aumentarNumeracionREP();

            $reposicion->save();

            $reposicion->registrarOperacion(
                TipoOperacion::getCodTipoOperacion('REP','Crear'),
                null, 
                Puesto::getCodPuesto_Empleado()); //siempre creará el empleado


            $codRepRecienInsertada = (ReposicionGastos::latest('codReposicionGastos')->first())->codReposicionGastos;
            
            //creacion de detalles
            $vec[] = '';
            $total=0;
                
            if($request->cantElementos==0)
                throw new Exception("No se ingresó ningún item.", 1);
             

            $i = 0;
            $cantidadFilas = $request->cantElementos;
            while ($i< $cantidadFilas ) 
            {
                    $detalle=new DetalleReposicionGastos();
                    $detalle->codReposicionGastos=$reposicion->codReposicionGastos ;//ultimo insertad
                    // formato requerido por sql 2021-02-11   
                    //formato dado por mi calnedar 12/02/2020
                    $fechaDet = $request->get('colFecha'.$i);
                    //DAMOS VUELTA A LA FECHA
                                                // AÑO                  MES                 DIA
                    $detalle->fechaComprobante=   substr($fechaDet,6,4).'-'.substr($fechaDet,3,2).'-'.substr($fechaDet,0,2);
                
                    
                    $detalle->setTipoCDPPorNombre( $request->get('colTipo'.$i) );
                    $detalle->nroComprobante=        $request->get('colComprobante'.$i);
                    $detalle->concepto=              $request->get('colConcepto'.$i);
                    $detalle->importe=               $request->get('colImporte'.$i);
                    $total+=(float)$request->get('colImporte'.$i);
                    $detalle->codigoPresupuestal  =  $request->get('colCodigoPresupuestal'.$i);   
                    $detalle->nroEnReposicion = $i+1;
                    $detalle->save();  
                    $i=$i+1;
            }
            $reposicion->totalImporte=$total;
            $reposicion->save();
            
            //$nombresArchivos = explode(', ',$request->nombresArchivos);
            $nombresArchivos = json_decode($request->nombresArchivos); //ahora llega un vector en JSON ["archivo1.pdf","archivo2.pdf"]
                 
            $j=0;
            
            foreach ($request->file('filenames') as $archivo)
            {   
                
                $nombreArchivoGuardado = $reposicion->getNombreGuardadoNuevoArchivo($j+1);
                Debug::mensajeSimple('el nombre de guardado de la imagen es:'.$nombreArchivoGuardado);

                
                $archivoRepo = new ArchivoReposicion();
                $archivoRepo->codReposicionGastos = $reposicion->codReposicionGastos;
                $archivoRepo->nombreDeGuardado = $nombreArchivoGuardado;
                $archivoRepo->nombreAparente = $nombresArchivos[$j];
                $archivoRepo->save();

                $fileget = \File::get( $archivo );
                
                Storage::disk('reposiciones')
                ->put($nombreArchivoGuardado,$fileget );
                $j++;
            }

            
            $reposicion->cantArchivos = $j-1; //ESTO YA NO SE USARÁ
            $terminacionesArchivos = "";    //ESTO YA NO SE USARÁ
            $reposicion->save();

            DB::commit();
            return redirect()->route('ReposicionGastos.Empleado.Listar')
                ->with('datos','Se ha registrado la reposicion N°'.$reposicion->codigoCedepas);
        }catch(\Throwable $th){
            
            Debug::mensajeError('REPOSICION GASTOS CONTROLLER STORE', $th);
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             json_encode($request->toArray())
                                                            );
            
            return redirect()->route('ReposicionGastos.Empleado.Listar')
            ->with('datos',Configuracion::getMensajeError($codErrorHistorial));
        }
        
    }





    
    public function update( Request $request){
        
        try {
            $reposicion=ReposicionGastos::findOrFail($request->codReposicionGastos);


            if($reposicion->codEmpleadoSolicitante != Empleado::getEmpleadoLogeado()->codEmpleado)
            return redirect()->route('ReposicionGastos.Listar')
                ->with('datos','Error: la reposición no puede ser actualizada por un empleado distinto al que la creó.');



            if(!$reposicion->listaParaActualizar())
            return redirect()->route('ReposicionGastos.Listar')
                ->with('datos','Error: la reposición no puede ser actualizada ahora puesto que está en otro proceso.');

                






            $reposicion->codProyecto=$request->codProyecto;
            $reposicion->codMoneda=$request->codMoneda;
     
            $reposicion->girarAOrdenDe=$request->girarAOrdenDe;
            $reposicion->numeroCuentaBanco=$request->numeroCuentaBanco;
            $reposicion->codigoContrapartida=$request->codigoContrapartida;


            $reposicion->codBanco=$request->codBanco;
            $reposicion->resumen=$request->resumen;
            //si estaba observada, pasa a subsanada
            if($reposicion->verificarEstado('Observada'))
                $reposicion-> codEstadoReposicion = ReposicionGastos::getCodEstado('Subsanada');
            else
                $reposicion-> codEstadoReposicion = ReposicionGastos::getCodEstado('Creada');
            $reposicion-> save();        
            
            $reposicion->registrarOperacion(
                TipoOperacion::getCodTipoOperacion('REP','Editar'),
                null, 
                Puesto::getCodPuesto_Empleado()); //siempre EditarA el empleado
                


            $total=0;
            //borramos todos los detalles pq los ingresaremos again
            //DB::select('delete from detalle_reposicion_gastos where codReposicionGastos=" '.$reposicion->codReposicionGastos.'"');
            DetalleReposicionGastos::where('codReposicionGastos','=',$reposicion->codReposicionGastos)->delete();

            if($request->cantElementos==0)
                throw new Exception("No se ingresó ningún item.", 1);
             

            //RECORREMOS la tabla con gastos 
            $i = 0;
            $cantidadFilas = $request->cantElementos;
            while ($i< $cantidadFilas ) {
                $detalle=new DetalleReposicionGastos();
                $detalle->codReposicionGastos=          $reposicion->codReposicionGastos ;//ultimo insertad
                // formato requerido por sql 2021-02-11   
                //formato dado por mi calnedar 12/02/2020


                $fechaDet = $request->get('colFecha'.$i);
                //DAMOS VUELTA A LA FECHA
                                                // AÑO                  MES                 DIA
                $detalle->fechaComprobante=   substr($fechaDet,6,4).'-'.substr($fechaDet,3,2).'-'.substr($fechaDet,0,2);
                //Debug::mensajeSimple('----'.$detalle->fechaComprobante);


                $detalle->setTipoCDPPorNombre( $request->get('colTipo'.$i) );
                $detalle->nroComprobante=        $request->get('colComprobante'.$i);
                $detalle->concepto=              $request->get('colConcepto'.$i);
                $detalle->importe=               $request->get('colImporte'.$i);    
                $total+=(float)$request->get('colImporte'.$i);
                $detalle->codigoPresupuestal  =  $request->get('colCodigoPresupuestal'.$i);   
                $detalle->nroEnReposicion = $i+1;          
                $i=$i+1;
                $detalle->save();

            }  
            $reposicion->totalImporte=$total;
            $reposicion->save();  

            
            //SOLO BORRAMOS TODO E INSERTAMOS NUEVOS ARCHIVOS SI ES QUE SE INGRESÓ NUEVOS
            if( !is_null($request->nombresArchivos) && $request->nombresArchivos!="[]" ){ //SI NO ES NULO Y No está vacio
            

                Debug::mensajeSimple("o yara/".$request->tipoIngresoArchivos);
                if($request->tipoIngresoArchivos=="1")
                {//AÑADIR
                    
                }else{//SOBRESRIBIR
                    $reposicion->borrarArchivosCDP();  //A
                }

                $cantidadArchivosYaExistentes = $reposicion->getCantidadArchivos();


                //$nombresArchivos = explode(', ',$request->nombresArchivos); 
                $nombresArchivos = json_decode($request->nombresArchivos); //ahora llega un vector en JSON ["archivo1.pdf","archivo2.pdf"]
                 
                /* BUG BUG BUG BUG BUG BUG BUG BUG BUG BUG BUG BUG BUG BUG BUG BUG BUG BUG BUG BUG  */

                $j=0; //A
                Debug::mensajeSimple($request->nombresArchivos);

                foreach ($request->file('filenames') as $archivo)
                {   
                    
                    $nombreArchivoGuardado = $reposicion->getNombreGuardadoNuevoArchivo($cantidadArchivosYaExistentes + $j+1);
                    Debug::mensajeSimple('NombreAparente:'.$archivo->getBasename().' Nombre de guardado de la imagen es:'.$nombreArchivoGuardado);
                    
                    
                    $archivoRepo = new ArchivoReposicion();
                    $archivoRepo->codReposicionGastos = $reposicion->codReposicionGastos;
                    $archivoRepo->nombreDeGuardado = $nombreArchivoGuardado;
                    $archivoRepo->nombreAparente = $nombresArchivos[$j];
                    $archivoRepo->save();


                    $fileget = \File::get( $archivo );
                    
                    Storage::disk('reposiciones')
                    ->put($nombreArchivoGuardado,$fileget );
                    $j++;
                }

                
            }
            $reposicion->save();
            


            DB::commit();  
            return redirect()
                ->route('ReposicionGastos.Empleado.Listar')
                ->with('datos','Se ha editado la reposición N°'.$reposicion->codigoCedepas);
        }catch(\Throwable $th){
            Debug::mensajeError(' REPOSICION GASTOS CONTROLLER UPDATE' ,$th);
            
            DB::rollback();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             json_encode($request->toArray())
                                                            );
            return redirect()
                ->route('ReposicionGastos.Empleado.Listar')
                ->with('datos',Configuracion::getMensajeError($codErrorHistorial));
        }

        

    }




    public function listarReposicionesParaObservador(Request $request){

        
      $empleado = Empleado::getEmpleadoLogeado();

      $listaProyectoObservador = ProyectoObservador::where('codEmpleadoObservador',$empleado->getId())->get();
      $estadosReposicion = EstadoReposicionGastos::All();


      $codsProyectos = [];
      foreach ($listaProyectoObservador as $proy_obs) {
        $codsProyectos[] = $proy_obs->codProyecto;
      }

      if(count($codsProyectos)==0)
          return redirect()->route('error')->with('datos', "No tiene ningún proyecto asignado para observar.");


      $proyectosDelObservador = Proyecto::whereIn('codProyecto',$codsProyectos)->orderBy('codigoPresupuestal','ASC')->get();
      $proyectosDelObservador = Proyecto::añadirNombreYcod($proyectosDelObservador);
      
      $listaReposiciones = ReposicionGastos::whereIn('codProyecto',$codsProyectos);
      $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaReposiciones,$request->getQueryString());

      $listaReposiciones = UIFiltros::buildQuery($listaReposiciones,$request->getQueryString());
      $filtros_usados = UIFiltros::getQueryValues($listaReposiciones,$request->getQueryString());
      
      $listaReposiciones = $listaReposiciones->orderBy('codReposicionGastos','DESC')->paginate($this::PAGINATION);

      $empleados=Empleado::getListaEmpleadosPorApellido();
      $listaBancos = Banco::All();
      
      return view('ReposicionGastos.Observador.ListarReposiciones',compact('filtros_usados_paginacion','filtros_usados','proyectosDelObservador','estadosReposicion',
          'listaReposiciones','listaBancos','empleado','empleados'));


    }



    public function verReposicionComoObservador($id){
      
      $reposicion=ReposicionGastos::find($id);
      $detalles=$reposicion->detalles();
      $empleadoLogeado = Empleado::getEmpleadoLogeado();
      return view('ReposicionGastos.Observador.VerReposicion',compact('reposicion','empleadoLogeado','detalles'));
    }







    /**GERENTE DE PROYECTOS */
    public function listarOfGerente(Request $request){
       

        $empleado=Empleado::getEmpleadoLogeado();
        $proyectos= $empleado->getListaProyectos();
        
        if(count($proyectos)==0)
            return redirect()->route('error')->with('datos',"No tiene ningún proyecto asignado...");
        
        $arrayCodsProyectos=[];
        foreach ($proyectos as $itemproyecto) {
            $arrayCodsProyectos[]=$itemproyecto->codProyecto;
        }
        
        $listaReposiciones = ReposicionGastos::whereIn('codProyecto',$arrayCodsProyectos);
        
        $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaReposiciones,$request->getQueryString());
          
        $listaReposiciones = UIFiltros::buildQuery($listaReposiciones,$request->getQueryString());
        $filtros_usados = UIFiltros::getQueryValues($listaReposiciones,$request->getQueryString());

      
        $listaReposiciones= ReposicionGastos::ordenarParaGerente($listaReposiciones)->paginate($this::PAGINATION);
        

        $empleados=Empleado::getListaEmpleadosPorApellido();
         
        $fechaInicio=$request->fechaInicio;
        $fechaFin=$request->fechaFin;

        return view('ReposicionGastos.Gerente.ListarReposiciones',compact('listaReposiciones','proyectos','empleado','empleados','filtros_usados_paginacion','filtros_usados'));
    }



    

    public function viewGeren($id){
      
        $reposicion=ReposicionGastos::findOrFail($id);
        $detalles=$reposicion->detalles();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();

        return view('ReposicionGastos.Gerente.EvaluarReposicionGastos',compact('reposicion','empleadoLogeado','detalles'));
    }


    function eliminarArchivo($codArchivoRepo){
        
        try{
            $archivo = ArchivoReposicion::findOrFail($codArchivoRepo);
        }catch (\Throwable $th) {
            return redirect()->route('ReposicionGastos.Empleado.Listar')
                ->with('datos','ERROR: El archivo que desea eliminar no existe o ya ha sido eliminado, vuelva a la página de editar Reposición.');
        }

        try {
            db::beginTransaction();
            
            $nombreArchivEliminado = $archivo->nombreAparente;
            $repo = ReposicionGastos::findOrFail($archivo->codReposicionGastos);

            if($repo->codEmpleadoSolicitante != Empleado::getEmpleadoLogeado()->codEmpleado)
                throw new Exception("Solo el dueño de la Reposición puede eliminar sus archivos.", 1);
            

            $archivo->eliminarArchivo();
            DB::commit();
        
            return redirect()->route('ReposicionGastos.Empleado.editar',$repo->codReposicionGastos)->with('datos','Archivo "'.$nombreArchivEliminado.'" eliminado exitosamente.');
        } catch (\Throwable $th) {
            Debug::mensajeError(' REPOSICION GASTOS CONTROLLER Eliminar archivo' ,$th);    
            DB::rollback();
            $codErrorHistorial=ErrorHistorial::registrarError($th, app('request')->route()->getAction(),$codArchivoRepo);
            return redirect()->route('ReposicionGastos.Empleado.editar',$repo->codReposicionGastos)->with('datos',Configuracion::getMensajeError($codErrorHistorial));
        }
        


    }

    //se le pasa el codArchivoRepo del archivo 
    function descargarCDP($codArchivoRepo){
        $archivoRepo = ArchivoReposicion::findOrFail($codArchivoRepo);
        return Storage::download("/comprobantes/reposiciones/".$archivoRepo->nombreDeGuardado,$archivoRepo->nombreAparente);

    }






    
    
    /**JEFE DE ADMINISTRACION */
    public function listarOfJefe(Request $request){
        $empleado=Empleado::getEmpleadoLogeado();
        $empleados=Empleado::getListaEmpleadosPorApellido();
        
        $listaReposiciones=ReposicionGastos::query();
        $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaReposiciones,$request->getQueryString());
          
        $listaReposiciones = UIFiltros::buildQuery($listaReposiciones,$request->getQueryString());
        $filtros_usados = UIFiltros::getQueryValues($listaReposiciones,$request->getQueryString());

        $listaReposiciones= ReposicionGastos::ordenarParaAdministrador($listaReposiciones)->paginate($this::PAGINATION);
        
        $proyectos=Proyecto::getProyectosActivos();

        
        return view('ReposicionGastos.Jefe.ListarReposiciones',compact('listaReposiciones','empleado','proyectos','empleados','filtros_usados_paginacion','filtros_usados'));
    }



    public function viewJefe($id){
         
        $reposicion=ReposicionGastos::find($id);
        $detalles=$reposicion->detalles();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();
        return view('ReposicionGastos.Jefe.AbonarReposicionGastos',compact('reposicion','empleadoLogeado','detalles'));
    }

    /**CONTADOR */
    public function listarOfConta(Request $request){
       
        
        $empleado=Empleado::getEmpleadoLogeado();
        $detallesProyectoContador=ProyectoContador::where('codEmpleadoContador','=',$empleado->codEmpleado)->get();
        if(count($detallesProyectoContador)==0)
            return redirect()->route('error')->with('datos',"No tiene ningún proyecto asignado...");
          
        $arrayCodProyectosDelContador=[];
        foreach ($detallesProyectoContador as $itemproyecto) {
            $arrayCodProyectosDelContador[]=$itemproyecto->codProyecto;
        }
        
        

        $arrayEstados=[ReposicionGastos::getCodEstado('Abonada'),ReposicionGastos::getCodEstado('Contabilizada'),ReposicionGastos::getCodEstado('Observada')];
      

        
        $listaReposiciones = ReposicionGastos::whereIn('codProyecto',$arrayCodProyectosDelContador)->whereIn('reposicion_gastos.codEstadoReposicion',$arrayEstados);

        $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaReposiciones,$request->getQueryString());
          
        $listaReposiciones = UIFiltros::buildQuery($listaReposiciones,$request->getQueryString());
        $filtros_usados = UIFiltros::getQueryValues($listaReposiciones,$request->getQueryString());

        $listaReposiciones= ReposicionGastos::ordenarParaContador($listaReposiciones)->paginate($this::PAGINATION);
        
        
        $proyectos= Proyecto::añadirNombreYcod(Proyecto::whereIn('codProyecto',$arrayCodProyectosDelContador)->get());
        
        
        $empleados=Empleado::getListaEmpleadosPorApellido();
      

        return view('ReposicionGastos.Contador.ListarReposiciones',compact('listaReposiciones','empleado','proyectos','empleados','filtros_usados_paginacion','filtros_usados'));
    }















    public function viewConta($id){
        $reposicion=ReposicionGastos::find($id);
        $detalles=$reposicion->detalles();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();

        return view('ReposicionGastos.Contador.ContabilizarReposicionGastos',compact('reposicion','empleadoLogeado','detalles'));
    }



    public function aprobar(Request $request){//gerente
        //return $request;
        try{
            DB::beginTransaction();
            $reposicion=ReposicionGastos::find($request->codReposicionGastos);

            
            if(!$reposicion->listaParaAprobar())
            return redirect()->route('ReposicionGastos.Listar')
                ->with('datos','Error: la reposición no puede ser aprobada ahora puesto que está en otro proceso.');


            $reposicion->codEstadoReposicion =  ReposicionGastos::getCodEstado('Aprobada');
            $reposicion->codEmpleadoEvaluador=Empleado::getEmpleadoLogeado()->codEmpleado;
            $reposicion->resumen = $request->resumen;
            $reposicion->fechaHoraRevisionGerente=new DateTime();
            $reposicion->save();

            $reposicion->registrarOperacion(
                TipoOperacion::getCodTipoOperacion('REP','Aprobar'),
                null, 
                Puesto::getCodPuesto_Gerente()); //siempre Aprobara el gerente
               
            
            $listaDetalles = DetalleReposicionGastos::where('codReposicionGastos','=',$reposicion->codReposicionGastos)->get();
            foreach($listaDetalles as $itemDetalle ){
                $itemDetalle->codigoPresupuestal = $request->get('CodigoPresupuestal'.$itemDetalle->codDetalleReposicion);
                $itemDetalle->save();
            }


            DB::commit();
            
            
            
            
            
            //return redirect()->route('ReposicionGastos.Gerente.Listar')->with('datos','Se aprobo correctamente la Reposicion '.$reposicion->codigoCedepas);
            return redirect()->route('ReposicionGastos.Listar')->with('datos','Se aprobó correctamente la Reposición '.$reposicion->codigoCedepas);
        }catch(\Throwable $th){
            Debug::mensajeError('REPOSICION GASTOS aprobar', $th);
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             json_encode($request->toArray())
                                                            );
            //return redirect()->route('ReposicionGastos.Gerente.Listar')->with('datos','Ha ocurrido un error');
            return redirect()->route('ReposicionGastos.Listar')->with('datos',Configuracion::getMensajeError($codErrorHistorial));
        }
    }
    public function abonar($id){//jefe (codReposicion)
        try{
            DB::beginTransaction();
  
            $reposicion=ReposicionGastos::findOrFail($id);

            if(!$reposicion->listaParaAbonar())
            return redirect()->route('ReposicionGastos.Listar')
                ->with('datos','Error: la reposición no puede ser abonada ahora puesto que está en otro proceso.');


            $reposicion->codEstadoReposicion=ReposicionGastos::getCodEstado('Abonada');
            $reposicion->codEmpleadoAdmin=Empleado::getEmpleadoLogeado()->codEmpleado;
            $reposicion->fechaHoraRevisionAdmin=new DateTime();
            $reposicion->save();

            $reposicion->registrarOperacion(
                TipoOperacion::getCodTipoOperacion('REP','Abonar'),
                null, 
                Puesto::getCodPuesto_Administrador()); //siempre abonará el gerente
              

            DB::commit();
            
            return redirect()->route('ReposicionGastos.Administracion.Listar')->with('datos','Se abonó correctamente la Reposición '.$reposicion->codigoCedepas);
        }catch(\Throwable $th){
            Debug::mensajeError('REPOSIC GASTOS CONTROLLER ABONAR', $th);
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th, app('request')->route()->getAction(),$id);
            //return redirect()->route('ReposicionGastos.Administracion.Listar')->with('datos','Ha ocurrido un error');
            return redirect()->route('ReposicionGastos.Administracion.Listar')->with('datos',Configuracion::getMensajeError($codErrorHistorial));

        }
    }
    public function observarComoGerente(Request $request){

      try{
        DB::beginTransaction();
        
        $reposicion=ReposicionGastos::find($request->codReposicionGastosModal);

        if(!$reposicion->listaParaObservar())
          return redirect()->route('ReposicionGastos.Gerente.Listar')->with('datos','Error: la reposición no puede ser observada ahora puesto que está en otro proceso.');

        $this->observarGenerico($reposicion,$request->observacion,Puesto::getCodPuesto_Gerente());

        DB::commit();
        
        return redirect()->route('ReposicionGastos.Gerente.Listar')->with('datos','Se observó correctamente la Reposición '.$reposicion->codigoCedepas);
          
      }catch(\Throwable $th){
        DB::rollBack();
        $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                          app('request')->route()->getAction(),
                                                          json_encode($request->toArray())
                                                        );
        
        return redirect()->route('ReposicionGastos.Gerente.Listar')->with('datos',Configuracion::getMensajeError($codErrorHistorial));
      }

    }

    public function observarComoAdministrador(Request $request){


      try{
        DB::beginTransaction();
        
        $reposicion=ReposicionGastos::find($request->codReposicionGastosModal);

        if(!$reposicion->listaParaObservar())
          return redirect()->route('ReposicionGastos.Administracion.Listar')->with('datos','Error: la reposición no puede ser observada ahora puesto que está en otro proceso.');

        $this->observarGenerico($reposicion,$request->observacion,Puesto::getCodPuesto_Administrador());

        DB::commit();
        
        return redirect()->route('ReposicionGastos.Administracion.Listar')->with('datos','Se observó correctamente la Reposición '.$reposicion->codigoCedepas);
          
      }catch(\Throwable $th){
        DB::rollBack();
        $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                          app('request')->route()->getAction(),
                                                          json_encode($request->toArray())
                                                        );
        
        return redirect()->route('ReposicionGastos.Administracion.Listar')->with('datos',Configuracion::getMensajeError($codErrorHistorial));
      }


    }


    private function observarGenerico(ReposicionGastos $reposicion ,$textoObservacion,$codPuesto){//gerente-administracion (codReposicion-observacion)

      $reposicion->codEstadoReposicion=ReposicionGastos::getCodEstado('Observada');
      $reposicion->observacion=$textoObservacion;
        
      $reposicion->save();

      $reposicion->registrarOperacion(
          TipoOperacion::getCodTipoOperacion('REP','Observar'),
          $textoObservacion, 
          $codPuesto 
      );


    }








      

    public function rechazarComoGerente($id){//gerente-jefe (codReposicion)
      try{
        DB::beginTransaction();
        $reposicion=ReposicionGastos::findOrFail($id);

        if(!$reposicion->listaParaRechazar())
          return redirect()->route('ReposicionGastos.Gerente.Listar')->with('datos','Error: la reposición no puede ser rechazada ahora puesto que está en otro proceso.');

        $this->rechazarGenerico($reposicion,Puesto::getCodPuesto_Gerente());

        DB::commit();
        
        return redirect()->route('ReposicionGastos.Gerente.Listar')->with('datos','Se rechazó correctamente la Reposición '.$reposicion->codigoCedepas);
      }catch(\Throwable $th){
        Debug::mensajeError('RENDICION GASTOS CONTROLLER rechazarComoGerente', $th);
        DB::rollBack();
        $codErrorHistorial=ErrorHistorial::registrarError($th, app('request')->route()->getAction(),$id);
        
        return redirect()->route('ReposicionGastos.Gerente.Listar')->with('datos',Configuracion::getMensajeError($codErrorHistorial));
      }

    }
    public function rechazarComoAdministrador($id){//
      try{
        DB::beginTransaction();
        $reposicion=ReposicionGastos::findOrFail($id);

        if(!$reposicion->listaParaRechazar())
          return redirect()->route('ReposicionGastos.Administracion.Listar')->with('datos','Error: la reposición no puede ser rechazada ahora puesto que está en otro proceso.');

        $this->rechazarGenerico($reposicion,Puesto::getCodPuesto_Administrador());

        DB::commit();
        
        return redirect()->route('ReposicionGastos.Administracion.Listar')->with('datos','Se rechazó correctamente la Reposición '.$reposicion->codigoCedepas);
      }catch(\Throwable $th){
        Debug::mensajeError('RENDICION GASTOS CONTROLLER rechazarComoAdministrador', $th);
        DB::rollBack();
        $codErrorHistorial=ErrorHistorial::registrarError($th, app('request')->route()->getAction(),$id);
        
        return redirect()->route('ReposicionGastos.Administracion.Listar')->with('datos',Configuracion::getMensajeError($codErrorHistorial));
      }

    }
    

    private function rechazarGenerico(ReposicionGastos $reposicion,$codPuesto){


      $reposicion->codEstadoReposicion=ReposicionGastos::getCodEstado('Rechazada');
      $reposicion->save();

      $reposicion->registrarOperacion(
        TipoOperacion::getCodTipoOperacion('REP','Rechazar'),
        null, 
        $codPuesto 
      );  

    }







    public function contabilizar($cadena){
        try {
            DB::beginTransaction();
     
            $vector = explode('*',$cadena);
            $codReposicion = $vector[0];
            $listaItemsAContabilizar = explode(',',$vector[1]);

            $reposicion = ReposicionGastos::findOrFail($codReposicion);

            if(!$reposicion->listaParaContabilizar())
            return redirect()->route('ReposicionGastos.Listar')
                ->with('datos','Error: la reposición no puede ser contabilizada ahora puesto que está en otro proceso.');


            $reposicion->codEstadoReposicion =  ReposicionGastos::getCodEstado('Contabilizada');
            $reposicion->codEmpleadoConta = Empleado::getEmpleadoLogeado()->codEmpleado;
            $reposicion->fechaHoraRevisionConta=new DateTime();
            $reposicion->save();

            $reposicion->registrarOperacion(
                TipoOperacion::getCodTipoOperacion('REP','Contabilizar'),
                null, 
                Puesto::getCodPuesto_Contador()); //siempre abonará el gerente
              

            $detallesDeReposicion = $reposicion->detalles();


            if( $vector[1] != "" )
                foreach ($detallesDeReposicion as $item) { //guardamos como contabilizados los items que nos llegaron
                    $detGasto = DetalleReposicionGastos::findOrFail($item->codDetalleReposicion);
                    if( in_array($item->codDetalleReposicion,$listaItemsAContabilizar)   ) //Si está para contabilizar
                    {
                        $detGasto->contabilizado = 1;
                        $detGasto->pendienteDeVer = 0;                          
                    }else{
                        $detGasto->contabilizado = 0;
                        $detGasto->pendienteDeVer = 1;
                    }
                    $detGasto->save();   
                }

            DB::commit();
            
            return redirect()->route('ReposicionGastos.Contador.Listar')->with('datos','Se contabilizó correctamente la Reposición '.$reposicion->codigoCedepas);
        } catch (\Throwable $th) {
            Debug::mensajeError('REPOSICION GASTOS CONTROLLER CONTABILIZAR', $th);
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th, app('request')->route()->getAction(),$cadena);
             
            return redirect()->route('ReposicionGastos.Contador.Listar')->with('datos',Configuracion::getMensajeError($codErrorHistorial));
        }


    }
    public function cancelar($id){
        try {
            DB::beginTransaction();
    
            $reposicion = ReposicionGastos::findOrFail($id);

            if(!$reposicion->listaParaCancelar())
            return redirect()->route('ReposicionGastos.Listar')
                ->with('datos','Error: la reposición no puede ser cancelada ahora puesto que está en otro proceso.');


            $reposicion->codEstadoReposicion =  ReposicionGastos::getCodEstado('Cancelada');
            $reposicion->save();

            $reposicion->registrarOperacion(
                TipoOperacion::getCodTipoOperacion('REP','Cancelar'),
                null, 
                Puesto::getCodPuesto_Empleado() ); //siempre abonará el gerente
              
     
            DB::commit();
            return redirect()->route('ReposicionGastos.Empleado.Listar')->with('datos','Se canceló correctamente la Reposición '.$reposicion->codigoCedepas);
        } catch (\Throwable $th) {
            Debug::mensajeError('REPOSICION GASTOS CONTROLLER CANCELADA', $th);
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th, app('request')->route()->getAction(),$id);
            return redirect()->route('ReposicionGastos.Empleado.Listar')->with('datos',Configuracion::getMensajeError($codErrorHistorial));
        }


    }




    public function verMisGastos(){
        $listaReposiciones = ReposicionGastos::where('codEmpleadoSolicitante','=',Empleado::getEmpleadoLogeado()->codEmpleado)
            ->orderBy('fechaHoraEmision','DESC')
            ->get(); 
        
        $listaGastos = new Collection();

        foreach($listaReposiciones as $itemRepo){
            $detallesDeEstaRepo = DetalleReposicionGastos::where('codReposicionGastos','=',$itemRepo->codReposicionGastos)->get();
            
            $listaGastos = $listaGastos->concat($detallesDeEstaRepo);
        }

        $listaGastos= $listaGastos->paginate(100);
        
        return view('ReposicionGastos.Empleado.ListarMisGastos',compact('listaGastos'));
    }

    


    public function marcarDetalleComoVisto($codDetalleReposicion){
        
        $det = DetalleReposicionGastos::findOrFail($codDetalleReposicion);
        $det->pendienteDeVer = 0;
        $det->save();

        return redirect()->route('ReposicionGastos.Empleado.verMisGastos')
            ->with('datos','Se ha marcado como visto el gasto, ya no aparecerá en notificaciones.');

    }

    


    public function descargarPDF($id){
        if(BusquedaRepo::hayBusquedaActiva())
            BusquedaRepo::finalizarBusqueda();

        $reposicion=ReposicionGastos::findOrFail($id);
        $pdf = $reposicion->getPDF();
        return $pdf->download('Reposicion de Gastos '.$reposicion->codigoCedepas.'.Pdf');
    }
    
    public function verPDF($id){
        if(BusquedaRepo::hayBusquedaActiva())
            BusquedaRepo::finalizarBusqueda();

        $reposicion=ReposicionGastos::findOrFail($id);
        $pdf = $reposicion->getPDF();
        return $pdf->stream('Reposicion de Gastos '.$reposicion->codigoCedepas.'.Pdf');
    }





    /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
    /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
    /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
    /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
    /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
    /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
    /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
    /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
    /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
    /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
    /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
    /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
    /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
    /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
    /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
    /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
    /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
    /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */
    /* --------------- API -------------- API ---------------- API -------------- API ---------------- API  */


    
    function API_listarREPDeEmpleado($codEmpleado){
         
        $listaReposiciones = ReposicionGastos::
            where('codEmpleadoSolicitante','=',$codEmpleado)
            ->orderBy('fechaHoraEmision','DESC')->get();
        $listaReposiciones = ReposicionGastos::ordenarParaEmpleado($listaReposiciones);

        $listaPreparada = [];
        foreach ($listaReposiciones as $ren) {
            $listaPreparada[] = $ren->getVectorParaAPI();
        }

        return $listaPreparada;
         
    }

    function API_getREP($codReposicion){
        $reposicion = ReposicionGastos::findOrFail($codReposicion);
        $listaDetalles = $reposicion->getDetallesParaAPI();
        

        $renPreparada = $reposicion->getVectorParaAPI();
        $renPreparada['listaDetalles'] = json_encode($listaDetalles);

        

        return json_encode($renPreparada);
    }



}

