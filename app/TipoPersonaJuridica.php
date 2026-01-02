<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codTipoPersonaJuridica int(11)     
 * @property string $nombre varchar(100)     
 * @property string $siglas varchar(20)     
 * @method static TipoPersonaJuridica findOrFail($primary_key)
 * @method static TipoPersonaJuridica | null find($primary_key)
 * @method static TipoPersonaJuridicaCollection all()
 * @method static \App\Builders\TipoPersonaJuridicaBuilder query()
 * @method static \App\Builders\TipoPersonaJuridicaBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\TipoPersonaJuridicaBuilder where(string $column,string $value)
 * @method static \App\Builders\TipoPersonaJuridicaBuilder whereNotNull(string $column) 
 * @method static \App\Builders\TipoPersonaJuridicaBuilder whereNull(string $column) 
 * @method static \App\Builders\TipoPersonaJuridicaBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\TipoPersonaJuridicaBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class TipoPersonaJuridica extends MaracModel
{
  public $table = "tipo_persona_juridica";
  protected $primaryKey = "codTipoPersonaJuridica";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['nombre', 'siglas'];

  public function getDescripcion()
  {
    return $this->nombre . " " . $this->siglas;
  }
}
