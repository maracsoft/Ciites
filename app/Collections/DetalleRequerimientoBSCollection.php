<?php
namespace App\Collections;

use App\DetalleRequerimientoBS;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, DetalleRequerimientoBS>
 */
final class DetalleRequerimientoBSCollection extends Collection
{
  /**
   * @param DetalleRequerimientoBS[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof DetalleRequerimientoBS) {
        throw new InvalidArgumentException(
          "DetalleRequerimientoBSCollection solo acepta instancias de " . DetalleRequerimientoBS::class
        );
      }
    }
    parent::__construct($items);
  }
}
