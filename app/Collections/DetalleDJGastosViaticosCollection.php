<?php
namespace App\Collections;

use App\DetalleDJGastosViaticos;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, DetalleDJGastosViaticos>
 */
final class DetalleDJGastosViaticosCollection extends Collection
{
  /**
   * @param DetalleDJGastosViaticos[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof DetalleDJGastosViaticos) {
        throw new InvalidArgumentException(
          "DetalleDJGastosViaticosCollection solo acepta instancias de " . DetalleDJGastosViaticos::class
        );
      }
    }
    parent::__construct($items);
  }
}
