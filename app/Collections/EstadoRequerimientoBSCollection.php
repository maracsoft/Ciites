<?php
namespace App\Collections;

use App\EstadoRequerimientoBS;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, EstadoRequerimientoBS>
 */
final class EstadoRequerimientoBSCollection extends Collection
{
  /**
   * @param EstadoRequerimientoBS[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof EstadoRequerimientoBS) {
        throw new InvalidArgumentException(
          "EstadoRequerimientoBSCollection solo acepta instancias de " . EstadoRequerimientoBS::class
        );
      }
    }
    parent::__construct($items);
  }
}
