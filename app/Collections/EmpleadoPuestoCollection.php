<?php
namespace App\Collections;

use App\EmpleadoPuesto;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, EmpleadoPuesto>
 */
final class EmpleadoPuestoCollection extends Collection
{
  /**
   * @param EmpleadoPuesto[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof EmpleadoPuesto) {
        throw new InvalidArgumentException(
          "EmpleadoPuestoCollection solo acepta instancias de " . EmpleadoPuesto::class
        );
      }
    }
    parent::__construct($items);
  }
}
