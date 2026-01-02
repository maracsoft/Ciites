<?php
namespace App\Collections;

use App\DJGastosVarios;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, DJGastosVarios>
 */
final class DJGastosVariosCollection extends Collection
{
  /**
   * @param DJGastosVarios[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof DJGastosVarios) {
        throw new InvalidArgumentException(
          "DJGastosVariosCollection solo acepta instancias de " . DJGastosVarios::class
        );
      }
    }
    parent::__construct($items);
  }
}
