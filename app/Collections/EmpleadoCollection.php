<?php
namespace App\Collections;

use App\Empleado;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, Empleado>
 */
final class EmpleadoCollection extends Collection
{
  /**
   * @param Empleado[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof Empleado) {
        throw new InvalidArgumentException(
          "EmpleadoCollection solo acepta instancias de " . Empleado::class
        );
      }
    }
    parent::__construct($items);
  }
}
