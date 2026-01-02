<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codDetalleRevision int(11)     
 * @property int $codActivo int(11)     
 * @property int $codRevision int(11)     
 * @property int $codEstado int(11)     
 * @property string $fechaHoraUltimoCambio datetime NULLABLE    
 * @property int $codEmpleadoQueReviso int(11) NULLABLE    
 * @property int $codRazonBaja int(11) NULLABLE    
 * @method static DetalleRevision findOrFail($primary_key)
 * @method static DetalleRevision | null find($primary_key)
 * @method static DetalleRevisionCollection all()
 * @method static \App\Builders\DetalleRevisionBuilder query()
 * @method static \App\Builders\DetalleRevisionBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\DetalleRevisionBuilder where(string $column,string $value)
 * @method static \App\Builders\DetalleRevisionBuilder whereNotNull(string $column) 
 * @method static \App\Builders\DetalleRevisionBuilder whereNull(string $column) 
 * @method static \App\Builders\DetalleRevisionBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\DetalleRevisionBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class DetalleRevision extends MaracModel
{
  public $table = "inv-detalle_revision";
  protected $primaryKey = "codDetalleRevision";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['codRevision', 'codActivo', 'codEstado', 'activo', 'seReviso'];

  function getActivo()
  {
    return ActivoInventario::findOrFail($this->codActivo);
  }
  function getEstado()
  {
    return EstadoActivoInventario::findOrFail($this->codEstado);
  }

  function getRevision()
  {
    return RevisionInventario::findOrFail($this->codRevision);
  }
  function getEmpleadoQueReviso()
  {
    return Empleado::findOrFail($this->codEmpleadoQueReviso);
  }
  function getRazonBaja()
  {

    return RazonBajaActivo::findOrFail($this->codRazonBaja);
  }
}
