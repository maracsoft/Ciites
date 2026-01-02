<?php
namespace App\Collections;

use App\ArchivoGeneral;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, ArchivoGeneral>
 */
final class ArchivoGeneralCollection extends Collection
{
  /**
   * @param ArchivoGeneral[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof ArchivoGeneral) {
        throw new InvalidArgumentException(
          "ArchivoGeneralCollection solo acepta instancias de " . ArchivoGeneral::class
        );
      }
    }
    parent::__construct($items);
  }
}
