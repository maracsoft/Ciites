<?php
namespace App\Collections;

use App\ArchivoReqEmp;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, ArchivoReqEmp>
 */
final class ArchivoReqEmpCollection extends Collection
{
  /**
   * @param ArchivoReqEmp[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof ArchivoReqEmp) {
        throw new InvalidArgumentException(
          "ArchivoReqEmpCollection solo acepta instancias de " . ArchivoReqEmp::class
        );
      }
    }
    parent::__construct($items);
  }
}
