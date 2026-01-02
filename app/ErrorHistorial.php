<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
//START MODEL_HELPER
/**
 * @property int $codErrorHistorial int(11)     
 * @property int $codEmpleado int(11)     
 * @property string $controllerDondeOcurrio varchar(100)     
 * @property string $funcionDondeOcurrio varchar(200)     
 * @property string $fechaHora datetime     
 * @property string $ipEmpleado varchar(40)     
 * @property string $descripcionError varchar(25000)     
 * @property int $estadoError tinyint(4)     
 * @property string $razon varchar(200) NULLABLE    
 * @property string $solucion varchar(500) NULLABLE    
 * @property string $formulario varchar(3000)     
 * @property string $fechaHoraSolucion datetime NULLABLE    
 * @method static ErrorHistorial findOrFail($primary_key)
 * @method static ErrorHistorial | null find($primary_key)
 * @method static ErrorHistorialCollection all()
 * @method static \App\Builders\ErrorHistorialBuilder query()
 * @method static \App\Builders\ErrorHistorialBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\ErrorHistorialBuilder where(string $column,string $value)
 * @method static \App\Builders\ErrorHistorialBuilder whereNotNull(string $column) 
 * @method static \App\Builders\ErrorHistorialBuilder whereNull(string $column) 
 * @method static \App\Builders\ErrorHistorialBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\ErrorHistorialBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class ErrorHistorial extends MaracModel
{
  public $table = "error_historial";
  protected $primaryKey = "codErrorHistorial";

  public $timestamps = false;
  protected $fillable = [
    'codEmpleado',
    'controllerDondeOcurrio',
    'fechaHora',
    'ipEmpleado',
    'descripcionError',
    'funcionDondeOcurrio',
    'estadoError'
  ];

  const diaImplementacionAPI = "2021-11-07";


  public static function getPromedioMinutosSolucion($preOPost)
  {

    if ($preOPost == "PRE")
      $signo = "<";
    else
      $signo = ">";

    $consultaSQL = "SELECT AVG(TIMESTAMPDIFF(MINUTE,fechaHora,fechaHoraSolucion)) as 'Valor'
            from error_historial
            WHERE fechaHora $signo '" . static::diaImplementacionAPI . "'";

    $resSQL = DB::select($consultaSQL);

    $valor = $resSQL[0]->Valor;

    return $valor;
  }

  public static function getCantDatosSolucion($preOPost)
  {

    if ($preOPost == "PRE")
      $signo = "<";
    else
      $signo = ">";

    $consultaSQL = "SELECT count(*) as 'Cantidad'
            from error_historial
            WHERE fechaHora $signo '" . static::diaImplementacionAPI . "'";

    $resSQL = DB::select($consultaSQL);

    $valor = $resSQL[0]->Cantidad;

    return $valor;
  }

  public function getMinutosSolucion()
  {

    $dt_fechaHora = new DateTime($this->fechaHora);
    $dt_fechaHoraSolucion = new DateTime($this->fechaHoraSolucion);

    $dif = $dt_fechaHora->diff($dt_fechaHoraSolucion);
    //error_log(json_encode($dif));

    return $dif->days * 24 * 60 + $dif->h * 60 + $dif->i;
  }


  public function getChecked()
  {
    if ($this->estadoError == 1)
      return "checked";

    return "";
  }
  public function getFechaHora()
  {
    return Fecha::formatoFechaHoraParaVistas($this->fechaHora);
  }
  public function getFechaHoraSolucion()
  {
    return Fecha::formatoFechaHoraParaVistas($this->fechaHoraSolucion);
  }

  public function getErrorAbreviado()
  {
    // Si la longitud es mayor que el límite...
    $limiteCaracteres = 100;
    $cadena = $this->descripcionError;
    if (strlen($cadena) > $limiteCaracteres) {
      // Entonces corta la cadena y ponle el sufijo
      return substr($cadena, 0, $limiteCaracteres) . '...';
    }

    // Si no, entonces devuelve la cadena normal
    return $cadena;
  }

  public function getEmpleado()
  {
    return Empleado::findOrFail($this->codEmpleado);
  }


  public static function registrarError($th, $action, $request)
  { //$action = app('request')->route()->getAction();

    try {

      date_default_timezone_set('America/Lima');
      $error = new ErrorHistorial();
      $error->codEmpleado = Empleado::getEmpleadoLogeado()->codEmpleado;

      $controller = class_basename($action['controller']); // obtiene el nombre base de la clase : "HomeController@index"
      list($controllerName, $action) = explode('@', $controller);
                //explode : {$controllerName : "HomeController", $action : "index"}
      /***************************/
      $error->controllerDondeOcurrio = $controllerName;
      $error->funcionDondeOcurrio = $action;

      $error->fechaHora = new DateTime();

      if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $error->ipEmpleado = $_SERVER['HTTP_CLIENT_IP'];
      } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $error->ipEmpleado = $_SERVER['HTTP_X_FORWARDED_FOR'];
      } else $error->ipEmpleado = $_SERVER['REMOTE_ADDR'];

      //$error->ipEmpleado=$this->getRealIP();

      $error->estadoError = 0;
      $error->descripcionError = ErrorHistorial::acortarError($th);

      //A ESTA INSTANCIA REQUEST YA LLEGA COMO UN STRING (ya jsoneado)
      $error->formulario = $request;

      $error->save();

      $entorno = ParametroSistema::getParametroSistema("env")->valor;
      if ($entorno != "local") {
        MaracsoftBot::enviarMensaje("CodError #" . $error->codErrorHistorial . "            EnProduccion?: " . Configuracion::estaEnProduccionTexto() .
          "  Empleado " . Empleado::getEmpleadoLogeado()->getNombreCompleto() . " (" . Empleado::getEmpleadoLogeado()->getPuestosPorComas() .
          ") generó el error en " . $controllerName . " -> " . $action .
          " DESCRIPCION DEL ERROR:                                                " . ErrorHistorial::acortarParaTelegram($error->descripcionError));
      }

      return $error->codErrorHistorial;
    } catch (\Throwable $th) {
      Debug::mensajeError("ERROR EN EL GUARDADO DEL ERROR XD", $th);
      MaracsoftBot::enviarMensaje("ERROR NO LISTADO, Ocurrió una excepción en el guardado de un error generado por "
        . Empleado::getEmpleadoLogeado()->getNombreCompleto() . " ocurrido en $controllerName $action.");
      return "E-NLST";
    }
  }



  public function getNombreEmpleado()
  {
    $empleado = Empleado::findOrFail($this->codEmpleado);
    return $empleado->getNombreCompleto();
  }

  const tamañoMaximoError = 5000;

  public static function acortarError($descripcionError)
  {

    // Si la longitud es mayor que el límite...
    $limiteCaracteres = ErrorHistorial::tamañoMaximoError;

    if (mb_strlen($descripcionError) > $limiteCaracteres) {
      // Entonces corta la cadena y ponle el sufijo
      return mb_substr($descripcionError, 0, $limiteCaracteres) . '... error acortado';
    }

    // Si no, entonces devuelve la cadena normal
    return $descripcionError;
  }

  const tamañoParaTelegram = 1000;
  //telegram permite maximo 4096 asi que lo limitaremos a 3500
  public static function acortarParaTelegram($descripcionError)
  {

    // Si la longitud es mayor que el límite...
    $limiteCaracteres = ErrorHistorial::tamañoParaTelegram;

    if (mb_strlen($descripcionError) > $limiteCaracteres) {
      // Entonces corta la cadena y ponle el sufijo
      return mb_substr($descripcionError, 0, $limiteCaracteres) . '... error acortado';
    }

    // Si no, entonces devuelve la cadena normal
    return $descripcionError;
  }
}
