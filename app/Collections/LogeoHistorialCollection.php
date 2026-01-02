<?php
namespace App\Collections;

use App\LogeoHistorial;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, LogeoHistorial>
 */
final class LogeoHistorialCollection extends Collection
{
  /**
   * @param LogeoHistorial[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof LogeoHistorial) {
        throw new InvalidArgumentException(
          "LogeoHistorialCollection solo acepta instancias de " . LogeoHistorial::class
        );
      }
    }
    parent::__construct($items);
  }
}
