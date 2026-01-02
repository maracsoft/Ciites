<?php
namespace App\Collections;

use App\Provincia;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, Provincia>
 */
final class ProvinciaCollection extends Collection
{
  /**
   * @param Provincia[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof Provincia) {
        throw new InvalidArgumentException(
          "ProvinciaCollection solo acepta instancias de " . Provincia::class
        );
      }
    }
    parent::__construct($items);
  }
}
