<?php
namespace App\Collections;

use App\OperacionDocumento;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, OperacionDocumento>
 */
final class OperacionDocumentoCollection extends Collection
{
  /**
   * @param OperacionDocumento[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof OperacionDocumento) {
        throw new InvalidArgumentException(
          "OperacionDocumentoCollection solo acepta instancias de " . OperacionDocumento::class
        );
      }
    }
    parent::__construct($items);
  }
}
