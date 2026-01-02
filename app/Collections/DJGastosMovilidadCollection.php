<?php
namespace App\Collections;

use App\DJGastosMovilidad;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, DJGastosMovilidad>
 */
final class DJGastosMovilidadCollection extends Collection
{
  /**
   * @param DJGastosMovilidad[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof DJGastosMovilidad) {
        throw new InvalidArgumentException(
          "DJGastosMovilidadCollection solo acepta instancias de " . DJGastosMovilidad::class
        );
      }
    }
    parent::__construct($items);
  }
}
