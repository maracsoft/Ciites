<?php
namespace App\Collections;

use App\ArchivoSolicitud;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, ArchivoSolicitud>
 */
final class ArchivoSolicitudCollection extends Collection
{
  /**
   * @param ArchivoSolicitud[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof ArchivoSolicitud) {
        throw new InvalidArgumentException(
          "ArchivoSolicitudCollection solo acepta instancias de " . ArchivoSolicitud::class
        );
      }
    }
    parent::__construct($items);
  }
}
