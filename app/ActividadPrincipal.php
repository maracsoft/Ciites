<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//START MODEL_HELPER
/**
 * @property int $codActividadPrincipal int(11)     
 * @property string $descripcion varchar(200)     
 * @method static ActividadPrincipal findOrFail($primary_key)
 * @method static ActividadPrincipal | null find($primary_key)
 * @method static ActividadPrincipalCollection all()
 * @method static \App\Builders\ActividadPrincipalBuilder query()
 * @method static \App\Builders\ActividadPrincipalBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\ActividadPrincipalBuilder where(string $column,string $value)
 * @method static \App\Builders\ActividadPrincipalBuilder whereNotNull(string $column) 
 * @method static \App\Builders\ActividadPrincipalBuilder whereNull(string $column) 
 * @method static \App\Builders\ActividadPrincipalBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\ActividadPrincipalBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER

class ActividadPrincipal extends MaracModel
{
  public $table = "actividad_principal";
  protected $primaryKey = "codActividadPrincipal";

  public $timestamps = false;

  protected $fillable = ['descripcionActividad'];
}
