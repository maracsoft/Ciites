<?php
namespace App\Collections;

use App\PeriodoDirectorGeneral;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, PeriodoDirectorGeneral>
 */
final class PeriodoDirectorGeneralCollection extends Collection
{
  /**
   * @param PeriodoDirectorGeneral[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof PeriodoDirectorGeneral) {
        throw new InvalidArgumentException(
          "PeriodoDirectorGeneralCollection solo acepta instancias de " . PeriodoDirectorGeneral::class
        );
      }
    }
    parent::__construct($items);
  }
}
