<?php
namespace App\Collections;

use App\DetalleDJGastosMovilidad;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, DetalleDJGastosMovilidad>
 */
final class DetalleDJGastosMovilidadCollection extends Collection
{
  /**
   * @param DetalleDJGastosMovilidad[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof DetalleDJGastosMovilidad) {
        throw new InvalidArgumentException(
          "DetalleDJGastosMovilidadCollection solo acepta instancias de " . DetalleDJGastosMovilidad::class
        );
      }
    }
    parent::__construct($items);
  }
}
