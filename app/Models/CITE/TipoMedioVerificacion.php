<?php

namespace App\Models\CITE;

use App\ArchivoGeneral;
use App\Distrito;
use App\Fecha;
use App\MaracModel;
use App\Mes;
use Illuminate\Database\Eloquent\Model;

class TipoMedioVerificacion extends MaracModel
{
    public $table = "cite-tipo_medio_verificacion";
    protected $primaryKey ="codTipoMedioVerificacion";

    public $timestamps = false;
    protected $fillable = [''];


    public static function TodosOrdenadosPorFormato(){
      return TipoMedioVerificacion::orderBy("indice_formato",'ASC')->get();
    } 
    
    public function tieneArchivoGeneral(){
      return $this->codArchivo != null;
       
    }
    public function getArchivoGeneral() : ArchivoGeneral {
      return ArchivoGeneral::findOrFail($this->codArchivo);
       
    }
    public function getLabel(){
      return "Formato N°" . $this->indice_formato." ".$this->nombre;
    }
}