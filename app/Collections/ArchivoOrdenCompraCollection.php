<?php
namespace App\Collections;

use App\ArchivoOrdenCompra;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, ArchivoOrdenCompra>
 */
final class ArchivoOrdenCompraCollection extends Collection
{
  /**
   * @param ArchivoOrdenCompra[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof ArchivoOrdenCompra) {
        throw new InvalidArgumentException(
          "ArchivoOrdenCompraCollection solo acepta instancias de " . ArchivoOrdenCompra::class
        );
      }
    }
    parent::__construct($items);
  }
}
