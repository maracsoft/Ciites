<?php
namespace App\Collections;

use App\Job;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, Job>
 */
final class JobCollection extends Collection
{
  /**
   * @param Job[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof Job) {
        throw new InvalidArgumentException(
          "JobCollection solo acepta instancias de " . Job::class
        );
      }
    }
    parent::__construct($items);
  }
}
