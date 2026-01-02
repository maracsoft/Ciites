<?php
namespace App\Collections;

use App\DetalleOrdenCompra;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, DetalleOrdenCompra>
 */
final class DetalleOrdenCompraCollection extends Collection
{
  /**
   * @param DetalleOrdenCompra[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof DetalleOrdenCompra) {
        throw new InvalidArgumentException(
          "DetalleOrdenCompraCollection solo acepta instancias de " . DetalleOrdenCompra::class
        );
      }
    }
    parent::__construct($items);
  }
}
