<?php

namespace App;

use App\Utils\Fecha;
use Exception;
use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codPeriodoDirector int(11)     
 * @property string $fecha_inicio date     
 * @property string $fecha_fin date NULLABLE    
 * @property string $nombres varchar(200)     
 * @property string $apellidos varchar(200)     
 * @property string $dni varchar(20)     
 * @property string $sexo varchar(5)     
 * @property string $fechaHoraCreacion datetime     
 * @method static PeriodoDirectorGeneral findOrFail($primary_key)
 * @method static PeriodoDirectorGeneral | null find($primary_key)
 * @method static PeriodoDirectorGeneralCollection all()
 * @method static \App\Builders\PeriodoDirectorGeneralBuilder query()
 * @method static \App\Builders\PeriodoDirectorGeneralBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\PeriodoDirectorGeneralBuilder where(string $column,string $value)
 * @method static \App\Builders\PeriodoDirectorGeneralBuilder whereNotNull(string $column) 
 * @method static \App\Builders\PeriodoDirectorGeneralBuilder whereNull(string $column) 
 * @method static \App\Builders\PeriodoDirectorGeneralBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\PeriodoDirectorGeneralBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class PeriodoDirectorGeneral extends MaracModel
{

  public $table = "periodo_director_general";
  protected $primaryKey = "codPeriodoDirector";

  public $timestamps = false;  //para que no trabaje con los campos fecha

  /*
  contrato locacion
  contrato plazo
  contrato plazo nuevo
  reposicion
  requerimiento
  solicitud fondos


  */

  public function getFechaInicioEscrita()
  {
    if ($this->fecha_inicio == null) {
      return "";
    }

    return Fecha::formatoFechaParaVistasEscrita($this->fecha_inicio);
  }

  public function getFechaFinEscrita()
  {
    if ($this->fecha_fin == null) {
      return "";
    }

    return Fecha::formatoFechaParaVistasEscrita($this->fecha_fin);
  }



  public function getFechaInicio()
  {
    if ($this->fecha_inicio == null) {
      return "";
    }

    return Fecha::formatoParaVistas($this->fecha_inicio);
  }

  public function getFechaFin()
  {

    if ($this->fecha_fin == null) {
      return "";
    }

    return Fecha::formatoParaVistas($this->fecha_fin);
  }

  public function getNombreCompleto(bool $en_mayusculas)
  {
    $fullname = $this->nombres . " " . $this->apellidos;
    if ($en_mayusculas) {
      $fullname = mb_strtoupper($fullname);
    }

    return $fullname;
  }

  public function getNombreCompletoApellidos()
  {
    return $this->apellidos . " " . $this->nombre;
  }

  public function esHombre()
  {
    return $this->sexo == 'M';
  }
  public function esMujer()
  {
    return $this->sexo == 'F';
  }




  public function getSexoEscrito()
  {
    if ($this->esHombre()) {
      return "MASCULINO";
    } else {
      return "FEMENINO";
    }
  }

  public function getActivoString()
  {
    if ($this->estaActivo()) {
      return "ACTIVO";
    }

    return "INACTIVO";
  }

  public function estaActivo(): bool
  {
    $hoy = date("Y-m-d");
    $buscar = PeriodoDirectorGeneral::where('codPeriodoDirector', $this->getId())->where('fecha_inicio', '<=', $hoy)->where('fecha_fin', '>=', $hoy)->count();
    if ($buscar > 0) {
      return true;
    }

    return false;
  }

  public static function getPeriodoActivo(): PeriodoDirectorGeneral
  {
    $hoy = date("Y-m-d");

    $buscar = PeriodoDirectorGeneral::where('fecha_inicio', '<=', $hoy)->where('fecha_fin', '>=', $hoy)->get();

    if (count($buscar) == 0) {
      throw new Exception("No hay director general configurado en el sistema para la fecha de hoy.");
    }

    return $buscar[0];
  }

  public static function getCodPeriodoActivo(): int
  {
    return (static::getPeriodoActivo())->getId();
  }
}
