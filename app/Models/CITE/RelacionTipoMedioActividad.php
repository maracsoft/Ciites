<?php

namespace App\Models\CITE;

use App\ArchivoGeneral;
use App\Distrito;
use App\Fecha;
use App\MedioVerificacionMeta;
use App\Mes;
use Illuminate\Database\Eloquent\Model;

class RelacionTipoMedioActividad extends Model
{
    public $table = "cite-relacion_tipomedio_actividad";
    protected $primaryKey ="codRelacion";

    public $timestamps = false;
    protected $fillable = [''];

    public function getActividad(){
      return ActividadCite::findOrFail($this->codActividad);
    }
    public function getTipoMedioVerificacion(){
      return TipoMedioVerificacion::findOrFail($this->codTipoMedioVerificacion);
    }
    
    public static function VerificarExistencia($codActividad,$codTipoMedioVerificacion){
      $cant = RelacionTipoMedioActividad::where('codActividad',$codActividad)->where('codTipoMedioVerificacion',$codTipoMedioVerificacion)->count();
      return $cant > 0 ;
    }

}