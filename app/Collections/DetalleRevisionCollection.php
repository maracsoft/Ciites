<?php
namespace App\Collections;

use App\DetalleRevision;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, DetalleRevision>
 */
final class DetalleRevisionCollection extends Collection
{
  /**
   * @param DetalleRevision[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof DetalleRevision) {
        throw new InvalidArgumentException(
          "DetalleRevisionCollection solo acepta instancias de " . DetalleRevision::class
        );
      }
    }
    parent::__construct($items);
  }
}
