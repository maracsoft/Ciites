<?php
namespace App\Collections;

use App\Semestre;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, Semestre>
 */
final class SemestreCollection extends Collection
{
  /**
   * @param Semestre[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof Semestre) {
        throw new InvalidArgumentException(
          "SemestreCollection solo acepta instancias de " . Semestre::class
        );
      }
    }
    parent::__construct($items);
  }
}
