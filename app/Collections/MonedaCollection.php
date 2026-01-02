<?php
namespace App\Collections;

use App\Moneda;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, Moneda>
 */
final class MonedaCollection extends Collection
{
  /**
   * @param Moneda[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof Moneda) {
        throw new InvalidArgumentException(
          "MonedaCollection solo acepta instancias de " . Moneda::class
        );
      }
    }
    parent::__construct($items);
  }
}
