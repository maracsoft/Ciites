<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoArchivoGeneral extends Model
{
    public $table = "tipo_archivo_general";
    protected $primaryKey ="codTipoArchivo";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = [];
    
    static function getCodigo($nombre){
        return TipoArchivoGeneral::where('nombre',$nombre)->get()[0]->getId();
    }

    
}
