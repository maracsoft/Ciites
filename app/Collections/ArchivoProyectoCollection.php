<?php
namespace App\Collections;

use App\ArchivoProyecto;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, ArchivoProyecto>
 */
final class ArchivoProyectoCollection extends Collection
{
  /**
   * @param ArchivoProyecto[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof ArchivoProyecto) {
        throw new InvalidArgumentException(
          "ArchivoProyectoCollection solo acepta instancias de " . ArchivoProyecto::class
        );
      }
    }
    parent::__construct($items);
  }
}
