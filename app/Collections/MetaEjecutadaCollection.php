<?php
namespace App\Collections;

use App\MetaEjecutada;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, MetaEjecutada>
 */
final class MetaEjecutadaCollection extends Collection
{
  /**
   * @param MetaEjecutada[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof MetaEjecutada) {
        throw new InvalidArgumentException(
          "MetaEjecutadaCollection solo acepta instancias de " . MetaEjecutada::class
        );
      }
    }
    parent::__construct($items);
  }
}
