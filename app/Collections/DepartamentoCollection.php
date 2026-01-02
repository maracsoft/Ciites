<?php
namespace App\Collections;

use App\Departamento;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, Departamento>
 */
final class DepartamentoCollection extends Collection
{
  /**
   * @param Departamento[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof Departamento) {
        throw new InvalidArgumentException(
          "DepartamentoCollection solo acepta instancias de " . Departamento::class
        );
      }
    }
    parent::__construct($items);
  }
}
