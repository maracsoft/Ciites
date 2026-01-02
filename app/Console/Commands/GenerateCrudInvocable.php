<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateCrudInvocable extends Command
{
  /**
   * Nombre del comando.
   *
   * @var string
   */
  protected $signature = 'crud:generate:inv';

  /**
   * Descripción del comando.
   *
   * @var string
   */
  protected $description = 'Genera un CRUD de tipo Invocable basado en los parametros';

  /**
   * Parámetros para la generación del CRUD.
   * Defina aquí los parámetros para su CRUD.
   *
   * @var array
   */
  protected $params = [
    'tablename' => 'personas',            // nombre original de la tabla en base de datos
    'primarykeyname' => 'dni',     // nombre de la columna que es la clave primaria
    'modelname' => 'Persona',             // nombre del modelo
    'controllername' => 'PersonaController',  // nombre del controlador
    'routename' => 'personas',             // nombre de la ruta
    'objectname' => 'persona',           // nombre de los objetos que se va a instanciar
    'namespacemodel' => 'App\Models',                 // el namespace en el que se creará el modelo
    'listmodelsname' => 'lista_personas',      // nombre de la variable que contiene la lista
    'labelsingular' => 'persona',     // etiqueta singular
    'labelplural' => 'personas',     // etiqueta plural
    'forminvocablename' => 'form_persona', // nombre del formulario invocable
    'viewfoldername' => 'persona',        // nombre de la carpeta en la que se crearán las vistas
    'modelgenero' => 'F',           // Femenino(F) / Masculino(M)
  ];

  /**
   * Rutas de las plantillas y destinos de los archivos
   *
   * @var array
   */
  protected $templates = [
    'model' => [
      'source' => '/resources/views/crud_generator/inv/crud_generator_Model.php',
      'destination' => '{namespacemodel}/{modelname}.php'
    ],
    'controller' => [
      'source' => '/resources/views/crud_generator/inv/crud_generator_Controller.php',
      'destination' => 'app/Http/Controllers/{controllername}.php'
    ],
    'routes' => [
      'source' => '/resources/views/crud_generator/inv/crud_generator_Router.php',
      'destination' => 'app/Routers/Router{modelname}.php'
    ],
    'form_invocable' => [
      'source' => '/resources/views/crud_generator/inv/crud_generator_Inv_FormInvocable.blade.php',
      'destination' => 'resources/views/{viewfoldername}/Inv_FormInvocable.blade.php'
    ],
    'inv_listar' => [
      'source' => '/resources/views/crud_generator/inv/crud_generator_Inv_Listar.blade.php',
      'destination' => 'resources/views/{viewfoldername}/Inv_Listar.blade.php'
    ],
    'listar' => [
      'source' => '/resources/views/crud_generator/inv/crud_generator_Listar.blade.php',
      'destination' => 'resources/views/{viewfoldername}/Listar.blade.php'
    ]
  ];

  /**
   * Ejecución del comando.
   *
   * @return mixed
   */
  public function handle()
  {

    if ($this->params['modelgenero'] == 'M') {
      $this->params['adjectivegenero'] = 'Nuevo';
      $this->params['articlegenero'] = 'el';
      $this->params['thisgenero'] = 'este';
    } elseif ($this->params['modelgenero'] == 'F') {
      $this->params['adjectivegenero'] = 'Nueva';
      $this->params['articlegenero'] = 'la';
      $this->params['thisgenero'] = 'esta';
    }

    // Mostrar los parámetros que se utilizarán
    $this->info('Generando CRUD con los siguientes parámetros:');
    foreach ($this->params as $key => $value) {
      $this->info("- {$key}: {$value}");
    }

    // Crear los directorios necesarios
    $this->createDirectories();

    // Generar los archivos
    $this->generateFiles();

    $this->info('CRUD generado exitosamente para ' . $this->params['modelname']); // Mensaje de éxito
  }

  /**
   * Crea los directorios necesarios si no existen.
   *
   * @return void
   */
  protected function createDirectories()
  {
    // Crear directorio para las vistas
    $viewPath = base_path('resources/views/' . $this->params['viewfoldername']);
    if (!File::exists($viewPath)) {
      File::makeDirectory($viewPath, 0755, true);
      $this->info("Directorio creado: {$viewPath}");
    }

    // Crear directorio para el modelo
    $modelPath = base_path(str_replace('\\', '/', $this->params['namespacemodel']));
    if (!File::exists($modelPath)) {
      File::makeDirectory($modelPath, 0755, true);
      $this->info("Directorio creado: {$modelPath}");
    }
  }

  /**
   * Genera los archivos del CRUD.
   *
   * @return void
   */
  protected function generateFiles()
  {
    foreach ($this->templates as $name => $paths) {
      $this->generateFile($paths['source'], $paths['destination']);
    }
  }

  /**
   * Genera cada archivo.
   *
   * @param string $templatePath
   * @param string $destinationPath
   * @return void
   */
  protected function generateFile($templatePath, $destinationPath)
  {
    // Verificar si existe la plantilla
    $templateFullPath = base_path($templatePath);
    if (!File::exists($templateFullPath)) {
      $this->error("La plantilla no existe: {$templateFullPath}");
      return;
    }

    // Leer la plantilla
    $templateContent = File::get($templateFullPath);

    // Reemplazar los parámetros en la plantilla
    $fileContent = $this->replaceParameters($templateContent);

    // Preparar la ruta de destino
    $destination = $this->preparePath($destinationPath);
    $destinationFullPath = base_path($destination);

    // Crear el directorio de destino si no existe
    $destinationDir = dirname($destinationFullPath);
    if (!File::exists($destinationDir)) {
      File::makeDirectory($destinationDir, 0755, true);
    }

    // Guardar el archivo
    File::put($destinationFullPath, $fileContent);

    $this->info("Archivo creado: {$destination}");
  }

  /**
   * Reemplaza los parámetros en la plantilla.
   *
   * @param string $content
   * @return string
   */
  protected function replaceParameters($content)
  {
    foreach ($this->params as $param => $value) {
      $content = str_replace($param, $value, $content);
    }

    return $content;
  }

  /**
   * Prepara la ruta de destino reemplazando los parámetros.
   *
   * @param string $path
   * @return string
   */
  protected function preparePath($path)
  {
    foreach ($this->params as $param => $value) {
      $path = str_replace('{' . $param . '}', $value, $path);
    }

    return $path;
  }
}
