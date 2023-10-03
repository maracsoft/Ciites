<?php

namespace App\Models\CITE;

use App\Distrito;
use App\Empleado;
use App\Fecha;
use Illuminate\Database\Eloquent\Model;

class UsuarioCite extends Model
{
    public $table = "cite-usuario";
    protected $primaryKey ="codUsuario";

    public $timestamps = false;
    protected $fillable = [''];
    
    function getRelaUnidadProductiva(){
        return RelacionUsuarioUnidad::where('codUsuario',$this->getId())->get();
    }

    function getNombreCompleto(){
        return $this->nombres." ".$this->apellidoPaterno." ".$this->apellidoMaterno;

    }
    function getCantidadServicios(){
        return count($this->getServicios());
    }

    function getServicios(){
        $listaAsistenciaServicio = AsistenciaServicio::where('codUsuario',$this->getId())->get();

        $array = [];
        foreach ($listaAsistenciaServicio as $usuarioServ) {
            array_push($array,$usuarioServ->codServicio);
        }

        $listaServicios = Servicio::whereIn('codServicio',$array)->get();
        return $listaServicios;

    }
    function getFechaHoraCreacion(){

        return Fecha::formatoFechaHoraParaVistas($this->fechaHoraCreacion);
    }

    function getEmpleadoCreador(){
        return Empleado::findOrFail($this->codEmpleadoCreador);
    }

    function getServiciosEnQueNoParticipo(){
        $arr = [];
        $listaServicios = Servicio::All();
        foreach($listaServicios as $serv){
            if(!$serv->verificarAsistenciaDeUsuario($this->getId()))
                array_push($arr,$serv->getId());
        }

        return Servicio::whereIn('codServicio',$arr)->get();


    }
}
