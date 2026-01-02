<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
//START MODEL_HELPER

/**
 * @property int $codArchivoSolicitud int(11)
 * @property string $nombreDeGuardado varchar(200)
 * @property int $codSolicitud int(11)
 * @property string $nombreAparente varchar(100)
 * @method static ArchivoSolicitud findOrFail($primary_key)
 * @method static ArchivoSolicitud | null find($primary_key)
 * @method static ArchivoSolicitudCollection all()
 * @method static \App\Builders\ArchivoSolicitudBuilder query()
 * @method static \App\Builders\ArchivoSolicitudBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\ArchivoSolicitudBuilder where(string $column,string $value)
 * @method static \App\Builders\ArchivoSolicitudBuilder whereNotNull(string $column)
 * @method static \App\Builders\ArchivoSolicitudBuilder whereNull(string $column)
 * @method static \App\Builders\ArchivoSolicitudBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\ArchivoSolicitudBuilder orderBy(string $column,array $sentido)
 */
//END MODEL_HELPER
class ArchivoSolicitud extends MaracModel
{
  public $table = "archivo_solicitud";
  protected $primaryKey = "codArchivoSolicitud";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['nombreDeGuardado', 'nombreAparente', 'codSolicitud'];


  public function eliminarArchivo()
  {
    $solicitud = SolicitudFondos::findOrFail($this->codSolicitud);

    $nombreArchivoABorrar = $this->nombreDeGuardado;
    $this->delete(); //primero eliminamos el archivo de la base de datos
    Storage::rename('solicitudes/' . $nombreArchivoABorrar, 'solicitudes/EsteSeBorrara.marac');    //nombre momentaneo para no tener problema al renombrar los otros


    //ahora recorremos los archivos de la reposicion para asignarles el nuevo nombre (para los que estaban adelante de esta, si antes eran 3 ahora serán 2)
    //eliminacion clasica de vector
    $listaArchivos = ArchivoSolicitud::where('codSolicitud', '=', $solicitud->codSolicitud)->get();


    $j = 1;
    foreach ($listaArchivos as $itemArchivo) {
      $nombreViejo = $itemArchivo->nombreDeGuardado;
      $nombreNuevo = $solicitud->getNombreGuardadoNuevoArchivo($j);


      $itemArchivo->nombreDeGuardado = $nombreNuevo;
      $itemArchivo->save();
      if ($nombreNuevo != $nombreViejo)
        Storage::rename('solicitudes/' . $nombreViejo, 'solicitudes/' . $nombreNuevo);

      $j++;
    }

    Storage::disk('solicitudes')->delete("EsteSeBorrara.marac"); //ahora borramos el archivo en sí del sistema


  }
}
