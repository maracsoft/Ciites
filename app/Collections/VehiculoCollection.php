<?php
namespace App\Collections;

use App\Vehiculo;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, Vehiculo>
 */
final class VehiculoCollection extends Collection
{
  /**
   * @param Vehiculo[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof Vehiculo) {
        throw new InvalidArgumentException(
          "VehiculoCollection solo acepta instancias de " . Vehiculo::class
        );
      }
    }
    parent::__construct($items);
  }
}
