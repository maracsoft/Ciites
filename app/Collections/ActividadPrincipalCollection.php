<?php
namespace App\Collections;

use App\ActividadPrincipal;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, ActividadPrincipal>
 */
final class ActividadPrincipalCollection extends Collection
{
  /**
   * @param ActividadPrincipal[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof ActividadPrincipal) {
        throw new InvalidArgumentException(
          "ActividadPrincipalCollection solo acepta instancias de " . ActividadPrincipal::class
        );
      }
    }
    parent::__construct($items);
  }
}
