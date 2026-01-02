<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codEmpleadoPuesto int(11)     
 * @property int $codEmpleado int(11)     
 * @property int $codPuesto int(11)     
 * @method static EmpleadoPuesto findOrFail($primary_key)
 * @method static EmpleadoPuesto | null find($primary_key)
 * @method static EmpleadoPuestoCollection all()
 * @method static \App\Builders\EmpleadoPuestoBuilder query()
 * @method static \App\Builders\EmpleadoPuestoBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\EmpleadoPuestoBuilder where(string $column,string $value)
 * @method static \App\Builders\EmpleadoPuestoBuilder whereNotNull(string $column) 
 * @method static \App\Builders\EmpleadoPuestoBuilder whereNull(string $column) 
 * @method static \App\Builders\EmpleadoPuestoBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\EmpleadoPuestoBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class EmpleadoPuesto extends MaracModel
{
  protected $table = "empleado_puesto";
  protected $primaryKey = "codEmpleadoPuesto";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = [];


  function getEmpleado()
  {
    return Empleado::findOrFail($this->codEmpleado);
  }

  function getPuesto()
  {
    return Puesto::findOrFail($this->codPuesto);
  }


  /*
      Retorna el nuevo estado
    */
  public static function togleEmpleadoPuesto(Empleado $empleado, Puesto $puesto): bool
  {
    //verificamos existencia
    $lista = EmpleadoPuesto::where('codPuesto', $puesto->getId())->where('codEmpleado', $empleado->getId())->get();
    if (count($lista) == 0) { //no existe, la creamos
      $nuevo = new EmpleadoPuesto();
      $nuevo->codPuesto = $puesto->codPuesto;
      $nuevo->codEmpleado = $empleado->codEmpleado;
      $nuevo->save();

      return true;
    } else { //si existe, la destruimos
      $lista[0]->delete();
      return false;
    }
  }
}
