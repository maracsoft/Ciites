<?php
namespace App\Collections;

use App\DJGastosViaticos;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, DJGastosViaticos>
 */
final class DJGastosViaticosCollection extends Collection
{
  /**
   * @param DJGastosViaticos[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof DJGastosViaticos) {
        throw new InvalidArgumentException(
          "DJGastosViaticosCollection solo acepta instancias de " . DJGastosViaticos::class
        );
      }
    }
    parent::__construct($items);
  }
}
