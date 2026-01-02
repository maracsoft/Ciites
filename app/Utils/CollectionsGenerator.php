<?php

namespace App\Utils;


use App\MaracModel;
use Illuminate\Database\Eloquent\Model;

class CollectionsGenerator
{




  public static function GenerarCollections(): int
  {
    $cant = 0;

    $proyect_folder_path = env('PROYECT_FOLDER');
    $ruta_models = $proyect_folder_path . "/app";
    $ruta_collections = $proyect_folder_path . "/app/Collections";
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

      $route_file = $ruta_collections . '/' . $classname . "Collection.php";
      $modificada = static::ConstruirStringArchivo($classname);
      //write the entire string
      file_put_contents($route_file, $modificada);
      $cant++;
    }
    return $cant;
  }


  const Plantilla =
  '<?php
namespace App\Collections;

use App\Classname;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * No ESCRIBIR EN ESTA CLASE, ES AUTOGENERADA PARA QUE VS-CODE PUEDA DAR RECOMENDACIONES Y TENER TODO TIPADO
 * @extends Collection<int, Classname>
 */
final class ClassnameCollection extends Collection
{
  /**
   * @param Classname[] $items
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      if (! $item instanceof Classname) {
        throw new InvalidArgumentException(
          "ClassnameCollection solo acepta instancias de " . Classname::class
        );
      }
    }
    parent::__construct($items);
  }
}
';

  //classname llega con App\
  public static function ConstruirStringArchivo($classname): string
  {
    $to_eliminate = "App/";

    $plantilla = static::Plantilla;
    //reemplazamos Classname por el nombre de la clase

    $contenido = str_replace("Classname", $classname, $plantilla);


    return $contenido;
  }
}
