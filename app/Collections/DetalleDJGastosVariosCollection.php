<?php
namespace App\Collections;

use App\DetalleDJGastosVarios;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, DetalleDJGastosVarios>
 */
final class DetalleDJGastosVariosCollection extends Collection
{
  /**
   * @param DetalleDJGastosVarios[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof DetalleDJGastosVarios) {
        throw new InvalidArgumentException(
          "DetalleDJGastosVariosCollection solo acepta instancias de " . DetalleDJGastosVarios::class
        );
      }
    }
    parent::__construct($items);
  }
}
