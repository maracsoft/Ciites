<?php
namespace App\Collections;

use App\SolicitudFondos;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, SolicitudFondos>
 */
final class SolicitudFondosCollection extends Collection
{
  /**
   * @param SolicitudFondos[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof SolicitudFondos) {
        throw new InvalidArgumentException(
          "SolicitudFondosCollection solo acepta instancias de " . SolicitudFondos::class
        );
      }
    }
    parent::__construct($items);
  }
}
