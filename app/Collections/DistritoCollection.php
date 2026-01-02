<?php
namespace App\Collections;

use App\Distrito;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, Distrito>
 */
final class DistritoCollection extends Collection
{
  /**
   * @param Distrito[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof Distrito) {
        throw new InvalidArgumentException(
          "DistritoCollection solo acepta instancias de " . Distrito::class
        );
      }
    }
    parent::__construct($items);
  }
}
