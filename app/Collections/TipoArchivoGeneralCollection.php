<?php
namespace App\Collections;

use App\TipoArchivoGeneral;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, TipoArchivoGeneral>
 */
final class TipoArchivoGeneralCollection extends Collection
{
  /**
   * @param TipoArchivoGeneral[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof TipoArchivoGeneral) {
        throw new InvalidArgumentException(
          "TipoArchivoGeneralCollection solo acepta instancias de " . TipoArchivoGeneral::class
        );
      }
    }
    parent::__construct($items);
  }
}
