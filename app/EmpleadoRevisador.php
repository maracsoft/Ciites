<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codEmpleadoRevisador int(11)     
 * @property int $codRevision int(11)     
 * @property int $codEmpleado int(11)     
 * @property int $codSede int(11)     
 * @method static EmpleadoRevisador findOrFail($primary_key)
 * @method static EmpleadoRevisador | null find($primary_key)
 * @method static EmpleadoRevisadorCollection all()
 * @method static \App\Builders\EmpleadoRevisadorBuilder query()
 * @method static \App\Builders\EmpleadoRevisadorBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\EmpleadoRevisadorBuilder where(string $column,string $value)
 * @method static \App\Builders\EmpleadoRevisadorBuilder whereNotNull(string $column) 
 * @method static \App\Builders\EmpleadoRevisadorBuilder whereNull(string $column) 
 * @method static \App\Builders\EmpleadoRevisadorBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\EmpleadoRevisadorBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class EmpleadoRevisador extends MaracModel
{
  public $table = "inv-empleado_revisador";
  protected $primaryKey = "codEmpleadoRevisador";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['codRevision', 'codEmpleado'];


  public function getEmpleado()
  {

    return Empleado::findOrFail($this->codEmpleado);
  }

  public function getRevision()
  {
    return RevisionInventario::findOrFail($this->codRevision);
  }

  public function getSede()
  {

    return Sede::findOrFail($this->codSede);
  }
}
