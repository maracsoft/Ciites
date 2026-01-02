<?php
namespace App\Collections;

use App\DetalleRendicionGastos;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, DetalleRendicionGastos>
 */
final class DetalleRendicionGastosCollection extends Collection
{
  /**
   * @param DetalleRendicionGastos[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof DetalleRendicionGastos) {
        throw new InvalidArgumentException(
          "DetalleRendicionGastosCollection solo acepta instancias de " . DetalleRendicionGastos::class
        );
      }
    }
    parent::__construct($items);
  }
}
