<?php
namespace App\Collections;

use App\ProyectoContador;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, ProyectoContador>
 */
final class ProyectoContadorCollection extends Collection
{
  /**
   * @param ProyectoContador[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof ProyectoContador) {
        throw new InvalidArgumentException(
          "ProyectoContadorCollection solo acepta instancias de " . ProyectoContador::class
        );
      }
    }
    parent::__construct($items);
  }
}
