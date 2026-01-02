<?php
namespace App\Collections;

use App\Debug;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, Debug>
 */
final class DebugCollection extends Collection
{
  /**
   * @param Debug[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof Debug) {
        throw new InvalidArgumentException(
          "DebugCollection solo acepta instancias de " . Debug::class
        );
      }
    }
    parent::__construct($items);
  }
}
