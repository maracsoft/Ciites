<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
//START MODEL_HELPER
/**
 * @property int $codArchivoRend int(11)     
 * @property string $nombreDeGuardado varchar(100)     
 * @property int $codRendicionGastos int(11)     
 * @property string $nombreAparente varchar(500)     
 * @method static ArchivoRendicion findOrFail($primary_key)
 * @method static ArchivoRendicion | null find($primary_key)
 * @method static ArchivoRendicionCollection all()
 * @method static \App\Builders\ArchivoRendicionBuilder query()
 * @method static \App\Builders\ArchivoRendicionBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\ArchivoRendicionBuilder where(string $column,string $value)
 * @method static \App\Builders\ArchivoRendicionBuilder whereNotNull(string $column) 
 * @method static \App\Builders\ArchivoRendicionBuilder whereNull(string $column) 
 * @method static \App\Builders\ArchivoRendicionBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\ArchivoRendicionBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class ArchivoRendicion extends MaracModel
{

  public $table = "archivo_rend";
  protected $primaryKey = "codArchivoRend";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['codArchivoRend', 'nombreDeGuardado', 'nombreAparente', 'codRendicionGastos'];

  public function getRendicion()
  {
    return RendicionGastos::findOrFail($this->codRendicionGastos);
  }



  public function eliminarArchivo()
  {

    $rendicion = $this->getRendicion();

    $nombreArchivoABorrar = $this->nombreDeGuardado;
    $this->delete(); //primero eliminamos el archivo de la base de datos


    //ahora recorremos los archivos de la rendicion para asignarles el nuevo nombre (para los que estaban adelante de esta, si antes eran 3 ahora serán 2)
    //eliminacion clasica de vector
    $listaArchivos = ArchivoRendicion::where('codRendicionGastos', '=', $rendicion->codRendicionGastos)->get();

    Storage::rename('comprobantes/rendiciones/' . $nombreArchivoABorrar, 'comprobantes/rendiciones/EsteSeBorrara.marac');    //nombre momentaneo para no tener problema al renombrar los otros


    $j = 1;
    foreach ($listaArchivos as $itemArchivo) {
      $nombreViejo = $itemArchivo->nombreDeGuardado;
      $nombreNuevo = $rendicion->getNombreGuardadoNuevoArchivo($j);
      //Debug::mensajeSimple("j=".$j.'Nombre viejo='.$nombreViejo."  nombreNuevo=".$nombreNuevo);

      $itemArchivo->nombreDeGuardado = $nombreNuevo;
      $itemArchivo->save();
      if ($nombreNuevo != $nombreViejo)
        Storage::rename('comprobantes/rendiciones/' . $nombreViejo, 'comprobantes/rendiciones/' . $nombreNuevo);

      $j++;
    }

    Storage::disk('rendiciones')->delete("EsteSeBorrara.marac"); //ahora borramos el archivo en sí del sistema


  }
}
