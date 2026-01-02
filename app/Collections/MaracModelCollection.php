<?php
namespace App\Collections;

use App\MaracModel;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, MaracModel>
 */
final class MaracModelCollection extends Collection
{
  /**
   * @param MaracModel[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof MaracModel) {
        throw new InvalidArgumentException(
          "MaracModelCollection solo acepta instancias de " . MaracModel::class
        );
      }
    }
    parent::__construct($items);
  }
}
