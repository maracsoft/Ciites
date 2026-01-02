<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codDetalleOrdenCompra int(11)     
 * @property float $cantidad float     
 * @property string $descripcion varchar(200)     
 * @property float $valorDeVenta float     
 * @property float $precioVenta float     
 * @property float $subtotal float     
 * @property int $codOrdenCompra int(11)     
 * @property int $exoneradoIGV tinyint(4)     
 * @property int $codUnidadMedida int(11)     
 * @method static DetalleOrdenCompra findOrFail($primary_key)
 * @method static DetalleOrdenCompra | null find($primary_key)
 * @method static DetalleOrdenCompraCollection all()
 * @method static \App\Builders\DetalleOrdenCompraBuilder query()
 * @method static \App\Builders\DetalleOrdenCompraBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\DetalleOrdenCompraBuilder where(string $column,string $value)
 * @method static \App\Builders\DetalleOrdenCompraBuilder whereNotNull(string $column) 
 * @method static \App\Builders\DetalleOrdenCompraBuilder whereNull(string $column) 
 * @method static \App\Builders\DetalleOrdenCompraBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\DetalleOrdenCompraBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class DetalleOrdenCompra extends MaracModel
{
  public $table = "detalle_orden_compra";
  protected $primaryKey = "codDetalleOrdenCompra ";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['cantidad', 'descripcion', 'valorDeVenta', 'precioVenta', 'subtotal', 'codOrdenCompra', 'exoneradoIGV', 'codUnidadMedida'];

  public function getDescripcionAbreviada()
  {


    // Si la longitud es mayor que el límite...
    $limiteCaracteres = 25;
    $cadena = $this->descripcion;
    if (strlen($cadena) > $limiteCaracteres) {
      // Entonces corta la cadena y ponle el sufijo
      return substr($cadena, 0, $limiteCaracteres) . '..';
    }

    // Si no, entonces devuelve la cadena normal
    return $cadena;
  }

  public function getUnidadMedida()
  {
    return UnidadMedida::findOrFail($this->codUnidadMedida);
  }

  public function tieneIGV()
  {
    if ($this->exoneradoIGV == 1) {
      return '';
    } else return 'checked';
  }

  public function getOrdenCompra()
  {
    return OrdenCompra::findOrFail($this->codOrdenCompra);
  }
}
