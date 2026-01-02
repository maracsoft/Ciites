<?php
namespace App\Collections;

use App\EstadoSolicitudFondos;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, EstadoSolicitudFondos>
 */
final class EstadoSolicitudFondosCollection extends Collection
{
  /**
   * @param EstadoSolicitudFondos[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof EstadoSolicitudFondos) {
        throw new InvalidArgumentException(
          "EstadoSolicitudFondosCollection solo acepta instancias de " . EstadoSolicitudFondos::class
        );
      }
    }
    parent::__construct($items);
  }
}
