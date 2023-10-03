<?php

namespace App\Models\CITE;

use App\ArchivoGeneral;
use App\Distrito;
use App\MaracModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ArchivoServicio extends MaracModel
{
    public $table = "cite-archivo_servicio";
    protected $primaryKey ="codArchivoServicio";

    public $timestamps = false;
    protected $fillable = [''];
    
    public function tieneTipoArchivo(){
      return $this->codTipoMedioVerificacion != null;
    }
    public function getTipoArchivo(){
      return TipoMedioVerificacion::findOrFail($this->codTipoMedioVerificacion);
    }

    public function getArchivo(){
        return ArchivoGeneral::findOrFail($this->codArchivo);
    }

    public function getServicio(){
        return Servicio::findOrFail($this->codServicio);
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
