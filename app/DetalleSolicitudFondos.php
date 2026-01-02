<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codDetalleSolicitud int(11)     
 * @property int $codSolicitud int(11)     
 * @property int $nroItem int(11)     
 * @property string $concepto varchar(200)     
 * @property float $importe float     
 * @property string $codigoPresupuestal varchar(200)     
 * @method static DetalleSolicitudFondos findOrFail($primary_key)
 * @method static DetalleSolicitudFondos | null find($primary_key)
 * @method static DetalleSolicitudFondosCollection all()
 * @method static \App\Builders\DetalleSolicitudFondosBuilder query()
 * @method static \App\Builders\DetalleSolicitudFondosBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\DetalleSolicitudFondosBuilder where(string $column,string $value)
 * @method static \App\Builders\DetalleSolicitudFondosBuilder whereNotNull(string $column) 
 * @method static \App\Builders\DetalleSolicitudFondosBuilder whereNull(string $column) 
 * @method static \App\Builders\DetalleSolicitudFondosBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\DetalleSolicitudFondosBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class DetalleSolicitudFondos extends MaracModel
{
  public $table = "detalle_solicitud_fondos";
  protected $primaryKey = "codDetalleSolicitud";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = [
    'codSolicitud',
    'nroItem',
    'concepto',
    'importe',
    'codigoPresupuestal'
  ];
}
