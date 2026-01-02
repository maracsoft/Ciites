<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;
//START MODEL_HELPER
/**
 * @property int $codArchivoReqEmp int(11)     
 * @property string $nombreDeGuardado varchar(100)     
 * @property int $codRequerimiento int(11)     
 * @property string $nombreAparente varchar(500)     
 * @method static ArchivoReqEmp findOrFail($primary_key)
 * @method static ArchivoReqEmp | null find($primary_key)
 * @method static ArchivoReqEmpCollection all()
 * @method static \App\Builders\ArchivoReqEmpBuilder query()
 * @method static \App\Builders\ArchivoReqEmpBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\ArchivoReqEmpBuilder where(string $column,string $value)
 * @method static \App\Builders\ArchivoReqEmpBuilder whereNotNull(string $column) 
 * @method static \App\Builders\ArchivoReqEmpBuilder whereNull(string $column) 
 * @method static \App\Builders\ArchivoReqEmpBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\ArchivoReqEmpBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class ArchivoReqEmp extends MaracModel
{
  public $table = "archivo_req_emp";
  protected $primaryKey = "codArchivoReqEmp";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['codArchivoReqEmp', 'nombreDeGuardado', 'nombreAparente', 'codRequerimiento'];


  public function getRequerimiento()
  {
    return RequerimientoBS::findOrFail($this->codRequerimiento);
  }

  public function eliminarArchivo()
  {

    $requerimiento = $this->getRequerimiento();


    $nombreArchivoABorrar = $this->nombreDeGuardado;
    $this->delete(); //primero eliminamos el archivo de la base de datos
    Storage::rename('requerimientos/' . $nombreArchivoABorrar, 'requerimientos/EsteSeBorrara.marac');    //nombre momentaneo para no tener problema al renombrar los otros


    //ahora recorremos los archivos de la reposicion para asignarles el nuevo nombre (para los que estaban adelante de esta, si antes eran 3 ahora serán 2)
    //eliminacion clasica de vector
    $listaArchivos = ArchivoReqEmp::where('codRequerimiento', '=', $requerimiento->codRequerimiento)->get();


    $j = 1;
    foreach ($listaArchivos as $itemArchivo) {
      $nombreViejo = $itemArchivo->nombreDeGuardado;
      $nombreNuevo = $requerimiento->getNombreGuardadoNuevoArchivoEmp($j);


      $itemArchivo->nombreDeGuardado = $nombreNuevo;
      $itemArchivo->save();
      if ($nombreNuevo != $nombreViejo)
        Storage::rename('requerimientos/' . $nombreViejo, 'requerimientos/' . $nombreNuevo);

      $j++;
    }

    Storage::disk('requerimientos')->delete("EsteSeBorrara.marac"); //ahora borramos el archivo en sí del sistema


  }
}
