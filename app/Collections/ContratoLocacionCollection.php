<?php
namespace App\Collections;

use App\ContratoLocacion;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, ContratoLocacion>
 */
final class ContratoLocacionCollection extends Collection
{
  /**
   * @param ContratoLocacion[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof ContratoLocacion) {
        throw new InvalidArgumentException(
          "ContratoLocacionCollection solo acepta instancias de " . ContratoLocacion::class
        );
      }
    }
    parent::__construct($items);
  }
}
