<?php

namespace App\Console\Commands;

use App\ParametroSistema;
use App\Utils\BuildersGenerator;
use App\Utils\CollectionsGenerator;
use App\Utils\ColumnsVerifier;
use App\Utils\Debug;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RescribirRutas extends Command
{
  /**
   * Nombre del comando.
   *
   * @var string
   */
  protected $signature = 'rescribir_rutas';

  /**
   * Descripción del comando.
   *
   * @var string
   */
  protected $description = 'Aao';



  /**
   * Ejecución del comando.
   *
   * @return mixed
   */
  public function handle()
  {
    $env = ParametroSistema::getEntorno();
    if ($env != "local") {
      throw new Exception("Este script solo debe ser corrido en local");
    }

    $ruta = "D:\Repositorios\Ciites\app\Routers";
    $this->RescribirRutas($ruta);
  }



  private  function RescribirRutas($rutaCarpeta)
  {
    // Verificar que la ruta existe y es un directorio
    if (!is_dir($rutaCarpeta)) {
      $this->error("Error: La ruta '$rutaCarpeta' no existe o no es un directorio.");
      return;
    }

    // Obtener todos los archivos PHP de la carpeta
    $archivos = glob($rutaCarpeta . '/*.php');

    if (empty($archivos)) {
      $this->error("No se encontraron archivos PHP en la carpeta.");
      return;
    }

    $archivosModificados = 0;

    foreach ($archivos as $archivo) {
      // Leer el contenido del archivo
      $contenido = file_get_contents($archivo);

      if ($contenido === false) {
        $this->error("Error al leer el archivo: $archivo");
        continue;
      }

      // Patrón para encontrar 'Controller@metodo'
      // Captura el nombre del controlador y el método
      $patron = "/'([A-Za-z0-9_]+Controller)@([A-Za-z0-9_]+)'/";

      // Reemplazo con el nuevo formato
      $reemplazo = '[$1::class, \'$2\']';

      // Realizar el reemplazo
      $contenidoNuevo = preg_replace($patron, $reemplazo, $contenido);

      // Verificar si hubo cambios
      if ($contenido !== $contenidoNuevo) {
        // Guardar el archivo modificado
        if (file_put_contents($archivo, $contenidoNuevo) !== false) {
          $this->info("✓ Archivo modificado: " . basename($archivo));
          $archivosModificados++;
        } else {
          $this->error("✗ Error al escribir el archivo: $archivo");
        }
      }
    }

    $this->info("\nProceso completado. Archivos modificados: $archivosModificados\n");
  }
}
