<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
//START MODEL_HELPER
/**
 * @property int $codArchivo int(11)     
 * @property string $nombreAparente varchar(300)     
 * @property string $nombreGuardado varchar(300)     
 * @property int $codTipoArchivo int(11)     
 * @method static ArchivoGeneral findOrFail($primary_key)
 * @method static ArchivoGeneral | null find($primary_key)
 * @method static ArchivoGeneralCollection all()
 * @method static \App\Builders\ArchivoGeneralBuilder query()
 * @method static \App\Builders\ArchivoGeneralBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\ArchivoGeneralBuilder where(string $column,string $value)
 * @method static \App\Builders\ArchivoGeneralBuilder whereNotNull(string $column) 
 * @method static \App\Builders\ArchivoGeneralBuilder whereNull(string $column) 
 * @method static \App\Builders\ArchivoGeneralBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\ArchivoGeneralBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class ArchivoGeneral extends MaracModel
{
  public $table = "archivo_general";
  protected $primaryKey = "codArchivo";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['nombreGuardado', 'nombreAparente'];

  /* LA FUNCION ELIMINAR ARCHIVO ESTÁ IMPLEMENTADA EN LA TABLA INTERMEDIA ENTRE archivo_general y la tabla principal que queremos linkear */



  public function getTipo()
  {
    return TipoArchivoGeneral::findOrFail($this->codTipoArchivo);
  }
  // akd.png
  //recibimos el nombre aparente para sacarle la terminacion
  static function formatoNombre($id, $nombreAparente)
  {

    $indice =  mb_strrpos($nombreAparente, ".");
    if ($indice == false) {
      error_log("ArchivoGeneral::formatoNombre , el archivo $nombreAparente NO TIENE TERMINACIÓN");
      $terminacion = "";
    } else {
      $lengthTerminacion = mb_strlen($nombreAparente) - $indice;
      $terminacion = mb_substr($nombreAparente, $indice, $lengthTerminacion);
    }


    return "ArchGeneral_" . $id . $terminacion;
  }
}
