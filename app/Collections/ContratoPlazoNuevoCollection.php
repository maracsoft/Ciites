<?php
namespace App\Collections;

use App\ContratoPlazoNuevo;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, ContratoPlazoNuevo>
 */
final class ContratoPlazoNuevoCollection extends Collection
{
  /**
   * @param ContratoPlazoNuevo[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof ContratoPlazoNuevo) {
        throw new InvalidArgumentException(
          "ContratoPlazoNuevoCollection solo acepta instancias de " . ContratoPlazoNuevo::class
        );
      }
    }
    parent::__construct($items);
  }
}
