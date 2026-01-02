<?php
namespace App\Collections;

use App\EstadoReposicionGastos;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, EstadoReposicionGastos>
 */
final class EstadoReposicionGastosCollection extends Collection
{
  /**
   * @param EstadoReposicionGastos[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof EstadoReposicionGastos) {
        throw new InvalidArgumentException(
          "EstadoReposicionGastosCollection solo acepta instancias de " . EstadoReposicionGastos::class
        );
      }
    }
    parent::__construct($items);
  }
}
