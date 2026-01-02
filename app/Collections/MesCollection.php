<?php
namespace App\Collections;

use App\Mes;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, Mes>
 */
final class MesCollection extends Collection
{
  /**
   * @param Mes[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof Mes) {
        throw new InvalidArgumentException(
          "MesCollection solo acepta instancias de " . Mes::class
        );
      }
    }
    parent::__construct($items);
  }
}
