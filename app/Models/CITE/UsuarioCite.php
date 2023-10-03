<?php

namespace App\Models\CITE;

use App\Distrito;
use App\Empleado;
use App\Fecha;
use App\Models\PPM\PPM_Persona;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsuarioCite extends Model
{
    public $table = "cite-usuario";
    protected $primaryKey ="codUsuario";

    public $timestamps = false;
    protected $fillable = [''];
    
    public static function findByDNI($dni) : UsuarioCite {
      $list = UsuarioCite::where('dni',$dni)->get();
      if(count($list) == 0){
          throw new Exception("No existe el UsuarioCite con el dni $dni");
      }

      return $list[0];
    }

    function existePersonaPPMConEstosDatos() : bool {
      $cont = PPM_Persona::where('dni',$this->dni)->count();
      if($cont == 0){
        return false;
      }

      return true;
    }

    function getPersonaPPMConEstosDatos() : PPM_Persona {
      return PPM_Persona::where('dni',$this->dni)->first();
    }



    function crearPersonaPPMConEstosDatos(){
      
      $persona = new PPM_Persona();
      $persona->dni = $this->dni;
      $persona->nombres = mb_strtoupper($this->nombres);
      $persona->apellido_paterno = mb_strtoupper($this->apellidoPaterno);
      $persona->apellido_materno = mb_strtoupper($this->apellidoMaterno);
      $persona->telefono = $this->telefono;
      $persona->correo = $this->correo;
      
      $persona->data_comprobada_reniec = 0;
      $persona->necesita_comprobacion = 0;

      $persona->fechaHoraCreacion = Carbon::now();
      $persona->codEmpleadoCreador =Empleado::getEmpleadoLogeado()->getId();
      $persona->updateNombreBusqueda();
      
      $persona->save();
      return $persona;
    }

    function getRelaUnidadProductiva(){
        return RelacionUsuarioUnidad::where('codUsuario',$this->getId())->get();
    }

    function getNombreCompleto(){
        return $this->nombres." ".$this->apellidoPaterno." ".$this->apellidoMaterno;
    }

    function getCantidadServicios(){
        return count($this->getServicios());
    }
    function getCantidadUnidades(){
        return count($this->getRelaUnidadProductiva());
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
    

    function apareceEnOtrasTablas(){
      $count = AsistenciaServicio::where('codUsuario',$this->getId())->count();
      if($count != 0){
        error_log("el usuario ".$this->getId()." aparece en AsistenciaServicio");

        return true;
      }

      $count = RelacionUsuarioUnidad::where('codUsuario',$this->getId())->count();
      if($count != 0){
        error_log("el usuario ".$this->getId()." aparece en RelacionUsuarioUnidad");
        
        return true;
      }

      $count = UnidadProductiva::where('codUsuarioGerente',$this->getId())->orWhere('codUsuarioPresidente',$this->getId())->count();
      if($count != 0){
        error_log("el usuario ".$this->getId()." aparece en UnidadProductiva");
        
        return true;
      }

      return false;
    }


    function updateNombreBusqueda(){
      /* 
      UPDATE `cite-usuario` SET  `nombrecompleto_busqueda`= CONCAT(
          TRIM(nombres),' ',
          TRIM(apellidoPaterno),' ',
          TRIM(apellidoMaterno),' ',
          TRIM(nombres)
      )
      
      */
      $this->nombrecompleto_busqueda = trim($this->nombres)." ".trim($this->apellidoPaterno)." ".trim($this->apellidoMaterno)." ".trim($this->nombres);

    }

    /* esta funcion se llamará despues de ejecutar la migracion */
    public static function ActualizarNombresBusquedaTodosLosUsuarios(){
      try {
        DB::beginTransaction();
        $listaUsuarios = UsuarioCite::All();
        foreach ($listaUsuarios as $user) {
          $user->updateNombreBusqueda();
          $user->save();  
        }
        error_log("ActualizarNombresBusquedaTodosLosUsuarios EJECUTADA EXITOSAMENTE");

        DB::commit();
      } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;
      }

    }
}
