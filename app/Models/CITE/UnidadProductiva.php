<?php

namespace App\Models\CITE;


use App\Distrito;
use App\Empleado;
use App\Fecha;
use App\MesAño;
use Exception;
use Illuminate\Database\Eloquent\Model;


class UnidadProductiva extends Model
{
    public $table = "cite-unidad_productiva";
    protected $primaryKey ="codUnidadProductiva";

    public $timestamps = false;
    protected $fillable = [''];





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
        $objMesAño = MesAño::where('codMes',$mes)->where('año',$año)->first();

        return Servicio::where('codUnidadProductiva',$this->getId())
                ->where('codMesAño',$objMesAño->getId())
                ->get();

    }
    function getServiciosMesConv(int $mes ,int $año,bool $conConvenio){
        $objMesAño = MesAño::where('codMes',$mes)->where('año',$año)->first();

        if($conConvenio)
            $conv_str = 1;
        else
            $conv_str = 2;

        return Servicio::where('codUnidadProductiva',$this->getId())
                ->where('codMesAño',$objMesAño->getId())->where('codModalidad',$conv_str)
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
}
