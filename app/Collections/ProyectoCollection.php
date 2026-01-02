<?php
namespace App\Collections;

use App\Proyecto;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, Proyecto>
 */
final class ProyectoCollection extends Collection
{
  /**
   * @param Proyecto[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof Proyecto) {
        throw new InvalidArgumentException(
          "ProyectoCollection solo acepta instancias de " . Proyecto::class
        );
      }
    }
    parent::__construct($items);
  }
}
