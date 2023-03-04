<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ArchivoGeneral extends Model
{
    public $table = "archivo_general";
    protected $primaryKey ="codArchivo";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['nombreGuardado','nombreAparente'];

    /* LA FUNCION ELIMINAR ARCHIVO ESTÁ IMPLEMENTADA EN LA TABLA INTERMEDIA ENTRE archivo_general y la tabla principal que queremos linkear */



    public function getTipo(){
        return TipoArchivoGeneral::findOrFail($this->codTipoArchivo);
    }
    // akd.png
    //recibimos el nombre aparente para sacarle la terminacion
    static function formatoNombre($id,$nombreAparente){
       
        $indice =  mb_strrpos($nombreAparente,".");
        if($indice==false){
            error_log("ArchivoGeneral::formatoNombre , el archivo $nombreAparente NO TIENE TERMINACIÓN");
            $terminacion = "";
        }else{
            $lengthTerminacion = mb_strlen($nombreAparente) - $indice; 
            $terminacion = mb_substr($nombreAparente,$indice,$lengthTerminacion);
        }
            
        
        return "ArchGeneral_".$id.$terminacion;
    }

}
