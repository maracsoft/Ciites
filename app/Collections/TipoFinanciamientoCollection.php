<?php
namespace App\Collections;

use App\TipoFinanciamiento;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, TipoFinanciamiento>
 */
final class TipoFinanciamientoCollection extends Collection
{
  /**
   * @param TipoFinanciamiento[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof TipoFinanciamiento) {
        throw new InvalidArgumentException(
          "TipoFinanciamientoCollection solo acepta instancias de " . TipoFinanciamiento::class
        );
      }
    }
    parent::__construct($items);
  }
}
