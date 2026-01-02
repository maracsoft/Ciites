<?php
namespace App\Collections;

use App\ProyectoObservador;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, ProyectoObservador>
 */
final class ProyectoObservadorCollection extends Collection
{
  /**
   * @param ProyectoObservador[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof ProyectoObservador) {
        throw new InvalidArgumentException(
          "ProyectoObservadorCollection solo acepta instancias de " . ProyectoObservador::class
        );
      }
    }
    parent::__construct($items);
  }
}
