<?php
namespace App\Collections;

use App\PersonaJuridicaPoblacion;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, PersonaJuridicaPoblacion>
 */
final class PersonaJuridicaPoblacionCollection extends Collection
{
  /**
   * @param PersonaJuridicaPoblacion[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof PersonaJuridicaPoblacion) {
        throw new InvalidArgumentException(
          "PersonaJuridicaPoblacionCollection solo acepta instancias de " . PersonaJuridicaPoblacion::class
        );
      }
    }
    parent::__construct($items);
  }
}
