<?php
namespace App\Collections;

use App\Migracion;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, Migracion>
 */
final class MigracionCollection extends Collection
{
  /**
   * @param Migracion[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof Migracion) {
        throw new InvalidArgumentException(
          "MigracionCollection solo acepta instancias de " . Migracion::class
        );
      }
    }
    parent::__construct($items);
  }
}
