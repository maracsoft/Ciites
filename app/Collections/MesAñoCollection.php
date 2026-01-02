<?php
namespace App\Collections;

use App\MesAño;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, MesAño>
 */
final class MesAñoCollection extends Collection
{
  /**
   * @param MesAño[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof MesAño) {
        throw new InvalidArgumentException(
          "MesAñoCollection solo acepta instancias de " . MesAño::class
        );
      }
    }
    parent::__construct($items);
  }
}
