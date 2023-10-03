<?php

namespace App\Models\CITE;

use App\Distrito;
use App\Fecha;
use App\Models\PPM\PPM_Inscripcion;
use Exception;
use Illuminate\Database\Eloquent\Model;
/* 
ESTA TABLA REPRESENTA QUE UN USUARIO ESTÁ INSCRITO EN UNA UNIDAD PRODUCTIVA (como socio)
*/
class RelacionUsuarioUnidad extends Model
{
    public $table = "cite-relacion_usuario_unidad";
    protected $primaryKey ="codRelacionUsuarioUnidad";

    public $timestamps = false;
    protected $fillable = [''];

    public function getUsuario(){
        return UsuarioCite::findOrFail($this->codUsuario);
    }
    
    public function getUnidadProductiva(){
        return UnidadProductiva::findOrFail($this->codUnidadProductiva);
    }
    

    public static function existeRelacion($codUnidadProductiva,$codUsuario){
        $lista = RelacionUsuarioUnidad::where('codUnidadProductiva',$codUnidadProductiva)->where('codUsuario',$codUsuario)->get();
        return count($lista)>0;
    }


    //retorna true si eliminó la suscripcion del cite, y false si no habia suscripcion que eliminar
    public function eliminarSuscripcionPPM() : bool {
      $unidad_productiva = $this->getUnidadProductiva();
      $usuario_cite = $this->getUsuario();
      $enlace_ppm_activado = $unidad_productiva->tieneEnlacePPM();

      $retorno = false;

      if(!$enlace_ppm_activado){
        throw new Exception("Erro en eliminarSuscripcionCITE() . No se puede porque el enlace de PPM no está activado ");
      }


      $organizacion = $unidad_productiva->getOrganizacionEnlazada();
      //aqui deberiamos eliminar al usuariocite de la unidad productiva
      $existe_persona_ppm = $usuario_cite->existePersonaPPMConEstosDatos();
      if($existe_persona_ppm){
        
        $persona = $usuario_cite->getPersonaPPMConEstosDatos();
        $relaciones_ppm = PPM_Inscripcion::where('codOrganizacion',$organizacion->getId())
            ->where('codPersona',$persona->getId())
            ->get();

        if(count($relaciones_ppm) == 0){
          //no hay relas que borrar
        }else{
          $relacion_ppm = $relaciones_ppm[0];
          $relacion_ppm->delete();
          $retorno = true;
        }
        
      }

      return $retorno;
    }

}
