<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codProyectoContador int(11)     
 * @property int $codEmpleadoContador int(11)     
 * @property int $codProyecto int(11)     
 * @method static ProyectoContador findOrFail($primary_key)
 * @method static ProyectoContador | null find($primary_key)
 * @method static ProyectoContadorCollection all()
 * @method static \App\Builders\ProyectoContadorBuilder query()
 * @method static \App\Builders\ProyectoContadorBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\ProyectoContadorBuilder where(string $column,string $value)
 * @method static \App\Builders\ProyectoContadorBuilder whereNotNull(string $column) 
 * @method static \App\Builders\ProyectoContadorBuilder whereNull(string $column) 
 * @method static \App\Builders\ProyectoContadorBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\ProyectoContadorBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class ProyectoContador extends MaracModel
{
  public $timestamps = false;

  public $table = 'proyecto_contador';

  protected $primaryKey = 'codProyectoContador';

  protected $fillable = [
    'codEmpleadoContador',
    'codProyecto'
  ];

  public function getContador()
  {
    return Empleado::findOrFail($this->codEmpleadoContador);
  }
  public function getProyecto()
  {

    return Proyecto::findOrFail($this->codProyecto);
  }

  public static function verificarExistencia($codProyecto, $codEmpleado): bool
  {
    $search = ProyectoContador::where('codEmpleadoContador', '=', $codEmpleado)->where('codProyecto', $codProyecto)->get();
    if (count($search) == 0) {
      return false;
    }

    return true;
  }
}
