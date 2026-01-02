<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codEstadoSolicitud int(11)     
 * @property string $nombre varchar(200)     
 * @property int $ordenListadoEmpleado int(11)     
 * @property int $ordenListadoGerente int(11)     
 * @property int $ordenListadoAdministrador int(11)     
 * @property int $ordenListadoContador int(11)     
 * @method static EstadoSolicitudFondos findOrFail($primary_key)
 * @method static EstadoSolicitudFondos | null find($primary_key)
 * @method static EstadoSolicitudFondosCollection all()
 * @method static \App\Builders\EstadoSolicitudFondosBuilder query()
 * @method static \App\Builders\EstadoSolicitudFondosBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\EstadoSolicitudFondosBuilder where(string $column,string $value)
 * @method static \App\Builders\EstadoSolicitudFondosBuilder whereNotNull(string $column) 
 * @method static \App\Builders\EstadoSolicitudFondosBuilder whereNull(string $column) 
 * @method static \App\Builders\EstadoSolicitudFondosBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\EstadoSolicitudFondosBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class EstadoSolicitudFondos extends MaracModel
{
  public $table = "estado_solicitud_fondos";
  protected $primaryKey = "codEstadoSolicitud";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['nombre'];
}
