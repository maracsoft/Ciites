<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codProyectoObservador int(11)     
 * @property int $codProyecto int(11)     
 * @property int $codEmpleadoObservador int(11)     
 * @method static ProyectoObservador findOrFail($primary_key)
 * @method static ProyectoObservador | null find($primary_key)
 * @method static ProyectoObservadorCollection all()
 * @method static \App\Builders\ProyectoObservadorBuilder query()
 * @method static \App\Builders\ProyectoObservadorBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\ProyectoObservadorBuilder where(string $column,string $value)
 * @method static \App\Builders\ProyectoObservadorBuilder whereNotNull(string $column) 
 * @method static \App\Builders\ProyectoObservadorBuilder whereNull(string $column) 
 * @method static \App\Builders\ProyectoObservadorBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\ProyectoObservadorBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class ProyectoObservador extends MaracModel
{
  public $timestamps = false;
  public $table = 'proyecto_observador';
  protected $primaryKey = 'codProyectoObservador';
  protected $fillable = [];


  public function getObservador(): Empleado
  {
    return Empleado::findOrFail($this->codEmpleadoObservador);
  }
  public function getProyecto(): Proyecto
  {
    return Proyecto::findOrFail($this->codProyecto);
  }

  public static function verificarExistencia($codProyecto, $codEmpleado): bool
  {
    $search = ProyectoObservador::where('codEmpleadoObservador', '=', $codEmpleado)->where('codProyecto', $codProyecto)->get();
    if (count($search) == 0) {
      return false;
    }

    return true;
  }
}
