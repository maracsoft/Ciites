<?php
namespace App\Collections;

use App\ViajeVehiculo;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, ViajeVehiculo>
 */
final class ViajeVehiculoCollection extends Collection
{
  /**
   * @param ViajeVehiculo[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof ViajeVehiculo) {
        throw new InvalidArgumentException(
          "ViajeVehiculoCollection solo acepta instancias de " . ViajeVehiculo::class
        );
      }
    }
    parent::__construct($items);
  }
}
