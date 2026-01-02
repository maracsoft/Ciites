<?php
namespace App\Collections;

use App\RendicionGastos;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, RendicionGastos>
 */
final class RendicionGastosCollection extends Collection
{
  /**
   * @param RendicionGastos[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof RendicionGastos) {
        throw new InvalidArgumentException(
          "RendicionGastosCollection solo acepta instancias de " . RendicionGastos::class
        );
      }
    }
    parent::__construct($items);
  }
}
