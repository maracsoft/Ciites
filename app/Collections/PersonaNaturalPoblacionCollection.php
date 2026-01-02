<?php
namespace App\Collections;

use App\PersonaNaturalPoblacion;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, PersonaNaturalPoblacion>
 */
final class PersonaNaturalPoblacionCollection extends Collection
{
  /**
   * @param PersonaNaturalPoblacion[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof PersonaNaturalPoblacion) {
        throw new InvalidArgumentException(
          "PersonaNaturalPoblacionCollection solo acepta instancias de " . PersonaNaturalPoblacion::class
        );
      }
    }
    parent::__construct($items);
  }
}
