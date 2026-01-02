<?php

namespace App\Utils;

use App\Debug;
use App\MaracModel;
use Illuminate\Database\Eloquent\Model;

class BuildersGenerator
{




  public static function GenerarBuilders()
  {
    $cant = 0;

    $proyect_folder_path = env('PROYECT_FOLDER');
    $ruta_models = $proyect_folder_path . "/app";
    $ruta_builders = $proyect_folder_path . "/app/Builders";
    $archivos = MaracUtils::LeerCarpeta($ruta_models);

    $modelos_validos = [];
    $abstractas = [
      "ArchivoLinker",
    ];


    foreach ($archivos as $filename) {

      //verificamos que termine en .php
      if (str_ends_with($filename, ".php")) {
        //obtenemos el nombre de la clase

        $classname = substr($filename, 0, -4);
        $classname_original = $classname;
        if (!in_array($classname, $abstractas)) {

          $classname = "App\\" . $classname;

          try {
            $model = new $classname();
            if ($model instanceof MaracModel) {
              //aqui classname tiene el nombre completo de la clase "App\ArchivoCotizacion"
              $modelos_validos[] = $classname_original;
            }
          } catch (\Throwable $th) {
            Debug::LogMessage("Error al verificar $classname");
          }
        }
      }
    }


    foreach ($modelos_validos as $classname) {

      $route_file = $ruta_builders . '/' . $classname . "Builder.php";
      $modificada = static::ConstruirStringArchivo($classname);
      //write the entire string
      file_put_contents($route_file, $modificada);
      $cant++;
    }
    return $cant;
  }


  const Plantilla =
  '<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ClassnameCollection;
use App\Classname;

/**
 * @method static ClassnameBuilder query()
 * @method static ClassnameBuilder where(string $column,string $operator, string $value)
 * @method static ClassnameBuilder where(string $column,string $value)
 * @method static ClassnameBuilder whereNotNull(string $column)
 * @method static ClassnameBuilder whereNull(string $column)
 * @method static ClassnameBuilder whereIn(string $column,array $array)
 * @method static ClassnameBuilder orderBy(string $column,array $sentido)
 * @method static ClassnameBuilder select(array|string $columns)
 * @method static ClassnameBuilder distinct()
 * @method static ClassnameBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ClassnameBuilder whereBetween(string $column, array $values)
 * @method static ClassnameBuilder whereNotBetween(string $column, array $values)
 * @method static ClassnameBuilder whereNotIn(string $column, array $values)
 * @method static ClassnameBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ClassnameBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ClassnameBuilder whereYear(string $column, string $operator, int $value)
 * @method static ClassnameBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ClassnameBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ClassnameBuilder groupBy(string ...$groups)
 * @method static ClassnameBuilder limit(int $value)
 * @method static int count()
 * @method static ClassnameCollection get(array|string $columns = ["*"])
 * @method static Classname|null first()
 */
class ClassnameBuilder extends Builder {}
';

  //classname llega con App\
  public static function ConstruirStringArchivo($classname): string
  {
    $plantilla = static::Plantilla;
    //reemplazamos Classname por el nombre de la clase

    $contenido = str_replace("Classname", $classname, $plantilla);

    return $contenido;
  }
}
