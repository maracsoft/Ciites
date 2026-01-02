<?php
namespace App\Collections;

use App\DetalleReposicionGastos;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, DetalleReposicionGastos>
 */
final class DetalleReposicionGastosCollection extends Collection
{
  /**
   * @param DetalleReposicionGastos[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof DetalleReposicionGastos) {
        throw new InvalidArgumentException(
          "DetalleReposicionGastosCollection solo acepta instancias de " . DetalleReposicionGastos::class
        );
      }
    }
    parent::__construct($items);
  }
}
