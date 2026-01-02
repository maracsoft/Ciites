<?php
namespace App\Collections;

use App\ArchivoRendicion;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, ArchivoRendicion>
 */
final class ArchivoRendicionCollection extends Collection
{
  /**
   * @param ArchivoRendicion[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof ArchivoRendicion) {
        throw new InvalidArgumentException(
          "ArchivoRendicionCollection solo acepta instancias de " . ArchivoRendicion::class
        );
      }
    }
    parent::__construct($items);
  }
}
