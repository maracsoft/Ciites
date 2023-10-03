<?php

namespace App\Models\CITE;

use App\ArchivoGeneral;
use App\CDP;
use App\ComponentRenderizer;
use App\Debug;
use App\Distrito;
use App\Empleado;
use App\Fecha;
use App\Mes;
use App\MesAño;
use App\ParametroSistema;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Servicio extends Model
{
    public $table = "cite-servicio";
    protected $primaryKey ="codServicio";

    public $timestamps = false;
    protected $fillable = [''];

    public function getMesAño(){
      $fecha_termino = $this->fechaTermino;

      $mes_termino = date('m', strtotime($fecha_termino));
      $año_termino = date('Y', strtotime($fecha_termino));
      return MesAño::where('año',$año_termino)->where('codMes',$mes_termino)->first();
    }

    public function getActividadPAT() : ActividadCite {
      return ActividadCite::findOrFail($this->codActividad);
    }

    function sePuedeEliminar(){
        $emp = Empleado::getEmpleadoLogeado();
        if($emp->esAdminSistema())
            return true;

        if($emp->esUGE() || $emp->esArticulador())
            return true;

        //Entonces es equipo
        if($this->codEmpleadoCreador!=$emp->getId()) //si el logeado no lo creó, no puede eliminarlo
            return false;

        //Es equipo y sí lo creo,
        return true;
    }


    public function getUnidadProductiva(){
        return UnidadProductiva::findOrFail($this->codUnidadProductiva);
    }

    function getFechaInicio(){
        return Fecha::formatoParaVistas($this->fechaInicio);

    }
    function getFechaTermino(){
        return Fecha::formatoParaVistas($this->fechaTermino);
    }

     

    function getFechaHoraCreacion(){

        return Fecha::formatoFechaHoraParaVistas($this->fechaHoraCreacion);
    }

    public function esPagado(){
      $tipo_acceso = $this->getTipoAcceso();
      return $tipo_acceso->nombre == "Pagado";
    }
    
    function getEmpleadoCreador(){
        return Empleado::findOrFail($this->codEmpleadoCreador);
    }

    function getDepartamento(){
        if(!$this->codDistrito)
            return "NO INFO";

        $dist = $this->getDistrito();
        return $dist->getProvincia()->getDepartamento();
    }
    function getProvincia(){
        if(!$this->codDistrito)
            return "NO INFO";

        $dist = $this->getDistrito();
        return $dist->getProvincia();
    }
    public function getDistrito(){
        if(!$this->codDistrito)
            return "NO INFO";
        return Distrito::findOrFail($this->codDistrito);
    }



    function getTextoLugar(){
        $dist = $this->getDistrito();
        return $dist->getTextoUbicacion();
    }


    function getTipoAcceso(){
        return TipoAcceso::findOrFail($this->codTipoAcceso);
    }
    function getTipoServicio(){
        return TipoServicio::findOrFail($this->codTipoServicio);
    }
    function getModalidad(){
        return ModalidadServicio::findOrFail($this->codModalidad);
    }

    function getTextoModalidadConConvenio(){
      if($this->codModalidad==1){
          return "SÍ";
      }else{
          return "NO";
      }
    }

    public function tieneTipoCDP(){
      return $this->codTipoCDP != null;
    }

    public function getTipoCDP_nombre(){
      if($this->tieneTipoCDP()){
        $tipo_cdp = $this->getTipoCDP();
        return $tipo_cdp->nombre; 
      }else{
        return "";
      }
    }

    
    private function getTipoCDP(){
        if(!$this->tieneTipoCDP()){
          throw new Exception("Error en el servicio ".$this->getId(). " al tratar de ejecutar getTipoCDP(). codTipoCDP es null");
        }
        return CDP::findOrFail($this->codTipoCDP);
    }

    function getListaArchivos(){
        $lista = ArchivoServicio::where('codServicio',$this->getId())->get();
        $array = [];
        foreach ($lista as $arcSer) {
            $array[] = $arcSer->codArchivo;
        }
        return ArchivoGeneral::whereIn('codArchivo',$array)->get();
    }
    function getListaArchivoServicio(){
        return ArchivoServicio::where('codServicio',$this->getId())->get();
    }
    
    function tieneArchivos(){
      $cant =  ArchivoServicio::where('codServicio',$this->getId())->count();
      return $cant > 0;
    }

    function tieneArchivosExportables(){
      $codsTipos = [];
      $lista_tipos = $this->getListaTiposMediosVerificacionNecesarios();
      foreach ($lista_tipos as $tipo_medio) {
        $codsTipos [] = $tipo_medio->codTipoMedioVerificacion;
      }

      $cant =  ArchivoServicio::where('codServicio',$this->getId())->whereIn('codTipoMedioVerificacion',$codsTipos)->count();
      return $cant > 0;
    }
    
    public function getListaOtrosArchivos($codsArchivosServiciosYaMostrados){
      return ArchivoServicio::whereNotIn('codArchivoServicio',$codsArchivosServiciosYaMostrados)->where('codServicio',$this->codServicio)->get();

    }

    function getRelaAsistenciaServicio(){
        return AsistenciaServicio::where('codServicio',$this->getId())->get();

    }
    public function getArrayCodUsuariosAsistentes(){
        $list = $this->getRelaAsistenciaServicio();
        $arr = [];
        foreach ($list as $asist) {
            array_push( $arr, $asist->codUsuario);
        }

        return $arr;
    }

    /* Los que asistieron */
    function getUsuarios(){
        $listaAsistenciaServicio = AsistenciaServicio::where('codServicio',$this->getId())->get();
        $array = [];
        foreach ($listaAsistenciaServicio as $usuarioServ) {
            array_push($array,$usuarioServ->codUsuario);
        }

        $listaUsuarios = UsuarioCite::whereIn('codUsuario',$array)->orderBy('nombres','ASC')->get();
        return $listaUsuarios;

    }


    function getAsistenciaDeUsuario($codUsuario){
        return AsistenciaServicio::where('codServicio',$this->getId())->where('codUsuario',$codUsuario)->first();
    }

    function getCantidadAsistentes(){
        return count($this->getUsuarios());
    }
    function verificarAsistenciaDeUsuario($codUsuario){
        $list = AsistenciaServicio::where('codServicio',$this->getId())->where('codUsuario',$codUsuario)->get();
        return count($list)>0;
    }

    public function getUsuariosExternosNoAsistentes(){

        $usuariosExistentes = UsuarioCite::All();
        $unidadProductiva = $this->getUnidadProductiva();
        $arr = [];
        foreach ($usuariosExistentes as $usuario) {
            if(!$unidadProductiva->tieneUsuarioAsociado($usuario->getId()))
                if(!$this->verificarAsistenciaDeUsuario($usuario->getId()))
                    array_push($arr,$usuario->getId());
        }
        return UsuarioCite::whereIn('codUsuario',$arr)->get();
    }



    //retorna un array de Usuarios asociados , con un booleano de si participo o no en el servicio actual

    function getUsuariosYAsistencia(){
        $unidadProductiva = $this->getUnidadProductiva();
        $usuariosAsociados = $unidadProductiva->getUsuarios();

        foreach ($usuariosAsociados as $usuario) {
            $usuario->asistencia = $this->verificarAsistenciaDeUsuario($usuario->getId());
            $usuario->nuevaAsistencia = $usuario->asistencia;
        }


        return $usuariosAsociados;
    }


    private static function getCodsServiciosValidosParaFechasFiltradas(string $fechaInicio_sql,string $fechaTermino_sql,array $codsCadenaSeleccionados) : array {
      
      $lista = Servicio::where(static::FiltroEspecialFechas($fechaInicio_sql,$fechaTermino_sql))->get();
      $array = [];
      foreach ($lista as $servicio) {
 
        
        $unidad = $servicio->getUnidadProductiva();
        $valido = false;

        if(count($codsCadenaSeleccionados) != 0){
          if(in_array($unidad->codCadena,$codsCadenaSeleccionados)){
            $valido = true;
          }
        }else{
          $valido = true;
        }
        
        if($valido){
          $array[] = $servicio->getId();
        }
          
      }
      return $array;
    }

    
    

    /* OBJETOS REPORTES */
    static function getReporteServiciosPorRegion($fechaInicio_sql,$fechaTermino_sql,array $codsCadenaSeleccionados){

        $codsServiciosValidos = static::getCodsServiciosValidosParaFechasFiltradas($fechaInicio_sql,$fechaTermino_sql,$codsCadenaSeleccionados);
        
        $string_cods = implode(",",$codsServiciosValidos);
        
  
        if($string_cods == ""){
          $where = " false ";
        }else{
          $where = " S.codServicio IN ($string_cods) ";
        }

        $sqlServiciosPorRegion =
            "SELECT 
              count(S.codServicio) as cantidad, 
              DEP.nombre as region, 
              DEP.codDepartamento 
            FROM `cite-servicio` S
            INNER JOIN distrito D on S.codDistrito = D.codDistrito
            INNER JOIN provincia P on P.codProvincia = D.codProvincia
            INNER JOIN departamento DEP on DEP.codDepartamento = P.codDepartamento
            WHERE $where
            GROUP BY DEP.codDepartamento,DEP.nombre
            ORDER BY count(S.codServicio) DESC
          ";


        $labels = [];
        $valores = [];
        $colores = [];
        $listaRegiones = DB::select($sqlServiciosPorRegion);
        foreach ($listaRegiones as $region) {

            $labels[] = $region->region;
            $valores[] = $region->cantidad;
            $r= rand(50,255);
            $g = rand(80,200);
            $colores[] = "rgb($r,$g,100)";
        }

        $obj = [
            'listaRegiones'=>$listaRegiones,
            'labels'=>$labels,
            'valores'=>$valores,
            'colores'=>$colores
        ];

        return $obj;
    }

    static function getReporteServiciosPorActividad($fechaInicio_sql,$fechaTermino_sql,array $codsCadenaSeleccionados){

      $codsServiciosValidos = static::getCodsServiciosValidosParaFechasFiltradas($fechaInicio_sql,$fechaTermino_sql,$codsCadenaSeleccionados);
      
      $string_cods = implode(",",$codsServiciosValidos);
      

      if($string_cods == ""){
        $where = " false ";
      }else{
        $where = " S.codServicio IN ($string_cods) ";
      }

      $sqlServiciosPorActividad =
          "SELECT 
            count(S.codServicio) as cantidad, 
            ACT.nombre as nombre,
            ACT.codActividad as codActividad
          FROM `cite-servicio` S
          INNER JOIN `cite-actividad` ACT on ACT.codActividad = S.codActividad
          WHERE $where
          GROUP BY ACT.codActividad,ACT.nombre
          ORDER BY count(S.codServicio) DESC
        ";


      $labels = [];
      $valores = [];
      $colores = [];
      $listaActividades = DB::select($sqlServiciosPorActividad);
      foreach ($listaActividades as $actividad) {
          $actividad_model = ActividadCite::findOrFail($actividad->codActividad);
          $tipo_serv = $actividad_model->getTipoServicio();
          $modalidad = $tipo_serv->getModalidad();


          $labels[] = $modalidad->nombre." - ".$actividad->nombre;
          $valores[] = $actividad->cantidad;
          $r= rand(50,255);
          $g = rand(80,200);
          $colores[] = "rgb($r,$g,100)";
      }

      $obj = [
          'listaActividades'=>$listaActividades,
          'labels'=>$labels,
          'valores'=>$valores,
          'colores'=>$colores
      ];

      return $obj;
    }

     
    public static function getReporteServiciosPorProvincia($fechaInicio_sql,$fechaTermino_sql,array $codsCadenaSeleccionados){
        $codsServiciosValidos = static::getCodsServiciosValidosParaFechasFiltradas($fechaInicio_sql,$fechaTermino_sql,$codsCadenaSeleccionados);
        $string_cods = implode(",",$codsServiciosValidos);

        if($string_cods == ""){
          $where = " false ";
        }else{
          $where = " S.codServicio IN ($string_cods) ";
        }

        $sqlServiciosPorProvincia =
            "SELECT 
              count(S.codServicio) as cantidad, 
              P.nombre as provincia, 
              DEP.nombre as departamento, 
              P.codProvincia 
            FROM `cite-servicio` S
            INNER JOIN distrito D on S.codDistrito = D.codDistrito
            INNER JOIN provincia P on P.codProvincia = D.codProvincia
            INNER JOIN departamento DEP on DEP.codDepartamento = P.codDepartamento
            WHERE $where
            GROUP BY P.codProvincia,P.nombre,DEP.nombre
            ORDER BY count(S.codServicio) DESC
          ";


        $labels = [];
        $valores = [];
        $colores = [];
        $listaProvincias = DB::select($sqlServiciosPorProvincia);
        foreach ($listaProvincias as $provincia) {

            $labels[] = $provincia->provincia;
            $valores[] = $provincia->cantidad;
            $r= rand(50,255);
            $g = rand(80,200);
            $colores[] = "rgb($r,$g,100)";
        }

        $obj = [
            'listaProvincias'=>$listaProvincias,
            'labels'=>$labels,
            'valores'=>$valores,
            'colores'=>$colores
        ];

        return $obj;
    }

    public static function getReporteServiciosPorUnidad($fechaInicio_sql,$fechaTermino_sql,array $codsCadenaSeleccionados){
        $codsServiciosValidos = static::getCodsServiciosValidosParaFechasFiltradas($fechaInicio_sql,$fechaTermino_sql,$codsCadenaSeleccionados);
        $string_cods = implode(",",$codsServiciosValidos);

        if($string_cods == ""){
          $where = " false ";
        }else{
          $where = " S.codServicio IN ($string_cods) ";
        }

        $sqlServiciosPorUnidad =
            "SELECT
                UP.codUnidadProductiva,
                UP.razonSocial as razonSocial ,
                UP.nombrePersona as nombrePersona ,
                count(S.codServicio) as CantidadServicios,
                sum(nroHorasEfectivas) as HorasAcumuladas
            FROM `cite-unidad_productiva` UP
            INNER JOIN `cite-servicio` S on S.codUnidadProductiva = UP.codUnidadProductiva
            WHERE $where
            GROUP BY UP.codUnidadProductiva,UP.razonSocial,UP.nombrePersona
            ORDER BY CantidadServicios DESC
            ";


        $labels = [];
        $valores_cantidadServicios = [];
        $valores_horasAcumuladas = [];

        $colores = [];
        $listaUnidades = DB::select($sqlServiciosPorUnidad);
        foreach ($listaUnidades as $unid) {

            if($unid->razonSocial!="")
                $labels[] = $unid->razonSocial;
            else
                $labels[] = $unid->nombrePersona;
            $valores_cantidadServicios[] = $unid->CantidadServicios;
            $valores_horasAcumuladas[] = $unid->HorasAcumuladas;
            $r= rand(50,255);
            $g = rand(80,200);
            $colores[] = "rgb($r,$g,100)";
        }

        $obj = [
            'listaUnidades'=>$listaUnidades,
            'labels'=>$labels,
            'valores_cantidadServicios'=>$valores_cantidadServicios,
            'valores_horasAcumuladas'=>$valores_horasAcumuladas,
            'colores'=>$colores
        ];

        return $obj;

    }

    public static function getReporteServiciosPorCadena($fechaInicio_sql,$fechaTermino_sql,array $codsCadenaSeleccionados){
      $codsServiciosValidos = static::getCodsServiciosValidosParaFechasFiltradas($fechaInicio_sql,$fechaTermino_sql,$codsCadenaSeleccionados);
      $string_cods = implode(",",$codsServiciosValidos);

      if($string_cods == ""){
        $where = " false ";
      }else{
        $where = " S.codServicio IN ($string_cods) ";
      }

      $sqlServiciosPorUnidad =
          "
          SELECT 
            count(S.codServicio) as cantidad, 
            C.nombre as nombre,
            C.codCadena
          FROM `cite-servicio` S
          INNER JOIN `cite-unidad_productiva` UP on S.codUnidadProductiva = UP.codUnidadProductiva
          INNER JOIN `cite-cadena` C on UP.codCadena = C.codCadena
          WHERE $where
          GROUP BY C.codCadena,C.nombre
          ORDER BY count(S.codServicio) DESC
          ";

      
      $labels = [];
      $valores = [];
      $colores = [];
      $listaCadenas = DB::select($sqlServiciosPorUnidad);
      foreach ($listaCadenas as $cadena) {
 
          $labels[] = $cadena->nombre;
          $valores[] = $cadena->cantidad;
          $r= rand(50,255);
          $g = rand(80,200);
          $colores[] = "rgb($r,$g,100)";
      }

      $obj = [
          'listaCadenas'=>$listaCadenas,
          'labels'=>$labels,
          'valores'=>$valores,
          'colores'=>$colores
      ];

      return $obj;

  }

    public static function FiltroEspecialFechas($fechaInicio,$fechaFin){
      return function($query) use ($fechaInicio,$fechaFin) {
        $query->where(function($query1) use ($fechaInicio,$fechaFin){
         $query1->where('fechaInicio','<=',$fechaInicio)->where('fechaTermino','>=',$fechaInicio)->where('fechaTermino','<=',$fechaFin);
        })
        ->orWhere(function($query2) use ($fechaInicio,$fechaFin){
         $query2->where('fechaInicio','>=',$fechaInicio)->where('fechaInicio','<=',$fechaFin)->where('fechaTermino','>=',$fechaFin);
        })
        ->orWhere(function($query3) use ($fechaInicio,$fechaFin){
         $query3->where('fechaInicio','<=',$fechaInicio)->where('fechaTermino','>=',$fechaFin);
        })
        ->orWhere(function($query4) use ($fechaInicio,$fechaFin){
         $query4->where('fechaInicio','>=',$fechaInicio)->where('fechaTermino','<=',$fechaFin);
        });
     };

    }

    public function getArchivoServicio_SegunTipoMedioVerificacion($codTipoMedioVerificacion){
      $lista = ArchivoServicio::where('codTipoMedioVerificacion',$codTipoMedioVerificacion)->where('codServicio',$this->codServicio)->get();
      if(count($lista) == 0 ){
        return null;
      }
        
      return $lista[0];
    }


    public function getListaTiposMediosVerificacionNecesarios(){
      $actividad = $this->getActividadPAT();
      $tipos_medios = $actividad->getListaTipoMedioVerificacion();
      return $tipos_medios;
    }

    public function getMensajeArchivosFaltantes(){

      //obtenemos los codigos de los codTipoMedioVerificacion que se necesitan segun la actividad
      $actividad = $this->getActividadPAT();
      $tipos_medios = $actividad->getListaTipoMedioVerificacion();
      
      $nombres = [];
      foreach ($tipos_medios as $tipo_medio_necesario) {
        $cantidad = ArchivoServicio::where('codServicio',$this->codServicio)->where('codTipoMedioVerificacion',$tipo_medio_necesario->codTipoMedioVerificacion)->count();
        $tiene = $cantidad > 0;
        if(!$tiene){
          $nombres[] = $tipo_medio_necesario->nombre; 
        }
      }
      if(count($nombres) == 0){
        return "No falta ningún archivo.";
      }
      
      return "Faltan los archivos : " .implode(",",$nombres);
    }

    public function faltanArchivosPorSubir() : bool {
      
      //obtenemos los codigos de los codTipoMedioVerificacion que se necesitan segun la actividad
      $actividad = $this->getActividadPAT();
      $tipos_medios = $actividad->getListaTipoMedioVerificacion();
      
      $nombres = [];
      foreach ($tipos_medios as $tipo_medio_necesario) {
        $cantidad = ArchivoServicio::where('codServicio',$this->codServicio)->where('codTipoMedioVerificacion',$tipo_medio_necesario->codTipoMedioVerificacion)->count();
        $tiene = $cantidad > 0;
        if(!$tiene){
          $nombres[] = $tipo_medio_necesario->nombre; 
        }
      }
      if(count($nombres) == 0){
        return false;
      }
      
      return true;
    }


    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */


    public function html_getArchivosDelServicio(bool $mostrarBotonEliminar){
        
        $listaArchivos = [];
        foreach($this->getListaArchivoServicio() as $archivoServicio) {
            $archivoGen = $archivoServicio->getArchivo();
            array_push($listaArchivos,[
                'nombreAparente'=> $archivoGen->nombreAparente,
                'linkDescarga'=> route('CITE.Servicios.DescargarArchivo',$archivoGen->getId()),
                'linkEliminar' => route('CITE.Servicios.EliminarArchivo',$archivoServicio->getId())
            ]);
        }

        return ComponentRenderizer::DescargarArchivos("Archivos del servicio",$listaArchivos,$mostrarBotonEliminar);
    }



}
