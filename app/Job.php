<?php

namespace App;

use App\Utils\Fecha;
use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER

/**
 * @property int $codJob int(11)
 * @property string $nombre varchar(100)
 * @property string $descripcion varchar(1000)
 * @property string $functionName varchar(100)
 * @property string $fechaHoraCreacion datetime
 * @property string $fechaHoraEjecucion datetime NULLABLE
 * @property int $ejecutado int(11)
 * @method static Job findOrFail($primary_key)
 * @method static Job | null find($primary_key)
 * @method static JobCollection all()
 * @method static \App\Builders\JobBuilder query()
 * @method static \App\Builders\JobBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\JobBuilder where(string $column,string $value)
 * @method static \App\Builders\JobBuilder whereNotNull(string $column)
 * @method static \App\Builders\JobBuilder whereNull(string $column)
 * @method static \App\Builders\JobBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\JobBuilder orderBy(string $column,array $sentido)
 */
//END MODEL_HELPER
class Job extends MaracModel
{
  public $table = "job";
  protected $primaryKey = "codJob";

  public $timestamps = false;  //para que no trabaje con los campos fecha

  public function estaEjecutado()
  {
    return $this->ejecutado == '1';
  }

  public function getFechaHoraCreacion()
  {
    return Fecha::formatoFechaHoraParaVistas($this->fechaHoraCreacion);
  }
  public function getFechaHoraEjecucion()
  {
    return Fecha::formatoFechaHoraParaVistas($this->fechaHoraEjecucion);
  }
}
