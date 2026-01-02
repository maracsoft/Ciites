<?php
namespace App\Collections;

use App\IndicadorActividad;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, IndicadorActividad>
 */
final class IndicadorActividadCollection extends Collection
{
  /**
   * @param IndicadorActividad[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof IndicadorActividad) {
        throw new InvalidArgumentException(
          "IndicadorActividadCollection solo acepta instancias de " . IndicadorActividad::class
        );
      }
    }
    parent::__construct($items);
  }
}
