<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codSemestre int(11)     
 * @property int $anio int(11)     
 * @property int $numero int(11)     
 * @property string $fecha_inicio date     
 * @property string $fecha_fin date     
 * @method static Semestre findOrFail($primary_key)
 * @method static Semestre | null find($primary_key)
 * @method static SemestreCollection all()
 * @method static \App\Builders\SemestreBuilder query()
 * @method static \App\Builders\SemestreBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\SemestreBuilder where(string $column,string $value)
 * @method static \App\Builders\SemestreBuilder whereNotNull(string $column) 
 * @method static \App\Builders\SemestreBuilder whereNull(string $column) 
 * @method static \App\Builders\SemestreBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\SemestreBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class Semestre extends MaracModel
{
  public $table = "semestre";
  protected $primaryKey = "codSemestre";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = [];


  public function getTexto()
  {
    return $this->anio . " - " . $this->getNumero();
  }

  public function getNumero()
  {
    if ($this->numero == 1)
      return "I";
    else
      return "II";
  }

  //se le pasa un limite de fechas y retorna todos los semestres definidos en el sistema que esten total o parcialmente dentro de estas fechas
  public static function GetSemestresInvolucrados($fecha_inicio, $fecha_fin): Collection
  {

    $querySemestres = Semestre::where(Semestre::FiltroEspecial($fecha_inicio, $fecha_fin));
    $listaSemestres = $querySemestres->get();

    return $listaSemestres;
  }

  public static function FiltroEspecial($fecha_inicio, $fecha_fin)
  {
    return function ($query) use ($fecha_inicio, $fecha_fin) {
      $query->where(function ($query1) use ($fecha_inicio, $fecha_fin) {
        $query1->where('fecha_inicio', '<=', $fecha_inicio)->where('fecha_fin', '>=', $fecha_inicio)->where('fecha_fin', '<=', $fecha_fin);
      })
        ->orWhere(function ($query2) use ($fecha_inicio, $fecha_fin) {
          $query2->where('fecha_inicio', '>=', $fecha_inicio)->where('fecha_inicio', '<=', $fecha_fin)->where('fecha_fin', '>=', $fecha_fin);
        })
        ->orWhere(function ($query3) use ($fecha_inicio, $fecha_fin) {
          $query3->where('fecha_inicio', '<=', $fecha_inicio)->where('fecha_fin', '>=', $fecha_fin);
        })
        ->orWhere(function ($query4) use ($fecha_inicio, $fecha_fin) {
          $query4->where('fecha_inicio', '>=', $fecha_inicio)->where('fecha_fin', '<=', $fecha_fin);
        });
    };
  }

  public static function GetCodigosSemestresInvolucrados($fecha_inicio, $fecha_fin): string
  {
    $list = static::GetSemestresInvolucrados($fecha_inicio, $fecha_fin);
    $codsSemestres = [];
    foreach ($list as $semestre) {
      $codsSemestres[] = "(" . $semestre->codSemestre . ")";
    }

    $separado_por_comas = implode(",", $codsSemestres);
    return $separado_por_comas;
  }

  public static function TodosParaFront()
  {
    $lista = Semestre::orderBy('fecha_inicio', 'ASC')->get();
    foreach ($lista as $semestre) {
      $semestre['getTexto'] = $semestre->getTexto();
    }
    return $lista;
  }
}
