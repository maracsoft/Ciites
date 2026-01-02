<?php
namespace App\Collections;

use App\CDP;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, CDP>
 */
final class CDPCollection extends Collection
{
  /**
   * @param CDP[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof CDP) {
        throw new InvalidArgumentException(
          "CDPCollection solo acepta instancias de " . CDP::class
        );
      }
    }
    parent::__construct($items);
  }
}
