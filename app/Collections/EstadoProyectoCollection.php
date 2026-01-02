<?php
namespace App\Collections;

use App\EstadoProyecto;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, EstadoProyecto>
 */
final class EstadoProyectoCollection extends Collection
{
  /**
   * @param EstadoProyecto[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof EstadoProyecto) {
        throw new InvalidArgumentException(
          "EstadoProyectoCollection solo acepta instancias de " . EstadoProyecto::class
        );
      }
    }
    parent::__construct($items);
  }
}
