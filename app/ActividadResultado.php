<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codActividad int(11)     
 * @property string $descripcion varchar(600)     
 * @property int $codResultadoEsperado int(11)     
 * @method static ActividadResultado findOrFail($primary_key)
 * @method static ActividadResultado | null find($primary_key)
 * @method static ActividadResultadoCollection all()
 * @method static \App\Builders\ActividadResultadoBuilder query()
 * @method static \App\Builders\ActividadResultadoBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\ActividadResultadoBuilder where(string $column,string $value)
 * @method static \App\Builders\ActividadResultadoBuilder whereNotNull(string $column) 
 * @method static \App\Builders\ActividadResultadoBuilder whereNull(string $column) 
 * @method static \App\Builders\ActividadResultadoBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\ActividadResultadoBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class ActividadResultado extends MaracModel
{
  public $table = "actividad_res";
  protected $primaryKey = "codActividad";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['nombre', 'descripcion', 'meta', 'unidadMedida', 'codResultadoEsperado'];




  public function getResultadoEsperado()
  {
    return ResultadoEsperado::findOrFail($this->codResultadoEsperado);
  }





  public function getListaIndicadores()
  {

    return IndicadorActividad::where('codActividad', '=', $this->codActividad)->get();
  }

  public function getCantidadIndicadores()
  {
    return count($this->getListaIndicadores());
  }


  public function getDescripcionAbreviada()
  {




    // Si la longitud es mayor que el límite...
    $limiteCaracteres = 70;
    $cadena = $this->descripcion;
    if (strlen($cadena) > $limiteCaracteres) {
      // Entonces corta la cadena y ponle el sufijo
      return substr($cadena, 0, $limiteCaracteres) . '...';
    }

    // Si no, entonces devuelve la cadena normal
    return $cadena;
  }
}
