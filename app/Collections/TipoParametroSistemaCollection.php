<?php
namespace App\Collections;

use App\TipoParametroSistema;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, TipoParametroSistema>
 */
final class TipoParametroSistemaCollection extends Collection
{
  /**
   * @param TipoParametroSistema[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof TipoParametroSistema) {
        throw new InvalidArgumentException(
          "TipoParametroSistemaCollection solo acepta instancias de " . TipoParametroSistema::class
        );
      }
    }
    parent::__construct($items);
  }
}
