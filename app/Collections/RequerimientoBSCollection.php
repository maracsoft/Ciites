<?php
namespace App\Collections;

use App\RequerimientoBS;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, RequerimientoBS>
 */
final class RequerimientoBSCollection extends Collection
{
  /**
   * @param RequerimientoBS[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof RequerimientoBS) {
        throw new InvalidArgumentException(
          "RequerimientoBSCollection solo acepta instancias de " . RequerimientoBS::class
        );
      }
    }
    parent::__construct($items);
  }
}
