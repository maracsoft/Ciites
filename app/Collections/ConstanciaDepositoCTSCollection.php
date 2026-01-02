<?php
namespace App\Collections;

use App\ConstanciaDepositoCTS;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, ConstanciaDepositoCTS>
 */
final class ConstanciaDepositoCTSCollection extends Collection
{
  /**
   * @param ConstanciaDepositoCTS[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof ConstanciaDepositoCTS) {
        throw new InvalidArgumentException(
          "ConstanciaDepositoCTSCollection solo acepta instancias de " . ConstanciaDepositoCTS::class
        );
      }
    }
    parent::__construct($items);
  }
}
