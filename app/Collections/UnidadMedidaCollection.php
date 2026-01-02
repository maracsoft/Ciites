<?php
namespace App\Collections;

use App\UnidadMedida;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, UnidadMedida>
 */
final class UnidadMedidaCollection extends Collection
{
  /**
   * @param UnidadMedida[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof UnidadMedida) {
        throw new InvalidArgumentException(
          "UnidadMedidaCollection solo acepta instancias de " . UnidadMedida::class
        );
      }
    }
    parent::__construct($items);
  }
}
