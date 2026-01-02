<?php
namespace App\Collections;

use App\BusquedaRepo;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, BusquedaRepo>
 */
final class BusquedaRepoCollection extends Collection
{
  /**
   * @param BusquedaRepo[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof BusquedaRepo) {
        throw new InvalidArgumentException(
          "BusquedaRepoCollection solo acepta instancias de " . BusquedaRepo::class
        );
      }
    }
    parent::__construct($items);
  }
}
