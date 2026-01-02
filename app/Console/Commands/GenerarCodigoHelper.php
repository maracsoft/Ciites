<?php

namespace App\Console\Commands;

use App\ParametroSistema;
use App\Utils\BuildersGenerator;
use App\Utils\CollectionsGenerator;
use App\Utils\ColumnsVerifier;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerarCodigoHelper extends Command
{
  /**
   * Nombre del comando.
   *
   * @var string
   */
  protected $signature = 'helper';

  /**
   * Descripción del comando.
   *
   * @var string
   */
  protected $description = 'Actualiza los comentarios de los Modelos, genera los Builders y los Collection para cada modelo';



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


    $a = ColumnsVerifier::GenerarDocumentacionHelpersModelos();
    $this->info("Se agregaron atributos a los $a modelos");

    $b = CollectionsGenerator::GenerarCollections();
    $this->info("Se generaron $b Collections");

    $c = BuildersGenerator::GenerarBuilders();
    $this->info("Se generaron $c Builders");

    $this->info('EJECUCION TERMINADA');
  }
}
