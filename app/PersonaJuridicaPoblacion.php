<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codPersonaJuridica int(11)     
 * @property string $ruc varchar(15)     
 * @property string $razonSocial varchar(100)     
 * @property string $direccion varchar(300)     
 * @property int $numeroSociosHombres int(11)     
 * @property int $numeroSociosMujeres int(11)     
 * @property int $codTipoPersonaJuridica int(11)     
 * @property string $representante varchar(300)     
 * @method static PersonaJuridicaPoblacion findOrFail($primary_key)
 * @method static PersonaJuridicaPoblacion | null find($primary_key)
 * @method static PersonaJuridicaPoblacionCollection all()
 * @method static \App\Builders\PersonaJuridicaPoblacionBuilder query()
 * @method static \App\Builders\PersonaJuridicaPoblacionBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\PersonaJuridicaPoblacionBuilder where(string $column,string $value)
 * @method static \App\Builders\PersonaJuridicaPoblacionBuilder whereNotNull(string $column) 
 * @method static \App\Builders\PersonaJuridicaPoblacionBuilder whereNull(string $column) 
 * @method static \App\Builders\PersonaJuridicaPoblacionBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\PersonaJuridicaPoblacionBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class PersonaJuridicaPoblacion extends MaracModel
{
  public $table = "persona_juridica_poblacion";
  protected $primaryKey = "codPersonaJuridica";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['ruc', 'razonSocial', 'direccion', 'numeroSociosHombres', 'actividadPrincipal', 'codPoblacionBeneficiaria', 'numeroSociosMujeres'];


  public function getListaPoblaciones()
  {
    $lista = RelacionPersonaJuridicaPoblacion::where('codPersonaJuridica', '=', $this->codPersonaJuridica)->get();
    $vector = [];
    foreach ($lista as $item) {
      array_push($vector, $item->getPoblacion()->descripcion . " [" . $item->getPoblacion()->codProyecto . "] ");
    }
    return implode(',', $vector);
  }


  /* retorna a una persona que tenga ese dni, si no retorna "" */
  public static function buscarPorRUC($ruc)
  {
    $lista = PersonaJuridicaPoblacion::where('ruc', '=', $ruc)->get();
    if (count($lista) > 0)
      return $lista[0];


    return "";
  }
  public function getRazonYRuc()
  {

    return $this->razonSocial . " [" . $this->ruc . "]";
  }

  public function getTipologia()
  {
    return TipoPersonaJuridica::findOrFail($this->codTipoPersonaJuridica);
  }

  public function getResumenActividades()
  {
    $lista = $this->getListaActividades();
    $cadena = "";
    foreach ($lista as $item)
      $cadena = $cadena . "," . $item->descripcion;

    $cadena = trim($cadena, ",");
    return  $cadena;
  }

  public function getListaActividades()
  {
    //obtenemos el vector con los codigos de las actividades de esta persona natural
    $listaRelaciones = RelacionPersonaJuridicaActividad::where('codPersonaJuridica', '=', $this->codPersonaJuridica)->get();
    $vector = [];
    foreach ($listaRelaciones as $relacion)
      array_push($vector, $relacion->codActividadPrincipal);

    return ActividadPrincipal::whereIn('codActividadPrincipal', $vector)->get();
  }

  public function getVectorActividades()
  {
    $lista = $this->getListaActividades();
    $vector = [];
    foreach ($lista as $item)
      array_push($vector, $item->codActividadPrincipal);
    return json_encode($vector);
  }
}
