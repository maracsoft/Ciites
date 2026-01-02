<?php

namespace App\Http\Controllers;

use App\ActivoInventario;
use App\CategoriaActivoInventario;
use App\Utils\Configuracion;
use App\DetalleRevision;
use App\Empleado;
use App\ErrorHistorial;
use App\EstadoActivoInventario;
use App\Http\Controllers\Controller;
use App\Migracion;
use App\ParametroSistema;
use App\Proyecto;
use App\Utils\RespuestaAPI;
use App\RevisionInventario;
use App\Sede;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Svg\Tag\Rect;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Phinx\Console\PhinxApplication;


class MigracionController extends Controller
{

  private function getMigrationFiles()
  {

    $ruta_configurada = ParametroSistema::getParametroSistema('ruta_migraciones')->valor;
    $real_path = realpath($ruta_configurada);

    $listaMigraciones_files = scandir($real_path);

    $array_final = [];
    foreach ($listaMigraciones_files as $filename) {
      if ($filename != "schema.php" && $filename != ".." && $filename != ".") {

        $version = substr($filename, 0, 14);

        $array_final[] = [
          'filename' => $filename,
          'version' => $version
        ];
      }
    }

    return $array_final;
  }


  public function ListarMigraciones()
  {

    //$listaMigraciones_db = Migracion::All();
    $listaMigraciones_files = $this->getMigrationFiles();
    $migrationList = [];
    foreach ($listaMigraciones_files as $migracion_file) {

      $migracion_db = Migracion::find($migracion_file['version']);
      if ($migracion_db) {
        $migracion_file['migration_db'] = $migracion_db;
        $migracion_file['finded'] = true;
      } else {
        $migracion_file['migration_db'] = $migracion_db;
        $migracion_file['finded'] = false;
      }
      $migrationList[] = $migracion_file;
    }



    return view('AdminPanel.ListarMigraciones', compact('migrationList'));
  }

  public function Inv_ListarMigraciones()
  {

    //$listaMigraciones_db = Migracion::All();
    $listaMigraciones_files = $this->getMigrationFiles();
    $migrationList = [];
    foreach ($listaMigraciones_files as $migracion_file) {

      $migracion_db = Migracion::find($migracion_file['version']);
      if ($migracion_db) {
        $migracion_file['migration_db'] = $migracion_db;
        $migracion_file['finded'] = true;
      } else {
        $migracion_file['migration_db'] = $migracion_db;
        $migracion_file['finded'] = false;
      }
      $migrationList[] = $migracion_file;
    }



    return view('AdminPanel.Inv_ListarMigraciones', compact('migrationList'));
  }





  public function CorrerMigraciones()
  {
    try {
      $output = new BufferedOutput();


      $phinx = new PhinxApplication();
      $command = $phinx->find('migrate');

      $arguments = [
        'command'         => 'migrate',
        //'--environment'   => 'production',
        '--configuration' => '../phinx.php'
      ];

      $input = new ArrayInput($arguments);
      $command->run($input, $output);
      $log = $output->fetch();

      return RespuestaAPI::respuestaDatosOk("Migraciones ejecutadas correctamente.", $log);
    } catch (\Throwable $th) {
      return RespuestaApi::respuestaDatosError("Error $th");
    }
  }
}
