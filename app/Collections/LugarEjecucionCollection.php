<?php
namespace App\Collections;

use App\LugarEjecucion;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, LugarEjecucion>
 */
final class LugarEjecucionCollection extends Collection
{
  /**
   * @param LugarEjecucion[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof LugarEjecucion) {
        throw new InvalidArgumentException(
          "LugarEjecucionCollection solo acepta instancias de " . LugarEjecucion::class
        );
      }
    }
    parent::__construct($items);
  }
}
