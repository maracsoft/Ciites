<?php
namespace App\Collections;

use App\TipoArchivoProyecto;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, TipoArchivoProyecto>
 */
final class TipoArchivoProyectoCollection extends Collection
{
  /**
   * @param TipoArchivoProyecto[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof TipoArchivoProyecto) {
        throw new InvalidArgumentException(
          "TipoArchivoProyectoCollection solo acepta instancias de " . TipoArchivoProyecto::class
        );
      }
    }
    parent::__construct($items);
  }
}
