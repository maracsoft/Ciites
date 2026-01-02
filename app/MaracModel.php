<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use ArrayAccess;
use Illuminate\Contracts\Queue\QueueableCollection;
use Illuminate\Contracts\Queue\QueueableEntity;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\ConnectionResolverInterface as Resolver;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\ForwardsCalls;
use JsonSerializable;

class MaracModel extends Model implements Arrayable, ArrayAccess, Jsonable, JsonSerializable, QueueableEntity, UrlRoutable
{


  public $timestamps = false;  //para que no trabaje con los campos fecha

  /* ESTO LO ESTOY AÑADIENDO YOOOO XD */
  public function getID()
  {
    return $this[$this->getKeyName()];
  }

  public function isThisSelected($id)
  {
    if ($id == $this->getId())
      return "selected";
    return "";
  }

  public function existe(): bool
  {
    return $this->getId() != null;
  }
  public function GetDatabaseColumns(): array
  {

    $database = env('DB_DATABASE');
    $tablename = $this->table;

    $sql = "SELECT COLUMN_NAME,DATA_TYPE,COLUMN_COMMENT,IS_NULLABLE,CHARACTER_MAXIMUM_LENGTH, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$tablename';";
    $res = DB::select($sql);

    $columns = [];
    foreach ($res as $value) {

      $columns[] =
        [
          "name" => $value->COLUMN_NAME,
          "type" => $value->DATA_TYPE,
          "comment" => $value->COLUMN_COMMENT,
          "nullable" => $value->IS_NULLABLE == "YES",
          "max_length" => $value->CHARACTER_MAXIMUM_LENGTH,
          "mysql_type" => $value->COLUMN_TYPE
        ];
    }

    return $columns;
  }

  /* para listado */
  protected function renderPlantillaDesactivarEliminar(bool $sePuedeEliminar, string $mensaje, bool $añadir_tooltip = false)
  {
    $disabled = '';
    if (!$sePuedeEliminar) {

      $toltip = "";
      if ($añadir_tooltip) {
        $toltip = 'data-bs-toggle="tooltip" data-placement="top"';
      }

      $disabled = 'title="' . $mensaje . '" disabled ' . $toltip;
    }

    return $disabled;
  }

  public static function getTableName()
  {
    return (new static)->getTable();
  }

  /*
    Personalización que hice para que en los findOrFail no se retorne 404 como si la ruta no existiera, sino una excepción especifica

  */

  public static function findOrFail($primary_key)
  {
    if ($primary_key == null) {
      $query = static::query();
      $modelClass = get_class($query->getModel());
      throw new Exception("Error: intentando hacer findOrFail con un primary_key nulo. " . $modelClass);
    }

    try {
      $finded = static::query()->findOrFail($primary_key);
      return $finded;
    } catch (\Throwable $th) {
      // En caso de que sea la excepción ModelNotFoundException, la transformamos en una normal generica porque la ModelNotFoundException laravel
      // la transforma en un 404 por defecto.
      if ($th instanceof ModelNotFoundException) {
        throw new Exception($th->getMessage(), 0, $th);
      }

      //si sucediera otro error lo arrojamos tal cual
      throw $th;
    }
  }




  /*
    Cada vez que en el modelo se llama a una funcion que debía retornar la Collection original de eloquent
    Retornará una colección pero personalizada para ese modelo
    por ejemplo
    UsuarioCollection

    Esto con la finalidad de mejorar el tipado
  */
  public function newCollection(array $models = [])
  {
    $complete_class = static::class; // "App\\ArchivoCotizacion"
    $classname_hijo = str_replace("App\\", '', $complete_class);
    $classname_collection = "App\\Collections\\" . $classname_hijo . "Collection"; // "App\\Collections\\ArchivoCotizacionCollection"
    return new $classname_collection($models);
  }


  /*
    Cada vez que en el modelo se llama a una funcion que debía retornar la Builder original de eloquent
    Retornará una Builder pero personalizada para ese modelo
    por ejemplo
    UsuarioBuilder

    Esto con la finalidad de mejorar el tipado
  */
  public function newEloquentBuilder($query)
  {
    $complete_class = static::class; // "App\\ArchivoCotizacion"
    $classname_hijo = str_replace("App\\", '', $complete_class);
    $classname_builder = "App\\Builders\\" . $classname_hijo . "Builder"; // "App\\Collections\\ArchivoCotizacionCollection"
    return new $classname_builder($query);
  }
}
