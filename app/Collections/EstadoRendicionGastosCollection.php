<?php
namespace App\Collections;

use App\EstadoRendicionGastos;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, EstadoRendicionGastos>
 */
final class EstadoRendicionGastosCollection extends Collection
{
  /**
   * @param EstadoRendicionGastos[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof EstadoRendicionGastos) {
        throw new InvalidArgumentException(
          "EstadoRendicionGastosCollection solo acepta instancias de " . EstadoRendicionGastos::class
        );
      }
    }
    parent::__construct($items);
  }
}
