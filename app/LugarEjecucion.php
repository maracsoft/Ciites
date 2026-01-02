<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codLugarEjecucion int(11)     
 * @property int $codProyecto int(11)     
 * @property int $codDistrito int(11)     
 * @property string $zona varchar(200)     
 * @method static LugarEjecucion findOrFail($primary_key)
 * @method static LugarEjecucion | null find($primary_key)
 * @method static LugarEjecucionCollection all()
 * @method static \App\Builders\LugarEjecucionBuilder query()
 * @method static \App\Builders\LugarEjecucionBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\LugarEjecucionBuilder where(string $column,string $value)
 * @method static \App\Builders\LugarEjecucionBuilder whereNotNull(string $column) 
 * @method static \App\Builders\LugarEjecucionBuilder whereNull(string $column) 
 * @method static \App\Builders\LugarEjecucionBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\LugarEjecucionBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class LugarEjecucion extends MaracModel
{
  public $table = "lugar_ejecucion";
  protected $primaryKey = "codLugarEjecucion";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['codProyecto', 'codDistrito', 'descripcion'];


  //Retorna la zona y el distrito
  public function getZonaDistrito()
  {
    return $this->zona . "," . $this->getDistrito()->nombre;
  }

  public function getDistrito()
  {

    return Distrito::findOrFail($this->codDistrito);
  }

  public function getProvincia()
  {
    return $this->getDistrito()->getProvincia();
  }

  public function getDepartamento()
  {
    return $this->getProvincia()->getDepartamento();
  }
}
