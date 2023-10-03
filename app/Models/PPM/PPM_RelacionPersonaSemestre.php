<?php

namespace App\Models\PPM;

use App\Debug;
use App\Departamento;
use App\Distrito;
use App\Empleado;
use App\Fecha;
use App\Models\PPM\PPM_Organizacion;
use App\Models\PPM\PPM_Persona;
use App\Semestre;
use Illuminate\Database\Eloquent\Model;
/* 
ESTA TABLA REPRESENTA QUE UN USUARIO ESTÁ INSCRITO EN UNA UNIDAD PRODUCTIVA (como socio)
*/

class PPM_RelacionPersonaSemestre extends Model
{
    public $table = "ppm-relacion_persona_semestre";
    protected $primaryKey ="codRelacion";

    public $timestamps = false;
    protected $fillable = [''];


    public function getPersona(){
        return PPM_Persona::findOrFail($this->codPersona);
    }
    
    public function getSemestre(){
        return Semestre::findOrFail($this->codSemestre);
    }

    public function getRealizoAccion22(){
      return PPM_RealizoAccionOption::findOrFail($this->ind22_realizo_accion_id);
    }
    

    public static function existeRelacion($codSemestre,$codPersona){
      $count = PPM_RelacionPersonaSemestre::where('codSemestre',$codSemestre)->where('codPersona',$codPersona)->count();
      return $count > 0;
    }
    public static function FindRelacion($codSemestre,$codPersona) : PPM_RelacionPersonaSemestre {
      $list = PPM_RelacionPersonaSemestre::where('codSemestre',$codSemestre)->where('codPersona',$codPersona)->get();
      return $list[0];
    }

    public function getEmpleadosCreadores(){
      
      $ejecuciones = $this->getEjecucionesQueSustentan();
      $array = [];
      foreach ($ejecuciones as $ejec) {
        $array[] = $ejec->codEmpleadoCreador;
      }

      return Empleado::whereIn('codEmpleado',$array)->get();
    }

    
    public function getDepartamentosEjecucion(){
      
      $ejecuciones = $this->getEjecucionesQueSustentan();
      $array = [];
      foreach ($ejecuciones as $ejec) {
        $array[] = $ejec->codDepartamento;
      }
      
      return Departamento::whereIn('codDepartamento',$array)->get();
    }

    public function getCodsEjecucionesSinParentesis(){
      $string = str_replace("(","",$this->codsEjecuciones);
      $string = str_replace(")","",$string);
      return $string;
    }

    public function getEjecucionesQueSustentan(){
      $string = str_replace("(","",$this->codsEjecuciones);
      $string = str_replace(")","",$string);
      
      $array = explode(",",$string);

      return PPM_EjecucionActividad::whereIn('codEjecucionActividad',$array)->get();
    }
    
    public function añadirEjecucionQueSustenta(PPM_EjecucionActividad $ejecucion){
 
 
     

      $ejecuciones = $this->getEjecucionesQueSustentan();
      $codsEjecuciones_new = [];
      foreach ($ejecuciones as $ejec) {
        $codsEjecuciones_new[] = "(".$ejec->codEjecucionActividad.")";
      }
      
      $new = "(".$ejecucion->codEjecucionActividad.")";
       
      
      if(!in_array($new,$codsEjecuciones_new)){
       
        $codsEjecuciones_new[] = $new;
      }
      asort($codsEjecuciones_new);
      
      $this->codsEjecuciones = implode(",",$codsEjecuciones_new);

     
       
    }


    /*
      Esta funcion busca si hay otra participacion que involucre a esa persona y semestre,
      CASO SÍ HAY -> No lo elimina (el registro de PPM_RelacionPersonaSemestre) 
      CASO NO HAY -> Lo elimina (el registro de PPM_RelacionPersonaSemestre) 
    */
    public static function EliminarRelacionPersonaSemestre_NoSustentadas(PPM_Persona $persona, PPM_EjecucionActividad $ejecucion){
       
      
      $semestres = $ejecucion->getSemestres();
      foreach ($semestres as $semestre) {
        $participaciones = PPM_Participacion::where('codPersona',$persona->codPersona)
        ->where('codsSemestres','like',"%".$semestre->codSemestre."%")
        ->join('ppm-ejecucion_actividad','ppm-participacion.codEjecucionActividad','=','ppm-ejecucion_actividad.codEjecucionActividad')
        ->get();

        
        if(count($participaciones) == 0){
          $existe = PPM_RelacionPersonaSemestre::existeRelacion($semestre->codSemestre,$persona->codPersona);
          if($existe){
            $relacion = PPM_RelacionPersonaSemestre::FindRelacion($semestre->codSemestre,$persona->codPersona);
            Debug::LogMessage("PPM_Participacion. No hay ninguna participacion que sustente la relacion, se borrará. RELACION:". json_encode($relacion));
            $relacion->delete();
          }
          
        }
      }

    }


}
