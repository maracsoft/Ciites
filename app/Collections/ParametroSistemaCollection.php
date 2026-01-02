<?php
namespace App\Collections;

use App\ParametroSistema;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, ParametroSistema>
 */
final class ParametroSistemaCollection extends Collection
{
  /**
   * @param ParametroSistema[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof ParametroSistema) {
        throw new InvalidArgumentException(
          "ParametroSistemaCollection solo acepta instancias de " . ParametroSistema::class
        );
      }
    }
    parent::__construct($items);
  }
}
