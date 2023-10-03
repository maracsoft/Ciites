<?php

namespace App\Models\PPM;

use App\ArchivoGeneral;
use App\Distrito;
use App\MaracModel;
use App\Models\PPM\PPM_EjecucionActividad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PPM_ArchivoEjecucion extends MaracModel
{
    public $table = "ppm-archivo_ejecucion";
    protected $primaryKey ="codArchivoEjecucion";

    public $timestamps = false;
    protected $fillable = [''];
    

    public function getArchivo(){
        return ArchivoGeneral::findOrFail($this->codArchivo);
    }

    public function getEjecucionActividad(){
        return PPM_EjecucionActividad::findOrFail($this->codEjecucionActividad);
    }
    

    /* la funcion que llame a este tiene que estar en un try catch */
    public function eliminarArchivo() {
        
        $archivoGeneral = $this->getArchivo();
        $nombreArchivoABorrar = $archivoGeneral->nombreGuardado;
        //primero eliminamos ambos registros de la base de datos
        $this->delete(); 
        $archivoGeneral->delete();

        //Ya no es necesario hacer el renombramiento de los otros archivos de esta entidad gracias al nuevo sistema de archivos de tabla unica

        Storage::disk('archivoGeneral')->delete($nombreArchivoABorrar); //ahora borramos el archivo en sí del sistema

    }

}
