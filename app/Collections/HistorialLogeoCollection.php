<?php
namespace App\Collections;

use App\HistorialLogeo;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, HistorialLogeo>
 */
final class HistorialLogeoCollection extends Collection
{
  /**
   * @param HistorialLogeo[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof HistorialLogeo) {
        throw new InvalidArgumentException(
          "HistorialLogeoCollection solo acepta instancias de " . HistorialLogeo::class
        );
      }
    }
    parent::__construct($items);
  }
}
