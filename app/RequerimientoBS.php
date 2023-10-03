<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RequerimientoBS extends DocumentoAdministrativo
{
    public $table = "requerimiento_bs";
    protected $primaryKey ="codRequerimiento";

    public $timestamps = false;  //para que no trabaje con los campos fecha 
    //const raizArchivoEmp = "ReqBS-Emp-";
    const RaizCodigoCedepas = "REQ";
    const raizArchivo = "REQ-";
    const codTipoDocumento = "4";


    // le indicamos los campos de la tabla 
    protected $fillable = ['codigoCedepas','fechaHoraEmision','fechaHoraRevision','fechaHoraAtendido','fechaHoraConta',
    'codEmpleadoSolicitante','codEmpleadoEvaluador','codEmpleadoAdministrador','codEmpleadoContador',
    'justificacion','codEstadoRequerimiento','cantArchivosEmp','terminacionesArchivosEmp','cantArchivosAdmin',
    'terminacionesArchivosAdmin','codProyecto','observacion'];

    
    //esto es para el historial de operaciones
    public function getVectorDocumento(){
        return [
            'codTipoDocumento' => RequerimientoBS::codTipoDocumento,
            'codDocumento' => $this->codRequerimiento
        ];
    }

    //el cuarto archivo del empleado del requerimiento 124
    // REQ-000124-Emp-04.jpg  
    public static function getFormatoNombreArchivoEmp($codRequerimientoBS,$i){
        return  RequerimientoBS::raizArchivo.
                RequerimientoBS::rellernarCerosIzq($codRequerimientoBS,6).
                '-Emp-'.
                RequerimientoBS::rellernarCerosIzq($i,2).
                '.marac';

    }
/* 
    //la primera es la 1 OJO
    public function getNombreArchivoEmpNro($index){
        $vector = explode('/',$this->nombresArchivosEmp);
        return $vector[$index-1];

    }
    //la primera es la 1 OJO
    public function getNombreArchivoAdmNro($index){
        $vector = explode('/',$this->nombresArchivosAdmin);
        return $vector[$index-1];

    } */
    
    
    //el quinto archivo del admin del requerimiento 122
    // REQ-000122-Adm-05.png  
    /* public static function getFormatoNombreArchivoAdm($codRequerimientoBS,$i){
        return  RequerimientoBS::raizArchivo.
                RequerimientoBS::rellernarCerosIzq($codRequerimientoBS,6).
                '-Adm-'.
                RequerimientoBS::rellernarCerosIzq($i,2).
                '.marac';

    } */


    public function getNombreGuardadoNuevoArchivoEmp($i){
        return  RequerimientoBS::raizArchivo.
                RequerimientoBS::rellernarCerosIzq($this->codRequerimiento,6).
                '-Emp-'.
                RequerimientoBS::rellernarCerosIzq($i,2).
                '.marac';


    }

    public function getNombreGuardadoNuevoArchivoAdm($i){
        return  RequerimientoBS::raizArchivo.
                RequerimientoBS::rellernarCerosIzq($this->codRequerimiento,6).
                '-Adm-'.
                RequerimientoBS::rellernarCerosIzq($i,2).
                '.marac';


    }

    

    public function borrarArchivosEmp(){ //borra todos los archivos que sean de esa rendicion
        foreach ($this->getListaArchivosEmp() as $itemArchivo) {
            $nombre = $itemArchivo->nombreDeGuardado;
            Storage::disk('requerimientos')->delete($nombre);
            Debug::mensajeSimple('Se acaba de borrar el archivo:'.$nombre);
        } 
        return ArchivoReqEmp::where('codRequerimiento','=',$this->codRequerimiento)->delete();
        
    }

    public function getListaArchivosEmp(){

        return ArchivoReqEmp::where('codRequerimiento','=',$this->codRequerimiento)->get();
    }

    public function getCantidadArchivosEmp(){
        return count($this->getListaArchivosEmp());

    }

    public function estaContabilizada(){
        return $this->verificarEstado('Contabilizada');

    }



    public function tieneArchivosAdmin(){
        return count($this->getListaArchivosAdmin()) > 0;

    }

    public function borrarArchivosAdmin(){ //borra todos los archivos que sean de esa rendicion
        foreach ($this->getListaArchivosAdmin() as $itemArchivo) {
            $nombre = $itemArchivo->nombreDeGuardado;
            Storage::disk('requerimientos')->delete($nombre);
            Debug::mensajeSimple('Se acaba de borrar el archivo:'.$nombre);
        } 
        return ArchivoReqAdmin::where('codRequerimiento','=',$this->codRequerimiento)->delete();
        
    }

    public function getListaArchivosAdmin(){

        return ArchivoReqAdmin::where('codRequerimiento','=',$this->codRequerimiento)->get();
    }

    public function getCantidadArchivosAdmin(){
        return count($this->getListaArchivosAdmin());

    }

    //el admin puede subir archivos si aun no se ingresa la factura o si no se ha subido ningun archivo del admin
    //O SI ACTIVÉ EL PARAMETRO EN SISTEMA ESPECIAL PA ESO XD
    //Son dos parámetros, un booleano y un numerico que es el id
    public function adminPuedeSubirArchivos(){
      
      if($this->empLogeadoEsAdministradorSubidorIlimitado())
        return true;
        
      if($this->permisoMaestroSubirArchivosAdminActivado())
        return true;

      //si no ha subido ningun archivo
      if($this->getCantidadArchivosAdmin() ==0 ) 
        return true;

      
      return $this->tieneFactura != '1';

    }

    public function empLogeadoEsAdministradorSubidorIlimitado(){
      $emp = Empleado::getEmpleadoLogeado();
      $codEmpSubidorIlimitado = ParametroSistema::getParametroSistema('codEmpleadoAdministradorLibreSubidaArchivos')->valor;
      
      return $emp->getId() == $codEmpSubidorIlimitado;
    }

    public function permisoMaestroSubirArchivosAdminActivado() : bool{
      $activado = ParametroSistema::getParametroSistema('activar_subida_admin_REQ')->valor == "true";
      if(!$activado)
        return false;

      $id_activada = ParametroSistema::getParametroSistema('id_subida_admin_REQ')->valor;
      if($id_activada == $this->getId())
        return true;
      return false;

    }


    /* 
        Un admin puede marcar factura si todavia no la sube 
    */
    public function puedeMarcarFactura(){

        return $this->tieneFactura != '1';
    }

    public function getPDF(){
        $listaItems = DetalleRequerimientoBS::where('codRequerimiento','=',$this->codRequerimiento)->get();
        $pdf = \PDF::loadview('RequerimientoBS.PdfRBS',
            array('requerimiento'=>$this,'listaItems'=>$listaItems)
                            )->setPaper('a4', 'portrait');
        
        return $pdf;
    }
    

    //si está en esos estados retorna la obs, sino retorna ""
    public function getObservacionONull(){
        if($this->verificarEstado('Observada') || $this->verificarEstado('Subsanada') )
            return ": ".$this->observacion;
        
        return "";
    }



    public function getColorSiTieneFactura(){
        if(is_null($this->tieneFactura))/* Si aun no se revisa */
            return "black";
        
        if($this->tieneFactura==1)
            return "green";

        if($this->tieneFactura==0)
            return "red";
    }
    /* Funcion para el listado */
    public function getSiTieneFactura(){
        if(is_null($this->tieneFactura))
            return "N.R";

        if($this->tieneFactura==1)
            return "Sí";

        if($this->tieneFactura==0)
            return "No";
    }


     
    /* Retorna un string largo si tiene factura o no */
    public function getSiTieneFacturaParaEstado(){
        if(is_null($this->tieneFactura))
            return "";/* PREGUNTAR AQUI QUE NOMBRE LE PONGO XD */


        if($this->tieneFactura==0)
            return "(Sin Factura)";

            
        if($this->tieneFactura==1)
            return "(Con Factura ".$this->getFacturaContabilizadaLarga().")";
    }


    /* Por defecto facturaContabilizada inicia en 0 */
    public function getFacturaContabilizada(){
        if($this->facturaContabilizada==1)
            return "Sí";

        if($this->facturaContabilizada==0)
            return "No";
    }

    public function getFacturaContabilizadaLarga(){
        if($this->facturaContabilizada==1)
            return "Contabilizada";

        if($this->facturaContabilizada==0)
            return "No Contabilizada";
    }  
    
    
    public function getColorFacturaContabilizada(){
        if($this->facturaContabilizada==1)
            return "green";

        if($this->facturaContabilizada==0)
            return "red";
    }



    /* 
    solo se puede contabilizar factura si: 
        hay una factura (tieneFactura = 1)
        facturaContabilizada = 0 o null 
    */
    public function sePuedeContabilizarFactura(){
        return ($this->tieneFactura == 1) && ($this->facturaContabilizada==0);
    }











    //aaaaaaa aaaa maaaaaaaaaaaa aaaaaaaaaaaaaa aaa aaaé
    public function getJustificacionAbreviada(){
        // Si la longitud es mayor que el límite...
        $limiteCaracteres = 70;
        $cadena = $this->justificacion;
        
        if(mb_strlen($cadena) > $limiteCaracteres){
            // Entonces corta la cadena y ponle el sufijo
            $nueva = mb_substr($cadena, 0, $limiteCaracteres) . '...';
            //Debug::mensajeSimple("el tamaño de ".$cadena." es " . strlen($cadena). " y su abreviación es '".$nueva."'  ");
            
            return $nueva;
        }
        // Si no, entonces devuelve la cadena normal
        return $cadena;
    }

    public function getObservacionMinimizada(){
        // Si la longitud es mayor que el límite...
        $limiteCaracteres = 20;
        $cadena = $this->observacion;
        if(strlen($cadena) > $limiteCaracteres){
            // Entonces corta la cadena y ponle el sufijo
            return substr($cadena, 0, $limiteCaracteres) . '...';
        }
        
        // Si no, entonces devuelve la cadena normal
        return $cadena;

    }

    public function borrarArchivosAdm(){ //borra todos los archivos que sean de esa rendicion
        
        $vectorTerminaciones = explode('/',$this->terminacionesArchivosAdmin);
        
        for ($i=1; $i <=  $this->cantArchivos; $i++) { 
            $nombre = RequerimientoBS::getFormatoNombreArchivoAdm($this->codRequerimiento,$i,$vectorTerminaciones[$i]);
            Storage::disk('requerimientos')->delete($nombre);
            Debug::mensajeSimple('Se acaba de borrar el archivo:'.$nombre);

        }

    }


    //ingresa una coleccion y  el codEstadoSolicitud y retorna otra coleccion  con los elementos de esa coleccion que están en ese estado
    public static function separarDeColeccion($coleccion, $codEstadoRequerimiento){
        $listaNueva = new Collection();
        foreach ($coleccion as $item) {
            if($item->codEstadoRequerimiento == $codEstadoRequerimiento)
                $listaNueva->push($item);
        }
        return $listaNueva;
    }


    
    public static function ordenarParaEmpleado(Builder $queryBuilder) : Collection{
      $queryBuilder = $queryBuilder->join('estado_requerimiento_bs','estado_requerimiento_bs.codEstadoRequerimiento','=','requerimiento_bs.codEstadoRequerimiento')
        ->orderBy('ordenListadoEmpleado','ASC')->orderBy('codRequerimiento','DESC');
      
      return $queryBuilder->get();
    }

    public static function ordenarParaAdministrador(Builder $queryBuilder) : Collection{
        
      
      $queryBuilder = $queryBuilder->join('estado_requerimiento_bs','estado_requerimiento_bs.codEstadoRequerimiento','=','requerimiento_bs.codEstadoRequerimiento')
        ->where('ordenListadoAdministrador','!=',99)
        ->orderBy('ordenListadoAdministrador','ASC')->orderBy('codRequerimiento','DESC');
      
      return $queryBuilder->get();

    }
 
    public static function ordenarParaContador(Builder $queryBuilder) : Collection{

      $queryBuilder = $queryBuilder->join('estado_requerimiento_bs','estado_requerimiento_bs.codEstadoRequerimiento','=','requerimiento_bs.codEstadoRequerimiento')
        ->orderBy('ordenListadoContador','ASC')->orderBy('codRequerimiento','DESC');
      
      return $queryBuilder->get();


    }
    
    public static function ordenarParaGerente(Builder $queryBuilder) : Collection{
            
      $queryBuilder = $queryBuilder->join('estado_requerimiento_bs','estado_requerimiento_bs.codEstadoRequerimiento','=','requerimiento_bs.codEstadoRequerimiento')
        ->orderBy('ordenListadoGerente','ASC')->orderBy('codRequerimiento','DESC');
      
      return $queryBuilder->get();

    }




    /** FORMATO PARA FECHAS*/
    public function formatoFechaHoraEmision(){
        $fecha=date('d/m/Y H:i:s', strtotime($this->fechaHoraEmision));
        return $fecha;
    }
    public function formatoFechaHoraRevisionGerente(){
        if(is_null($this->fechaHoraRevision) )
            return "";

        $fecha=date('d/m/Y H:i:s', strtotime($this->fechaHoraRevision));
        return $fecha;
    }
    public function formatoFechaHoraRevisionAdmin(){

        if(is_null($this->fechaHoraAtendido) )
            return "";

        $fecha=date('d/m/Y H:i:s', strtotime($this->fechaHoraAtendido));
        return $fecha;
    }
    public function formatoFechaHoraRevisionConta(){
        if(is_null($this->fechaHoraConta) )
            return "";

        $fecha=date('d/m/Y H:i:s', strtotime($this->fechaHoraConta));
        return $fecha;
    }



    public static function calcularCodigoCedepas($objNumeracion){
        return  RequerimientoBS::RaizCodigoCedepas.
                substr($objNumeracion->año,2,2).
                '-'.
                RequerimientoBS::rellernarCerosIzq($objNumeracion->numeroLibreActual,6);
    }
    public static function rellernarCerosIzq($numero, $nDigitos){
        return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);
    }


    public static function getCodEstado($nombreEstado){
        $lista = EstadoRequerimientoBS::where('nombre','=',$nombreEstado)->get();
        if(count($lista)==0)
            return 'Nombre no valido';
        
        return $lista[0]->codEstadoRequerimiento;

    }
    public function getNombreEstado(){ 
        $estado = $this->getEstado(); 
        if($estado->nombre=="Creada")
            return "Por Aprobar";
        return $estado->nombre;
    }

    public function getEstado(){
        return EstadoRequerimientoBS::findOrFail($this->codEstadoRequerimiento);
    }

    public function setEstado($codEstado){
        $this->codEstadoRequerimiento = $codEstado;
        $this->save();

    }
    

    public function getMensajeEstado(){
        $mensaje = '';
        switch($this->codEstadoRequerimiento){
            case $this::getCodEstado('Creada'): 
                $mensaje = 'El requerimiento está a espera de ser aprobado por el responsable del proyecto.';
                break;
            case $this::getCodEstado('Aprobada'):
                $mensaje = 'El requerimiento está a espera de ser atendido.';
                break;
            case $this::getCodEstado('Atendida'):
                $mensaje = 'El requerimiento está a espera de ser contabilizado.';
                break;
                                
            case $this::getCodEstado('Contabilizada'):
                $mensaje = 'El flujo de El requerimiento ha finalizado.';
                break;
            case $this::getCodEstado('Observada'):
                $mensaje ='El requerimiento tiene algún error y fue observado.';
                break;
            case $this::getCodEstado('Subsanada'):
                $mensaje ='La observación de El requerimiento ya fue corregida por el empleado.';
                break;
            case $this::getCodEstado('Rechazada'):
                $mensaje ='El requerimiento fue rechazado por algún responsable, el flujo ha terminado.';
                break;
            case $this::getCodEstado('Cancelada'):
                $mensaje ='El requerimiento fue cancelado por el mismo empleado que la realizó.';
                break;
        }
        return $mensaje;


    }
    public function getColorEstado(){ //BACKGROUND
        $color = '';
        switch($this->codEstadoRequerimiento){
            case 1: //creada
                $color = 'rgb(255,193,7)';
                break;
            case 2: //aprobada
                $color = 'rgb(0,154,191)';
                break;
            case 3: //atendida
                $color = 'rgb(243,141,57)';
                break;
            case 4: //contabilizada
                $color ='rgb(40,167,69)';
                break;
            case 5:
                $color ='rgb(255,201,7)';
                break;
            case 6:
                $color ='rgb(27,183,152)';
                break;
            case 7: //rechazada
                $color ='rgb(192,0,0)';
                break;
            case 8: //cancelada
                $color ='rgb(149,51,203)';
                break;
        }
        return $color;
    }
    public function getColorLetrasEstado(){
        $color = '';
        switch($this->codEstadoRequerimiento){
            case 1: 
                $color = 'black';
                break;
            case 2:
                $color = 'white';
                break;
            case 3:
                $color = 'white';
                break;
            case 4:
                $color = 'white';
                break;
            case 5:
                $color ='black';
                break;
            case 6:
                $color ='white';
                break;
            case 7:
                $color ='white';
                break;
            case 8:
                $color ='white';
                break;
        }
        return $color;
    }



    public function detalles(){
        return DetalleRequerimientoBS::where('codRequerimiento','=',$this->codRequerimiento)->get();
    }
    public function getEmpleadoSolicitante(){
        $empleado=Empleado::find($this->codEmpleadoSolicitante);
        return $empleado;
    }
    public function getEmpleadoEvaluador(){
        $empleado=Empleado::find($this->codEmpleadoEvaluador);
        return $empleado;
    }

    public function getNombreGerente(){
        if(is_null($this->codEmpleadoEvaluador))
            return "";

        return $this->getEmpleadoEvaluador()->getNombreCompleto();


    }


    public function evaluador(){
        $empleado=Empleado::find($this->codEmpleadoEvaluador);
        return $empleado;
    }
    public function getProyecto(){
        $proyecto=Proyecto::find($this->codProyecto);
        return $proyecto;
    }



    /* Retorna TRUE or FALSE cuando le mandamos el nombre de un estado */
    public function verificarEstado($nombreEstado){
        $lista = EstadoRequerimientoBS::where('nombre','=',$nombreEstado)->get();
        if(count($lista)==0)
            return false;
        
        
        $estado = $lista[0];
        
        if($estado->codEstadoRequerimiento == $this->codEstadoRequerimiento)
            return true;
        
        return false;
        
    }


    public function listaParaEditar(){

        return $this->verificarEstado('Creada') ||
        $this->verificarEstado('Subsanada') || 
        $this->verificarEstado('Observada');

    }

    public function listaParaAprobar(){
        return $this->verificarEstado('Creada') ||
        $this->verificarEstado('Subsanada'); 

    }
    public function listaParaActualizar(){
        return $this->verificarEstado('Creada') || 
        $this->verificarEstado('Observada') || 
        $this->verificarEstado('Subsanada'); 

    }
    public function listaParaObservar(){
        return $this->verificarEstado('Creada') || 
        $this->verificarEstado('Aprobada') || 
        $this->verificarEstado('Subsanada') 
        
        ; 

    }
    public function listaParaRechazar(){

        return $this->listaParaObservar();
    }
    public function listaParaAtender(){
        return $this->verificarEstado('Aprobada');
    }

    public function listaParaContabilizar(){
        return $this->verificarEstado('Atendida');
    }

    public function listaParaCancelar(){
        return $this->verificarEstado('Creada') || 
        $this->verificarEstado('Observada') ||
        $this->verificarEstado('Subsanada')
        ;

    }
    public static function getDashboardInfo(array $codsProyectos){
      $today = date('Y-m-d')." 00:00:00";
      $date_sup_limit = date('Y-m-d')." 23:59:59";
      $last_monday = date('Y-m-d',strtotime('-1 Monday'))." 00:00:00";
      $first_day_month = date('Y-m-')."01 00:00:00";
      $oneMonthAgo = Fecha::getFechaActualMenosXDias(30);
      $codsProyectosImploted = implode(",",$codsProyectos);

      $cant_emitidos_dia = RequerimientoBS::whereIn('codProyecto',$codsProyectos)->where('fechaHoraEmision','>=',$today)->count();
      $cant_emitidos_semana = RequerimientoBS::whereIn('codProyecto',$codsProyectos)->where('fechaHoraEmision','>=',$last_monday)->count();
      $cant_emitidos_mes = RequerimientoBS::whereIn('codProyecto',$codsProyectos)->where('fechaHoraEmision','>=',$first_day_month)->count();
      
      $cant_aprobados_dia = RequerimientoBS::whereIn('codProyecto',$codsProyectos)->where('fechaHoraRevision','>=',$today)->count();
      $cant_aprobados_semana = RequerimientoBS::whereIn('codProyecto',$codsProyectos)->where('fechaHoraRevision','>=',$last_monday)->count();
      $cant_aprobados_mes = RequerimientoBS::whereIn('codProyecto',$codsProyectos)->where('fechaHoraRevision','>=',$first_day_month)->count();
      


      $diasExistentesSQL = Fecha::getSQLFechasExistentes($oneMonthAgo,$date_sup_limit); 

      $emitidos_sql = "
        SELECT 
            COUNT(codRequerimiento) as cantidad_docs,
            CAST(fechaHoraEmision as Date) as fecha
        FROM requerimiento_bs
        WHERE codProyecto IN ($codsProyectosImploted)
            AND fechaHoraEmision >= '$oneMonthAgo'
            GROUP BY cast(fechaHoraEmision as Date)
            ORDER BY fecha
      ";

      $final_sql = "
          SELECT 
            dias_existentes.fecha,
            IFNULL(emitidos.cantidad_docs,0) as cantidad_docs
          FROM ($emitidos_sql) emitidos
          RIGHT JOIN ($diasExistentesSQL) dias_existentes on emitidos.fecha = dias_existentes.fecha
      ";
      
      $cant_emitidos_historico = DB::select($final_sql);
      $REQ = compact('cant_emitidos_dia',
                    'cant_emitidos_semana','cant_emitidos_mes','cant_aprobados_dia',
                    'cant_aprobados_semana','cant_aprobados_mes','cant_emitidos_historico');

      return $REQ;
      
    }



    /* Convierte el objeto en un vector con elementos leibles directamente por la API */
    public function getVectorParaAPI(){
        $itemActual = $this;
        $itemActual['codigoYproyecto'] = $this->getProyecto()->getOrigenYNombre()  ;
        $itemActual['nombreEstado'] = $this->getNombreEstado();
        $itemActual['colorFondo'] = $this->getColorEstado();
        $itemActual['colorLetras'] = $this->getColorLetrasEstado();
        $itemActual['fechaHoraEmision'] = $this->formatoFechaHoraEmision();
        $itemActual['nombreEmisor'] = $this->getEmpleadoSolicitante()->getNombreCompleto();
        
        

        return $itemActual;
    }

    public function getDetallesParaAPI(){
        $listaDetalles = $this->detalles();
        $listaPreparada = [];
        foreach ($listaDetalles as $det) {
            $listaPreparada[] = $det->getVectorParaAPI();
        }
        return $listaPreparada;
    }



    
}
