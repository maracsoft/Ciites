<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParametroSistema extends Model
{
    
    public $table = "parametro_sistema";
    protected $primaryKey ="codParametro";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    public static function getParametroSistema($nombreParametro){
        return ParametroSistema::where('nombre',$nombreParametro)->first();
    }

    public static function exportacionExcelActivada() : bool{
        return ParametroSistema::getParametroSistema('activarReportesAExcel')->valor == "true";
    }

    public function getDescripcionAcortada(){
      return Debug::abreviar($this->descripcion,100);
    }
    public function getTipo(){

      return TipoParametroSistema::findOrFail($this->codTipoParametro);
    }

}
