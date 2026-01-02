<?php
namespace App\Collections;

use App\DocumentoAdministrativo;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, DocumentoAdministrativo>
 */
final class DocumentoAdministrativoCollection extends Collection
{
  /**
   * @param DocumentoAdministrativo[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof DocumentoAdministrativo) {
        throw new InvalidArgumentException(
          "DocumentoAdministrativoCollection solo acepta instancias de " . DocumentoAdministrativo::class
        );
      }
    }
    parent::__construct($items);
  }
}
