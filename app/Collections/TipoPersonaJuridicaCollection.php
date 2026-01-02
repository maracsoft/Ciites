<?php
namespace App\Collections;

use App\TipoPersonaJuridica;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, TipoPersonaJuridica>
 */
final class TipoPersonaJuridicaCollection extends Collection
{
  /**
   * @param TipoPersonaJuridica[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof TipoPersonaJuridica) {
        throw new InvalidArgumentException(
          "TipoPersonaJuridicaCollection solo acepta instancias de " . TipoPersonaJuridica::class
        );
      }
    }
    parent::__construct($items);
  }
}
