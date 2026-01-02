<?php
namespace App\Collections;

use App\ErrorHistorial;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, ErrorHistorial>
 */
final class ErrorHistorialCollection extends Collection
{
  /**
   * @param ErrorHistorial[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof ErrorHistorial) {
        throw new InvalidArgumentException(
          "ErrorHistorialCollection solo acepta instancias de " . ErrorHistorial::class
        );
      }
    }
    parent::__construct($items);
  }
}
