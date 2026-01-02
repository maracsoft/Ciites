<?php
namespace App\Collections;

use App\Contrato;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, Contrato>
 */
final class ContratoCollection extends Collection
{
  /**
   * @param Contrato[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof Contrato) {
        throw new InvalidArgumentException(
          "ContratoCollection solo acepta instancias de " . Contrato::class
        );
      }
    }
    parent::__construct($items);
  }
}
