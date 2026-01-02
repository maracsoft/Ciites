<?php
namespace App\Collections;

use App\ContratoPlazo;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, ContratoPlazo>
 */
final class ContratoPlazoCollection extends Collection
{
  /**
   * @param ContratoPlazo[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof ContratoPlazo) {
        throw new InvalidArgumentException(
          "ContratoPlazoCollection solo acepta instancias de " . ContratoPlazo::class
        );
      }
    }
    parent::__construct($items);
  }
}
