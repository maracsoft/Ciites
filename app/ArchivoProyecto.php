<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


//START MODEL_HELPER
/**
 * @property int $codArchivoProyecto int(11)     
 * @property string $nombreDeGuardado varchar(100)     
 * @property int $codProyecto int(11)     
 * @property string $fechaHoraSubida datetime     
 * @property int $codTipoArchivoProyecto int(11)     
 * @property string $nombreAparente varchar(100)     
 * @method static ArchivoProyecto findOrFail($primary_key)
 * @method static ArchivoProyecto | null find($primary_key)
 * @method static ArchivoProyectoCollection all()
 * @method static \App\Builders\ArchivoProyectoBuilder query()
 * @method static \App\Builders\ArchivoProyectoBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\ArchivoProyectoBuilder where(string $column,string $value)
 * @method static \App\Builders\ArchivoProyectoBuilder whereNotNull(string $column) 
 * @method static \App\Builders\ArchivoProyectoBuilder whereNull(string $column) 
 * @method static \App\Builders\ArchivoProyectoBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\ArchivoProyectoBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class ArchivoProyecto extends MaracModel
{
  public $table = "archivo_proyecto";
  protected $primaryKey = "codArchivoProyecto";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  //                      con este nombre se guarda en la carpeta
  protected $fillable = [
    'nombreDeGuardado',
    'nombreAparente', //este es el nombre con el que se sube el archivo, y se guarda en la bd
    'codProyecto',
    'fechaHoraSubida'
  ];

  //FORMATO PARA NOMBRE DE GUARDADO
  //ArchProy-000000-00.marac

  public function getTipoArchivo()
  {
    return TipoArchivoProyecto::findOrFail($this->codTipoArchivoProyecto);
  }

  public function eliminarArchivo()
  {
    $proyecto = Proyecto::findOrFail($this->codProyecto);

    $nombreArchivoABorrar = $this->nombreDeGuardado;
    $this->delete(); //primero eliminamos el registro del archivo de la base de datos
    Storage::rename('proyectos/' . $nombreArchivoABorrar, 'proyectos/EsteSeBorrara.marac');    //nombre momentaneo para no tener problema al renombrar los otros

    //ahora recorremos los archivos de la reposicion para asignarles el nuevo nombre (para los que estaban adelante de esta, si antes eran 3 ahora serán 2)
    //eliminacion clasica de vector
    $listaArchivos = ArchivoProyecto::where('codProyecto', '=', $proyecto->codProyecto)->get();


    $j = 1;
    foreach ($listaArchivos as $itemArchivo) {
      $nombreViejo = $itemArchivo->nombreDeGuardado;
      $nombreNuevo = $proyecto->getNombreGuardadoNuevoArchivo($j);


      $itemArchivo->nombreDeGuardado = $nombreNuevo;
      $itemArchivo->save();
      if ($nombreNuevo != $nombreViejo)
        Storage::rename('proyectos/' . $nombreViejo, 'proyectos/' . $nombreNuevo);

      $j++;
    }

    Storage::disk('proyectos')->delete("EsteSeBorrara.marac"); //ahora borramos el archivo en sí del sistema


  }
}
