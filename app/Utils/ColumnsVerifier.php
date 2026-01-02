<?php

namespace App\Utils;

use App\Debug;
use App\MaracModel;
use App\Models\ParametroSistema;
use Illuminate\Database\Eloquent\Model;

class ColumnsVerifier
{


  const Regex = '/\/\/START MODEL_HELPER[\s\S@\n]*\/\/END MODEL_HELPER/';

  public static function GenerarDocumentacionHelpersModelos(): int
  {
    $cant = 0;
    $proyect_folder_path = env('PROYECT_FOLDER');
    $ruta_models = $proyect_folder_path . "/app";

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
        if (!in_array($classname, $abstractas)) {

          $classname = "App\\" . $classname;

          try {
            $model = new $classname();
            if ($model instanceof MaracModel) {

              $modelos_validos[] = $classname;
            }
          } catch (\Throwable $th) {
            Debug::LogMessage("Error al verificar $classname");
          }
        }
      }
    }


    foreach ($modelos_validos as $classname) {
      $model = new $classname();
      $cols = $model->GetDatabaseColumns();

      $recomendacion = static::ConstruirStringRecomendacion($cols, $classname);


      $route_file = $proyect_folder_path . '/' . $classname . ".php";
      //read the entire file
      $original = file_get_contents($route_file);

      //replace something in the file string - this is a VERY simple example
      $modificada = preg_replace(static::Regex, $recomendacion, $original);

      //write the entire string
      file_put_contents($route_file, $modificada);
      $cant++;
    }
    return $cant;
  }

  //classname llega con App\
  public static function ConstruirStringRecomendacion(array $columnas, string $classname)
  {
    $to_eliminate = "App/";
    $classname_original = substr($classname, strlen($to_eliminate)); //remove App/Models

    $string = "//START MODEL_HELPER\n/**\n";

    foreach ($columnas as $col) {
      $name = $col['name'];
      $type = static::ParseMysqlTypeToPhpType($col['type']);
      $comment = $col['comment'];
      $mysql_type = $col['mysql_type'];
      $nullable = $col['nullable'];
      $msj_nulable = "";
      if ($nullable) {
        $msj_nulable = "NULLABLE";
      }

      $comment = str_replace("\r\n", "", $comment);

      $string .= " * @property $type $" . $name . " $mysql_type $msj_nulable   $comment \n";
    }

    $string .= ' * @method static ' . $classname_original . ' findOrFail($primary_key)' . "\n";
    $string .= ' * @method static ' . $classname_original . ' | null find($primary_key)' . "\n";
    $string .= ' * @method static ' . $classname_original . 'Collection all()' . "\n";
    $string .= ' * @method static \\App\\Builders\\' . $classname_original . 'Builder query()' . "\n";
    $string .= ' * @method static \\App\\Builders\\' . $classname_original . 'Builder where(string $column,string $operator, string $value)' . "\n";
    $string .= ' * @method static \\App\\Builders\\' . $classname_original . 'Builder where(string $column,string $value)' . "\n";
    $string .= ' * @method static \\App\\Builders\\' . $classname_original . 'Builder whereNotNull(string $column) ' . "\n";
    $string .= ' * @method static \\App\\Builders\\' . $classname_original . 'Builder whereNull(string $column) ' . "\n";
    $string .= ' * @method static \\App\\Builders\\' . $classname_original . 'Builder whereIn(string $column,array $array)' . "\n";
    $string .= ' * @method static \\App\\Builders\\' . $classname_original . 'Builder orderBy(string $column,array $sentido) ' . "\n";

    $string .= " */\n//END MODEL_HELPER";
    return $string;
  }


  const TypesConversion = [
    "int" => "int",
    "smallint" => "int",
    "bigint" => "int",
    "tinyint" => "int",
    "varchar" => "string",
    "char" => "string",
    "text" => "string",
    "date" => "string",
    "timestamp" => "string",
    "datetime" => "string",
    "mediumtext" => "string",
    "longtext" => "string",
    "float" => "float",
    "decimal" => "float",
  ];

  public static function ParseMysqlTypeToPhpType($mysql_type)
  {
    return static::TypesConversion[$mysql_type];
  }
}
