<?php

namespace App\Models\CITE;

use App\Distrito;
use App\Fecha;
use Illuminate\Database\Eloquent\Model;

class AsistenciaServicio extends Model
{
    public $table = "cite-asistencia_servicio";
    protected $primaryKey ="codAsistenciaServicio";

    public $timestamps = false;
    protected $fillable = [''];

    public function getUsuario(){
        return UsuarioCite::findOrFail($this->codUsuario);
    }
    
    public function getServicio(){
        return Servicio::findOrFail($this->codServicio);
    }
    

    public static function existeRelacion($codServicio,$codUsuario){
        $lista = AsistenciaServicio::where('codServicio',$codServicio)->where('codUsuario',$codUsuario)->get();
        return count($lista)>0;
    }

    public function esExterno(){
        return $this->externo==1;
    }

}
