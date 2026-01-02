<?php
namespace App\Collections;

use App\EmpleadoRevisador;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, EmpleadoRevisador>
 */
final class EmpleadoRevisadorCollection extends Collection
{
  /**
   * @param EmpleadoRevisador[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof EmpleadoRevisador) {
        throw new InvalidArgumentException(
          "EmpleadoRevisadorCollection solo acepta instancias de " . EmpleadoRevisador::class
        );
      }
    }
    parent::__construct($items);
  }
}
