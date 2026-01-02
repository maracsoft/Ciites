<?php
namespace App\Collections;

use App\Numeracion;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, Numeracion>
 */
final class NumeracionCollection extends Collection
{
  /**
   * @param Numeracion[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof Numeracion) {
        throw new InvalidArgumentException(
          "NumeracionCollection solo acepta instancias de " . Numeracion::class
        );
      }
    }
    parent::__construct($items);
  }
}
