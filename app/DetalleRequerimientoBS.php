<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codDetalleRequerimiento int(11)     
 * @property int $codRequerimiento int(11)     
 * @property float $cantidad float     
 * @property int $codUnidadMedida int(11)     
 * @property string $descripcion varchar(100)     
 * @property string $codigoPresupuestal varchar(20)     
 * @method static DetalleRequerimientoBS findOrFail($primary_key)
 * @method static DetalleRequerimientoBS | null find($primary_key)
 * @method static DetalleRequerimientoBSCollection all()
 * @method static \App\Builders\DetalleRequerimientoBSBuilder query()
 * @method static \App\Builders\DetalleRequerimientoBSBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\DetalleRequerimientoBSBuilder where(string $column,string $value)
 * @method static \App\Builders\DetalleRequerimientoBSBuilder whereNotNull(string $column) 
 * @method static \App\Builders\DetalleRequerimientoBSBuilder whereNull(string $column) 
 * @method static \App\Builders\DetalleRequerimientoBSBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\DetalleRequerimientoBSBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class DetalleRequerimientoBS extends MaracModel
{
  public $table = "detalle_requerimiento_bs";
  protected $primaryKey = "codDetalleRequerimiento";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = [
    'codDetalleRequerimiento',
    'codRequerimiento',
    'cantidad',
    'codUnidadMedida',
    'descripcion',
    'codigoPresupuestal'
  ];


  public function getNombreTipoUnidad()
  {
    $unidad = UnidadMedida::findOrFail($this->codUnidadMedida);
    return $unidad->nombre;
  }

  /* Convierte el objeto en un vector con elementos leibles directamente por la API */
  public function getVectorParaAPI()
  {
    $itemActual = $this;
    $itemActual['nombreUnidad'] = $this->getNombreTipoUnidad();
    return $itemActual;
  }
}
