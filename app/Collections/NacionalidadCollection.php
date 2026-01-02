<?php
namespace App\Collections;

use App\Nacionalidad;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, Nacionalidad>
 */
final class NacionalidadCollection extends Collection
{
  /**
   * @param Nacionalidad[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof Nacionalidad) {
        throw new InvalidArgumentException(
          "NacionalidadCollection solo acepta instancias de " . Nacionalidad::class
        );
      }
    }
    parent::__construct($items);
  }
}
