<?php
namespace App\Collections;

use App\AvanceEntregable;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, AvanceEntregable>
 */
final class AvanceEntregableCollection extends Collection
{
  /**
   * @param AvanceEntregable[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof AvanceEntregable) {
        throw new InvalidArgumentException(
          "AvanceEntregableCollection solo acepta instancias de " . AvanceEntregable::class
        );
      }
    }
    parent::__construct($items);
  }
}
