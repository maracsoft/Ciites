<?php
namespace App\Collections;

use App\TipoDocumento;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, TipoDocumento>
 */
final class TipoDocumentoCollection extends Collection
{
  /**
   * @param TipoDocumento[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof TipoDocumento) {
        throw new InvalidArgumentException(
          "TipoDocumentoCollection solo acepta instancias de " . TipoDocumento::class
        );
      }
    }
    parent::__construct($items);
  }
}
