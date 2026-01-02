<?php
namespace App\Collections;

use App\ReposicionGastos;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, ReposicionGastos>
 */
final class ReposicionGastosCollection extends Collection
{
  /**
   * @param ReposicionGastos[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof ReposicionGastos) {
        throw new InvalidArgumentException(
          "ReposicionGastosCollection solo acepta instancias de " . ReposicionGastos::class
        );
      }
    }
    parent::__construct($items);
  }
}
