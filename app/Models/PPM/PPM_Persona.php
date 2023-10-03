<?php

namespace App\Models\PPM;


use App\ArchivoGeneral;
use App\Debug;
use App\Distrito;
use App\Empleado;
use App\Fecha;
use App\MaracModel;
use App\Models\CITE\UnidadProductiva;
use App\Models\CITE\UsuarioCite;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PPM_Persona extends MaracModel
{
    public $table = "ppm-persona";
    protected $primaryKey = "codPersona";

    public $timestamps = false;
    protected $fillable = [''];

    public function apareceEnOtrasTablas() : bool {
      $id = $this->getId();

      $cant = 0;
      $cant += PPM_Inscripcion::where('codPersona',$id)->count();
      $cant += PPM_Participacion::where('codPersona',$id)->count();
      $cant += PPM_RelacionPersonaSemestre::where('codPersona',$id)->count();
      $cant += PPM_AsistenciaDetalleprod::where('codPersona',$id)->count();
      $cant += PPM_DetalleProducto::where('codPersona',$id)->count();

      return $cant > 0;
    }
    
    public function sePuedeBorrar() : bool {
      return !$this->apareceEnOtrasTablas();
    }

    public static function findByDNI($dni) : PPM_Persona {
      $list = PPM_Persona::where('dni',$dni)->get();
      if(count($list) == 0){
          throw new Exception("No existe el PPM_Persona con el dni $dni");
      }
      
      return $list[0];
    }

    public static function existePersona($dni) : bool {
      $list = PPM_Persona::where('dni',$dni)->get();
      if(count($list) == 0){
        return false;
      }
      return true;

    }

    public function getResumenOrganizacionesAsociadas(){
      $lista = PPM_Inscripcion::where('codPersona',$this->codPersona)->get();
      $array_nombres = [];
      foreach ($lista as $inscripcion) {
        $org = $inscripcion->getOrganizacion();
        $array_nombres[] = $org->razon_social;
      }
      return implode(", ",$array_nombres);
    }

    public function getResumenCargosDeOrganizaciones(){
      $lista = PPM_Inscripcion::where('codPersona',$this->codPersona)->get();
      $array_nombres = [];
      foreach ($lista as $inscripcion) {
        $array_nombres[] = $inscripcion->cargo;
      }
      return implode(",",$array_nombres);
    }
    
    public function getResumenOrganizacionesAsociadasYcargo(){
      $lista = PPM_Inscripcion::where('codPersona',$this->codPersona)->get();
      $array_nombres = [];
      foreach ($lista as $inscripcion) {
        $org = $inscripcion->getOrganizacion();

        if($inscripcion->cargo != "" && $inscripcion->cargo != "-"){
          $cargo = $inscripcion->cargo;
          $cargo = " ($cargo)";  
        }else{
          $cargo = "";
        }

        $array_nombres[] = $org->razon_social.$cargo;
      }
      return implode(", ",$array_nombres);
    }


    public function getNombreCompleto(){
      return $this->nombres." ".$this->apellido_paterno." ".$this->apellido_materno;
    }

 
    public function getSexoLabel(){
      return PPM_Sexo::getSexoLabel($this->sexo);
    }

    public function getEmpleadoCreador(){
      return Empleado::findOrFail($this->codEmpleadoCreador);
    }
    public function getFechaHoraCreacion(){
      return Fecha::formatoFechaHoraParaVistas($this->fechaHoraCreacion);
    }

    public function getFechaNacimiento(){
      if($this->fecha_nacimiento)
        return Fecha::formatoParaVistas($this->fecha_nacimiento);
      return "";
    }
    
    
    public function procesarRequest(Request $request){
      $this->dni = $request->dni;
      $this->telefono = $request->telefono;
      $this->correo = $request->correo;
      $this->nombres = $request->nombres;
      $this->apellido_paterno = $request->apellido_paterno;
      $this->apellido_materno = $request->apellido_materno;
      $this->sexo = $request->sexo;
      
      $this->data_comprobada_reniec = 1;
      $this->necesita_comprobacion = 0;

      $this->updateNombreBusqueda();
      
      if($request->fecha_nacimiento)
        $this->fecha_nacimiento = Fecha::formatoParaSQL($request->fecha_nacimiento);
            

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
      $this->nombrecompleto_busqueda = trim($this->nombres)." ".trim($this->apellido_paterno)." ".trim($this->apellido_materno)." ".trim($this->nombres);

    }

 
    public function existeUsuarioCiteConEstosDatos() : bool {  
      $cont = UsuarioCite::where('dni',$this->dni)->count();
      if($cont == 0){
        return false;
      }

      return true;
    }
    public function getUsuarioCiteConEstosDatos() : UsuarioCite {
      return UsuarioCite::where('dni',$this->dni)->first();
    }

    public function crearUsuarioCiteConEstosDatos() : UsuarioCite {

      $usuario = new UsuarioCite();
      $usuario->dni = $this->dni;
      $usuario->nombres = mb_strtoupper($this->nombres);
      $usuario->apellidoPaterno = mb_strtoupper($this->apellido_paterno);
      $usuario->apellidoMaterno = mb_strtoupper($this->apellido_materno);
      $usuario->telefono = $this->telefono;
      $usuario->correo = $this->correo;

      $usuario->fechaHoraCreacion = Carbon::now();
      $usuario->codEmpleadoCreador =Empleado::getEmpleadoLogeado()->getId();
      $usuario->updateNombreBusqueda();
      
      $usuario->save();
      return $usuario;
    }
}
