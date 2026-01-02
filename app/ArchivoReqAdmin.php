<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codArchivoReqAdmin int(11)     
 * @property string $nombreDeGuardado varchar(100)     
 * @property int $codRequerimiento int(11)     
 * @property string $nombreAparente varchar(500)     
 * @method static ArchivoReqAdmin findOrFail($primary_key)
 * @method static ArchivoReqAdmin | null find($primary_key)
 * @method static ArchivoReqAdminCollection all()
 * @method static \App\Builders\ArchivoReqAdminBuilder query()
 * @method static \App\Builders\ArchivoReqAdminBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\ArchivoReqAdminBuilder where(string $column,string $value)
 * @method static \App\Builders\ArchivoReqAdminBuilder whereNotNull(string $column) 
 * @method static \App\Builders\ArchivoReqAdminBuilder whereNull(string $column) 
 * @method static \App\Builders\ArchivoReqAdminBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\ArchivoReqAdminBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class ArchivoReqAdmin extends MaracModel
{
  public $table = "archivo_req_admin";
  protected $primaryKey = "codArchivoReqAdmin";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['codArchivoReqAdmin', 'nombreDeGuardado', 'nombreAparente', 'codRequerimiento'];
}
