<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
//START MODEL_HELPER
/**
 * @property int $codArchivoOrden int(11)     
 * @property string $nombreGuardado varchar(100)     
 * @property int $codOrdenCompra int(11)     
 * @property string $nombreAparente varchar(300)     
 * @method static ArchivoOrdenCompra findOrFail($primary_key)
 * @method static ArchivoOrdenCompra | null find($primary_key)
 * @method static ArchivoOrdenCompraCollection all()
 * @method static \App\Builders\ArchivoOrdenCompraBuilder query()
 * @method static \App\Builders\ArchivoOrdenCompraBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\ArchivoOrdenCompraBuilder where(string $column,string $value)
 * @method static \App\Builders\ArchivoOrdenCompraBuilder whereNotNull(string $column) 
 * @method static \App\Builders\ArchivoOrdenCompraBuilder whereNull(string $column) 
 * @method static \App\Builders\ArchivoOrdenCompraBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\ArchivoOrdenCompraBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class ArchivoOrdenCompra extends MaracModel
{
  public $table = "archivo_orden";
  protected $primaryKey = "codArchivoOrden";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['nombreGuardado', 'nombreAparente', 'codOrdenCompra'];


  public function eliminarArchivo()
  {
    $orden = OrdenCompra::findOrFail($this->codOrdenCompra);

    $nombreArchivoABorrar = $this->nombreGuardado;
    $this->delete(); //primero eliminamos el archivo de la base de datos
    Storage::rename('ordenes/' . $nombreArchivoABorrar, 'ordenes/EsteSeBorrara.marac');    //nombre momentaneo para no tener problema al renombrar los otros


    //ahora recorremos los archivos de la reposicion para asignarles el nuevo nombre (para los que estaban adelante de esta, si antes eran 3 ahora serán 2)
    //eliminacion clasica de vector
    $listaArchivos = ArchivoOrdenCompra::where('codOrdenCompra', '=', $orden->codOrdenCompra)->get();


    $j = 1;
    foreach ($listaArchivos as $itemArchivo) {
      $nombreViejo = $itemArchivo->nombreGuardado;
      $nombreNuevo = $orden->getNombreGuardadoNuevoArchivo($j);


      $itemArchivo->nombreGuardado = $nombreNuevo;
      $itemArchivo->save();
      if ($nombreNuevo != $nombreViejo)
        Storage::rename('ordenes/' . $nombreViejo, 'ordenes/' . $nombreNuevo);

      $j++;
    }

    Storage::disk('ordenes')->delete("EsteSeBorrara.marac"); //ahora borramos el archivo en sí del sistema


  }
}
