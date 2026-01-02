<?php
namespace App\Collections;

use App\Sede;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, Sede>
 */
final class SedeCollection extends Collection
{
  /**
   * @param Sede[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof Sede) {
        throw new InvalidArgumentException(
          "SedeCollection solo acepta instancias de " . Sede::class
        );
      }
    }
    parent::__construct($items);
  }
}
