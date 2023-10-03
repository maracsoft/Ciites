<?php

namespace App\Models\CITE;


use App\Distrito;
use App\Empleado;
use App\Fecha;
use App\MaracModel;
use App\MesAño;
use App\Models\PPM\PPM_Organizacion;
use App\Models\PPM\PPM_TipoDocumento;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UnidadProductiva extends MaracModel
{
    public $table = "cite-unidad_productiva";
    protected $primaryKey ="codUnidadProductiva";

    public $timestamps = false;
    protected $fillable = [''];

    static function getTodasParaFront(){
      $listaUnidadesProductivas = UnidadProductiva::All();
      foreach ($listaUnidadesProductivas as $unidad) {
        $unidad['label_front'] = $unidad->getDenominacion()." ".$unidad->getRucODNI();
      }
      return $listaUnidadesProductivas;

    }
    function usuarioLogeadoPuedeEliminar(){
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


    function getClasificacionRangoVentas(){
        return ClasificacionRangoVentas::findOrFail($this->codClasificacion);

    }



    function getTieneCadena(){
      
      return $this->tieneCadena == 1;
    }
    function getTextoLugar(){
        if(!$this->codDistrito)
            return "NO INFO";

        $dist = $this->getDistrito();
        return $dist->getTextoUbicacion();
    }

    function getNombreDepartamento(){
        if(!$this->codDistrito)
            return "NO INFO";

        $dist = $this->getDistrito();
        return $dist->getProvincia()->getDepartamento()->nombre;
    }
    function getNombreProvincia(){
        if(!$this->codDistrito)
            return "NO INFO";

        $dist = $this->getDistrito();
        return $dist->getProvincia()->nombre;
    }
    public function getNombreDistrito(){
        if(!$this->codDistrito)
            return "NO INFO";
        return Distrito::findOrFail($this->codDistrito)->nombre;
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


    public function apareceEnOtrasTablas() : bool {
      $count = Servicio::where('codUnidadProductiva',$this->getId())->count();
      if($count != 0){
        error_log("la unidad productiva ".$this->getId()." aparece en Servicio");

        return true;
      }

      $count = RelacionUsuarioUnidad::where('codUnidadProductiva',$this->getId())->count();
      if($count != 0){
        error_log("la unidad productiva ".$this->getId()." aparece en RelacionUsuarioUnidad");
        
        return true;
      }
 

      return false;

    }


    //Por defecto retorna la razón social, si no tiene retorna la persona, y si no tiene LANZA ERROR
    function getDenominacion(){


        if($this->razonSocial!="")
            return $this->razonSocial;

        if($this->nombrePersona!="")
            return $this->nombrePersona;
        return "EN PROCESO DE FORMALIZACIÓN";
        throw new Exception("error en getDenominacion() de ".$this->getId());
    }

     //Por defecto retorna la razón social, si no tiene retorna la persona, y si no tiene LANZA ERROR
    function getRucODNI(){

        if($this->ruc!="")
            return $this->ruc;
        if($this->dni!="")
            return $this->dni;
        return "EN PROCESO DE FORMALIZACIÓN";
        throw new Exception("error en getRucODNI()".$this->getId());

    }


    function getTipoPersoneria(){
        return TipoPersoneria::findOrFail($this->codTipoPersoneria);
    }


    function getServicios(){

        return Servicio::where('codUnidadProductiva',$this->codUnidadProductiva)->get();
    }



    function getServiciosMes(int $mes ,int $año){
       

        return Servicio::where('codUnidadProductiva',$this->getId())
                ->whereYear('fecha_termino','=',$año)
                ->whereMonth('fecha_termino','=',$mes)
                ->get();

    }
    function getServiciosMesConv(int $mes ,int $año,bool $conConvenio){
        

        if($conConvenio)
            $conv_str = 1;
        else
            $conv_str = 2;

        return Servicio::where('codUnidadProductiva',$this->getId())
                ->where('codModalidad',$conv_str)
                ->whereYear('fecha_termino','=',$año)
                ->whereMonth('fecha_termino','=',$mes)
                ->get();

    }


    function getFechaHoraCreacion(){

        return Fecha::formatoFechaHoraParaVistas($this->fechaHoraCreacion);
    }

    function getEmpleadoCreador(){
        return Empleado::findOrFail($this->codEmpleadoCreador);
    }

    function getNroServicios(){
        return count($this->getServicios());
    }


    public static function existeUnidadProductivaRUC($ruc){
        if($ruc=="")
            return false;
        $lista = UnidadProductiva::where('ruc',$ruc)->get();
        return count($lista)>0;
    }
    public static function existeUnidadProductivaDNI($dni){
        if($dni=="")
            return false;
        $lista = UnidadProductiva::where('dni',$dni)->get();
        return count($lista)>0;
    }


    public function getEstadoDocumento(){

        return EstadoDocumento::findOrFail($this->codEstadoDocumento);
    }

    public function estaEnTramite(){
        return $this->enTramite==1;

    }

    public function getCadena(){
        return Cadena::findOrFail($this->codCadena);
    }

    public function getNombreCadena(){
        if(!$this->getTieneCadena())
            return "No tiene";

        return $this->getCadena()->nombre;
    }

    public function getUsuariosAsociados(){
        return RelacionUsuarioUnidad::where('codUnidadProductiva',$this->codUnidadProductiva)
            ->join('cite-usuario','cite-usuario.codUsuario','=','cite-relacion_usuario_unidad.codUsuario')
            ->orderBy('cite-usuario.nombres','ASC')
            ->get();

    }

    public function getArrayCodUsuariosAsociados(){
        $list = $this->getUsuariosAsociados();
        $arr = [];
        foreach ($list as $relacionUsuarioUnidad) {
            array_push( $arr, $relacionUsuarioUnidad->codUsuario);
        }

        return $arr;
    }

    public function tieneUsuarioAsociado($codUsuario){
        $lista = RelacionUsuarioUnidad::where('codUnidadProductiva',$this->codUnidadProductiva)
            ->where('codUsuario',$codUsuario)
            ->get();

        return count($lista) > 0;

    }

    function getUsuarios(){
        $lista = $this->getUsuariosAsociados();
        $array = [];
        foreach ($lista as $rela) {
            array_push($array,$rela->codUsuario);
        }

        $listaUsuarios = UsuarioCite::whereIn('codUsuario',$array)
                          ->orderBy('nombres','ASC')
                          ->orderBy('apellidoPaterno','ASC')
                          ->get();
        return $listaUsuarios;

    }

    public function tieneEnlacePPM() : bool {
      return $this->activar_enlace_ppm;
    }

    function getOrganizacionEnlazada(){
      return PPM_Organizacion::findOrFail($this->codOrganizacionEnlazadaPPM);
    }

    function setDataFromRequest(Request $request){

      $this->activar_enlace_ppm =intval($request->boolean('activar_enlace_ppm'));; 
      
      if($this->activar_enlace_ppm == 1){ 
        $this->codOrganizacionEnlazadaPPM = $request->codOrganizacionEnlazadaPPM;
        
        $org = PPM_Organizacion::findOrFail($this->codOrganizacionEnlazadaPPM);
        $org->codUnidadProductivaEnlazadaCITE = $this->getId();
        $org->activar_enlace_cite = 1;
        $org->save();
      }else{

        if($this->codOrganizacionEnlazadaPPM != null){ //si tiene una enlazada, rompemos el enlace de Organizacion A UnidadProductiva 
          $org = PPM_Organizacion::findOrFail($this->codOrganizacionEnlazadaPPM);
          $org->activar_enlace_cite = 0;
          $org->codUnidadProductivaEnlazadaCITE = null;
          $org->save();
        }
        
        $this->codOrganizacionEnlazadaPPM = null;
      }

      

    }


    function crearOrganizacionEnBase() : PPM_Organizacion {
      $organizacion = new PPM_Organizacion();

      $distrito = Distrito::findOrFail($this->codDistrito);
      $provincia = $distrito->getProvincia();
      $departamento = $provincia->getDepartamento();

      $organizacion->codTipoDocumento = PPM_TipoDocumento::RUC;
      
      
      
      $organizacion->activar_enlace_cite = 1;
      
      
      $organizacion->codTipoOrganizacion = $this->codTipoPersoneria; 

      $organizacion->codDistrito = $this->codDistrito;
      $organizacion->codProvincia = $provincia->codProvincia;
      $organizacion->codDepartamento = $departamento->codDepartamento;
      
      $organizacion->direccion = $this->direccion;

      $organizacion->razon_social = $this->razonSocial; 

      if($organizacion->codTipoDocumento == PPM_TipoDocumento::RUC){
        $organizacion->ruc = $this->ruc;
        $organizacion->documento_en_tramite = $this->enTramite;
      }else{
        $organizacion->documento_en_tramite = 0;
      }

      if($this->codCadena){
        $organizacion->tiene_act_economica = 1;
        $organizacion->codActividadEconomica = $this->codCadena;          
      }else{
        $organizacion->tiene_act_economica = 0;
      }
      
      $organizacion->codUnidadProductivaEnlazadaCITE = $this->getId();
      
      return $organizacion;

    }


    public static function GetUnidadesQueSeClonaranPPM() : Collection {
      
      $listaTipoPersoneria = TipoPersoneria::whereIn('nombre',TipoPersoneria::NombresTiposCopiarPPM)->get();
      $array = [];
      foreach ($listaTipoPersoneria as $tipo) {
        $array[] = $tipo->codTipoPersoneria;
      }

      $listaUnidades = UnidadProductiva::whereIn('codTipoPersoneria',$array)->get();
      return $listaUnidades;
    }
}
