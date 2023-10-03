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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Servicio extends Model
{
    public $table = "cite-servicio";
    protected $primaryKey ="codServicio";

    public $timestamps = false;
    protected $fillable = [''];

    public function getMesAño(){
        return MesAño::findOrFail($this->codMesAño);
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


    public function getTipoCDP(){
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


    /* OBJETOS REPORTES */
    static function getReporteServiciosPorRegion(){
        $sqlServiciosPorRegion =
            "SELECT count(S.codServicio) as cantidad, DEP.nombre as region, DEP.codDepartamento FROM `cite-servicio` S
                INNER JOIN distrito D on S.codDistrito = D.codDistrito
                INNER JOIN provincia P on P.codProvincia = D.codProvincia
                INNER JOIN departamento DEP on DEP.codDepartamento = P.codDepartamento
                GROUP BY DEP.codDepartamento,DEP.nombre
                ORDER BY count(S.codServicio) DESC";


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


    public static function getReporteServiciosPorProvincia($codDepartamento){

        $sqlServiciosPorProvincia =
            "SELECT count(S.codServicio) as cantidad, P.nombre as provincia, DEP.nombre as departamento, P.codProvincia FROM `cite-servicio` S
                    INNER JOIN distrito D on S.codDistrito = D.codDistrito
                    INNER JOIN provincia P on P.codProvincia = D.codProvincia
                    INNER JOIN departamento DEP on DEP.codDepartamento = P.codDepartamento
                    WHERE DEP.codDepartamento = $codDepartamento
                    GROUP BY P.codProvincia,P.nombre,DEP.nombre
                    ORDER BY count(S.codServicio) DESC";


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

    public static function getReporteServiciosPorUnidad(){


        $sqlServiciosPorUnidad =
            "SELECT
                UP.codUnidadProductiva,
                UP.razonSocial as razonSocial ,
                UP.nombrePersona as nombrePersona ,
                count(S.codServicio) as CantidadServicios,
                sum(nroHorasEfectivas) as HorasAcumuladas
            FROM `cite-unidad_productiva` UP
            INNER JOIN `cite-servicio` S on S.codUnidadProductiva = UP.codUnidadProductiva
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
