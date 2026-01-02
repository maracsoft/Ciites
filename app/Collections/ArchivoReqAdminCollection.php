<?php
namespace App\Collections;

use App\ArchivoReqAdmin;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, ArchivoReqAdmin>
 */
final class ArchivoReqAdminCollection extends Collection
{
  /**
   * @param ArchivoReqAdmin[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof ArchivoReqAdmin) {
        throw new InvalidArgumentException(
          "ArchivoReqAdminCollection solo acepta instancias de " . ArchivoReqAdmin::class
        );
      }
    }
    parent::__construct($items);
  }
}
