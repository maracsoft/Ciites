<?php

namespace App\Models\CITE;

use App\ArchivoGeneral;
use App\Distrito;
use App\Fecha;
use App\MedioVerificacionMeta;
use App\Mes;
use Illuminate\Database\Eloquent\Model;

class MesConvenioCite extends Model
{
    public $table = "cite-mes_convenio";
    protected $primaryKey ="codMes";

    public $timestamps = false;
    protected $fillable = [''];

    public function getFechaInicio(){
      return Fecha::formatoParaVistas($this->fecha_inicio);
    }
    public function getFechaFin(){
      return Fecha::formatoParaVistas($this->fecha_fin);
    }
    
    public function getDescripcion(){
      return "Del ".$this->getFechaInicio()." al ".$this->getFechaFin();
    }
    

}