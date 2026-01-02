<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @method static HistorialLogeo findOrFail($primary_key)
 * @method static HistorialLogeo | null find($primary_key)
 * @method static HistorialLogeoCollection all()
 * @method static \App\Builders\HistorialLogeoBuilder query()
 * @method static \App\Builders\HistorialLogeoBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\HistorialLogeoBuilder where(string $column,string $value)
 * @method static \App\Builders\HistorialLogeoBuilder whereNotNull(string $column) 
 * @method static \App\Builders\HistorialLogeoBuilder whereNull(string $column) 
 * @method static \App\Builders\HistorialLogeoBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\HistorialLogeoBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class HistorialLogeo extends MaracModel
{
  public $table = "historial_logueo";
  protected $primaryKey = "codErrorHistorial";

  public $timestamps = false;
  protected $fillable = [
    'codEmpleado',
    'controllerDondeOcurrio',
    'fechaHora',
    'ipEmpleado',
    'descripcionError',
    'funcionDondeOcurrio'
  ];

  public function getErrorAbreviado()
  {
    // Si la longitud es mayor que el límite...
    $limiteCaracteres = 150;
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


  public static function registrarError($th, $action)
  { //$action = app('request')->route()->getAction();
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
    $error->descripcionError = $th;
    $error->save();
  }
  /*
    public function getRealIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];

        return $_SERVER['REMOTE_ADDR'];
    }
    */

  public function getNombreEmpleado()
  {
    $empleado = Empleado::findOrFail($this->codEmpleado);
    return $empleado->getNombreCompleto();
  }
}
