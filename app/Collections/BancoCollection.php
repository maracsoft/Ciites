<?php
namespace App\Collections;

use App\Banco;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, Banco>
 */
final class BancoCollection extends Collection
{
  /**
   * @param Banco[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof Banco) {
        throw new InvalidArgumentException(
          "BancoCollection solo acepta instancias de " . Banco::class
        );
      }
    }
    parent::__construct($items);
  }
}
