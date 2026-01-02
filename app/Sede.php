<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codSede int(11)     
 * @property string $nombre varchar(200)     
 * @property int $esSedePrincipal tinyint(4)     
 * @property int $codEmpleadoAdministrador int(11)     
 * @method static Sede findOrFail($primary_key)
 * @method static Sede | null find($primary_key)
 * @method static SedeCollection all()
 * @method static \App\Builders\SedeBuilder query()
 * @method static \App\Builders\SedeBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\SedeBuilder where(string $column,string $value)
 * @method static \App\Builders\SedeBuilder whereNotNull(string $column) 
 * @method static \App\Builders\SedeBuilder whereNull(string $column) 
 * @method static \App\Builders\SedeBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\SedeBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class Sede extends MaracModel
{
  public $table = "sede";
  protected $primaryKey = "codSede";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['nombre', 'codEmpleadoAdministrador', 'esSedePrincipal'];

  public function getAdministrador()
  {
    return Empleado::findOrFail($this->codEmpleadoAdministrador);
  }


  public function getMensajeAdministrador()
  {
    if ($this->esSedePrincipal == 1)
      return "Administrador de CEDEPAS Norte";
    return "Administrador de Filial";
  }
}
