<?php
namespace App\Collections;

use App\DetalleSolicitudFondos;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, DetalleSolicitudFondos>
 */
final class DetalleSolicitudFondosCollection extends Collection
{
  /**
   * @param DetalleSolicitudFondos[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof DetalleSolicitudFondos) {
        throw new InvalidArgumentException(
          "DetalleSolicitudFondosCollection solo acepta instancias de " . DetalleSolicitudFondos::class
        );
      }
    }
    parent::__construct($items);
  }
}
