<?php
namespace App\Collections;

use App\EntidadFinanciera;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, EntidadFinanciera>
 */
final class EntidadFinancieraCollection extends Collection
{
  /**
   * @param EntidadFinanciera[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof EntidadFinanciera) {
        throw new InvalidArgumentException(
          "EntidadFinancieraCollection solo acepta instancias de " . EntidadFinanciera::class
        );
      }
    }
    parent::__construct($items);
  }
}
