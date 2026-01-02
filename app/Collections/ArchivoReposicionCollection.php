<?php
namespace App\Collections;

use App\ArchivoReposicion;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, ArchivoReposicion>
 */
final class ArchivoReposicionCollection extends Collection
{
  /**
   * @param ArchivoReposicion[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof ArchivoReposicion) {
        throw new InvalidArgumentException(
          "ArchivoReposicionCollection solo acepta instancias de " . ArchivoReposicion::class
        );
      }
    }
    parent::__construct($items);
  }
}
