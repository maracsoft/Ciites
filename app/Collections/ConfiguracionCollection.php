<?php

namespace App\Collections;

use App\Utils\Configuracion;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, Configuracion>
 */
final class ConfiguracionCollection extends Collection
{
  /**
   * @param Configuracion[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof Configuracion) {
        throw new InvalidArgumentException(
          "ConfiguracionCollection solo acepta instancias de " . Configuracion::class
        );
      }
    }
    parent::__construct($items);
  }
}
