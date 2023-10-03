<?php

namespace App\Models\CITE;

use App\ArchivoGeneral;
use App\Distrito;
use App\Fecha;
use App\MedioVerificacionMeta;
use App\Mes;
use Illuminate\Database\Eloquent\Model;

class ActividadCite extends Model
{
    public $table = "cite-actividad";
    protected $primaryKey ="codActividad";

    public $timestamps = false;
    protected $fillable = [''];


    public static function getActividadesConConvenio(){
      $codModalidadConvenio = 1;

      $array_cods_tiposervicios_convenio = [];
      $listaTiposServicioConvenio = TipoServicio::where('codModalidad','=',$codModalidadConvenio)->get();
      foreach ($listaTiposServicioConvenio as $tipo_serv) {
        $array_cods_tiposervicios_convenio[] = $tipo_serv->getId();
      }
      
      $listaActividades = ActividadCite::whereIn('codTipoServicio',$array_cods_tiposervicios_convenio)->get();
      return $listaActividades;
    }
    public function getIndicadores(){
      return IndicadorActividadCite::where('codActividad',$this->codActividad)->orderBy('orden','ASC')->get();
    }
    public function getTipoServicio(){
        return TipoServicio::findOrFail($this->codTipoServicio);
    }
    
    public function getTexto(){
        return $this->indice." ".$this->nombre;
    }

    public function getTextoDescripcion(){
        return $this->indice." ".$this->descripcion;
    }

    public function getCantidadIndicadores(){
      $cant2 = IndicadorActividadCite::where('codActividad',$this->codActividad)->count();
      return $cant2;
    }
    public function apareceEnOtrasTablas(){
      $cant1 = RelacionTipoMedioActividad::where('codActividad',$this->codActividad)->count();
      $cant2 = IndicadorActividadCite::where('codActividad',$this->codActividad)->count();
      $cant = $cant1 + $cant2;
      
      return $cant > 0 ;
    }

    public function getCantidadArchivosNecesarios(){
      return RelacionTipoMedioActividad::where('codActividad',$this->codActividad)->count();
    }

    public function getRelacionesTipoMedioVerificacion(){
      return RelacionTipoMedioActividad::where('codActividad',$this->codActividad)->orderBy('nro_orden','asc')->get();
    }


    public function getListaTipoMedioVerificacion(){
      $relaciones = $this->getRelacionesTipoMedioVerificacion();
      $codsTipoMedio=[];
      foreach ($relaciones as $relacion) {
        $codsTipoMedio[] = $relacion->codTipoMedioVerificacion; 
      }

      $listaTipoMedio = TipoMedioVerificacion::whereIn('cite-tipo_medio_verificacion.codTipoMedioVerificacion',$codsTipoMedio)
      ->where('cite-relacion_tipomedio_actividad.codActividad','=',$this->codActividad)
      ->join('cite-relacion_tipomedio_actividad','cite-relacion_tipomedio_actividad.codTipoMedioVerificacion','=','cite-tipo_medio_verificacion.codTipoMedioVerificacion')
      ->orderBy('nro_orden','ASC')
      ->get();
      return $listaTipoMedio;

    }

}