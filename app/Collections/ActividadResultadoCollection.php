<?php
namespace App\Collections;

use App\ActividadResultado;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, ActividadResultado>
 */
final class ActividadResultadoCollection extends Collection
{
  /**
   * @param ActividadResultado[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof ActividadResultado) {
        throw new InvalidArgumentException(
          "ActividadResultadoCollection solo acepta instancias de " . ActividadResultado::class
        );
      }
    }
    parent::__construct($items);
  }
}
