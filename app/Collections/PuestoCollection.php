<?php
namespace App\Collections;

use App\Puesto;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, Puesto>
 */
final class PuestoCollection extends Collection
{
  /**
   * @param Puesto[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof Puesto) {
        throw new InvalidArgumentException(
          "PuestoCollection solo acepta instancias de " . Puesto::class
        );
      }
    }
    parent::__construct($items);
  }
}
