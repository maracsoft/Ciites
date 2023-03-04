<?php

namespace App\Models\CITE;

use App\ArchivoGeneral;
use App\Distrito;
use App\Fecha;
use App\Mes;
use Illuminate\Database\Eloquent\Model;

class ActividadCite extends Model
{
    public $table = "cite-actividad";
    protected $primaryKey ="codActividad";

    public $timestamps = false;
    protected $fillable = [''];

    public function TipoServicio(){
        return TipoServicio::findOrFail($this->codTipoServicio);
    }
    
    public function getTexto(){
        return $this->indice." ".$this->nombre;

    }

}