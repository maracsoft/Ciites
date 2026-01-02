<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codBusqueda int(11)     
 * @property int $codEmpleado int(11)     
 * @property string $fechaHoraInicioBuscar datetime(3)     
 * @property string $fechaHoraVerPDF datetime(3) NULLABLE    
 * @method static BusquedaRepo findOrFail($primary_key)
 * @method static BusquedaRepo | null find($primary_key)
 * @method static BusquedaRepoCollection all()
 * @method static \App\Builders\BusquedaRepoBuilder query()
 * @method static \App\Builders\BusquedaRepoBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\BusquedaRepoBuilder where(string $column,string $value)
 * @method static \App\Builders\BusquedaRepoBuilder whereNotNull(string $column) 
 * @method static \App\Builders\BusquedaRepoBuilder whereNull(string $column) 
 * @method static \App\Builders\BusquedaRepoBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\BusquedaRepoBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class BusquedaRepo extends MaracModel
{
  //ESTE MODELO ES UNICAMENTE PARA TOMAR LOS DATOS DE POST TEST DE TESIS
  //BUSQUEDA DE UNA REPO
  /*
        Inicia cuando se le da click al botón de buscar
        finaliza cuando el empleado abre un PDF
    */

  public $table = "busqueda_repo";
  protected $primaryKey = "codBusqueda";

  public $timestamps = false;
  protected $fillable = ['codBusqueda', 'codEmpleado', 'codLogeo', 'fechaHoraInicioBuscar', 'fechaHoraVerPDF',];



  //retorna el objeto si hay una activa, y si no retorna false
  public static function getBusquedaActiva()
  {
    $emp = Empleado::getEmpleadoLogeado();

    $lista = BusquedaRepo::where('codEmpleado', '=', $emp->codEmpleado)->where('fechaHoraVerPDF', null)->get();
    if (count($lista) == 0) { //si no hay ninguna pendiente
      return false;
    }

    return $lista[0];
  }

  public static function hayBusquedaActiva()
  {
    return (BusquedaRepo::getBusquedaActiva() != false);
  }

  public function getEmpleado()
  {
    return Empleado::findOrFail($this->codEmpleado);
  }



  public function getMilisegundosGeneracion()
  {

    $dt_inicio = new DateTime($this->fechaHoraInicioBuscar);
    $dt_fin = new DateTime($this->fechaHoraVerPDF);

    $dif = $dt_inicio->diff($dt_fin);
    //error_log(json_encode($dif));

    return
      $dif->days * 24 * 60 * 60 * 1000 +
      $dif->h * 60 * 60 * 1000 +
      $dif->i * 60 * 1000 +
      $dif->s * 1000 +
      $dif->f * 1000;
  }


  //INICIO DEL TIMER
  //este metodo se llama cuando se da click al boton
  public static function iniciarBusqueda()
  {
    try {
      $emp = Empleado::getEmpleadoLogeado();
      $fechaHoraActual = DateTime::createFromFormat('U.u', microtime(true));
      $fechaHoraActual->modify("- 5 hours");

      $timer1 = new BusquedaRepo();
      $timer1->codEmpleado = $emp->codEmpleado;
      $timer1->fechaHoraInicioBuscar = $fechaHoraActual->format("Y-m-d H:i:s.v");
      $timer1->save();
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  //FIN DEL TIMER
  public static function finalizarBusqueda()
  {
    try {
      $emp = Empleado::getEmpleadoLogeado();
      $fechaHoraActual = DateTime::createFromFormat('U.u', microtime(true));
      $fechaHoraActual->modify("- 5 hours");


      $timer2 = BusquedaRepo::getBusquedaActiva();
      $timer2->fechaHoraVerPDF = $fechaHoraActual->format("Y-m-d H:i:s.v");
      $timer2->save();
    } catch (\Throwable $th) {
      throw $th;
    }
  }
}
