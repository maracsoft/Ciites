<?php
namespace App\Collections;

use App\OrdenCompra;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, OrdenCompra>
 */
final class OrdenCompraCollection extends Collection
{
  /**
   * @param OrdenCompra[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof OrdenCompra) {
        throw new InvalidArgumentException(
          "OrdenCompraCollection solo acepta instancias de " . OrdenCompra::class
        );
      }
    }
    parent::__construct($items);
  }
}
