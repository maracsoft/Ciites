<?php
namespace App\Collections;

use App\TipoOperacion;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, TipoOperacion>
 */
final class TipoOperacionCollection extends Collection
{
  /**
   * @param TipoOperacion[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof TipoOperacion) {
        throw new InvalidArgumentException(
          "TipoOperacionCollection solo acepta instancias de " . TipoOperacion::class
        );
      }
    }
    parent::__construct($items);
  }
}
