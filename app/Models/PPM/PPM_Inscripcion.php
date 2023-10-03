<?php

namespace App\Models\PPM;

use App\Distrito;
use App\Fecha;
use App\Models\CITE\RelacionUsuarioUnidad;
use App\Models\PPM\PPM_Organizacion;
use App\Models\PPM\PPM_Persona;
use Exception;
use Illuminate\Database\Eloquent\Model;
/* 
ESTA TABLA REPRESENTA QUE UN USUARIO ESTÁ INSCRITO EN UNA ORGANIZACION (como socio)
*/

class PPM_Inscripcion extends Model
{
    public $table = "ppm-inscripcion";
    protected $primaryKey ="codRelacion";

    public $timestamps = false;
    protected $fillable = [''];


    public function getPersona(){
        return PPM_Persona::findOrFail($this->codPersona);
    }
    
    public function getOrganizacion(){
        return PPM_Organizacion::findOrFail($this->codOrganizacion);
    }
    

    public static function existeRelacion($codOrganizacion,$codPersona){
        $count = PPM_Inscripcion::where('codOrganizacion',$codOrganizacion)->where('codPersona',$codPersona)->count();
        return $count > 0;
    }

    public static function findByPersonaOrganizacion(PPM_Persona $persona, PPM_Organizacion $organizacion){
        return PPM_Inscripcion::where('codPersona',$persona->codPersona)
            ->where('codOrganizacion',$organizacion->codOrganizacion)->first();

    }

    //retorna true si eliminó la suscripcion del cite, y false si no habia suscripcion que eliminar
    public function eliminarSuscripcionCITE() : bool {
      $organizacion = $this->getOrganizacion();
      $persona = $this->getPersona();
      $enlace_cite_activado = $organizacion->tieneEnlaceCite();

      $retorno = false;

      if(!$enlace_cite_activado){
        throw new Exception("Erro en eliminarSuscripcionCITE() . No se puede porque el enlace de CITE no está activado ");
      }


      $unidad_productiva = $organizacion->getUnidadProductivaEnlazada();
      //aqui deberiamos eliminar al usuariocite de la unidad productiva
      $existe_usuario_cite = $persona->existeUsuarioCiteConEstosDatos();
      if($existe_usuario_cite){
        $usuario_cite = $persona->getUsuarioCiteConEstosDatos();
        $relaciones_cite = RelacionUsuarioUnidad::where('codUnidadProductiva',$unidad_productiva->getId())
            ->where('codUsuario',$usuario_cite->getId())
            ->get();
        if(count($relaciones_cite) == 0){
          //no hay relas que borrar
        }else{
          $relacion_cite = $relaciones_cite[0];
          $relacion_cite->delete();
          $retorno = true;
          
        }
        
      }

      return $retorno;
    }
}
