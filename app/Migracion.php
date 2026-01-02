<?php

namespace App;

use App\Utils\Fecha;
use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $version bigint(20)     
 * @property string $migration_name varchar(100) NULLABLE    
 * @property string $start_time timestamp NULLABLE    
 * @property string $end_time timestamp NULLABLE    
 * @property int $breakpoint tinyint(1)     
 * @method static Migracion findOrFail($primary_key)
 * @method static Migracion | null find($primary_key)
 * @method static MigracionCollection all()
 * @method static \App\Builders\MigracionBuilder query()
 * @method static \App\Builders\MigracionBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\MigracionBuilder where(string $column,string $value)
 * @method static \App\Builders\MigracionBuilder whereNotNull(string $column) 
 * @method static \App\Builders\MigracionBuilder whereNull(string $column) 
 * @method static \App\Builders\MigracionBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\MigracionBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class Migracion extends MaracModel
{
  public $table = "phinxlog";
  protected $primaryKey = "version";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = [''];


  public function getStartTime()
  {
    return Fecha::formatoFechaHoraParaVistas($this->start_time);
  }
  public function getEndTime()
  {
    return Fecha::formatoFechaHoraParaVistas($this->end_time);
  }
}
