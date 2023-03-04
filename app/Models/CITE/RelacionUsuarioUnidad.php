<?php

namespace App\Models\CITE;

use App\Distrito;
use App\Fecha;
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

}
