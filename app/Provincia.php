<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codProvincia int(11)     
 * @property string $nombre varchar(50)     
 * @property int $codDepartamento int(11)     
 * @method static Provincia findOrFail($primary_key)
 * @method static Provincia | null find($primary_key)
 * @method static ProvinciaCollection all()
 * @method static \App\Builders\ProvinciaBuilder query()
 * @method static \App\Builders\ProvinciaBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\ProvinciaBuilder where(string $column,string $value)
 * @method static \App\Builders\ProvinciaBuilder whereNotNull(string $column) 
 * @method static \App\Builders\ProvinciaBuilder whereNull(string $column) 
 * @method static \App\Builders\ProvinciaBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\ProvinciaBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class Provincia extends MaracModel
{
  public $table = "provincia";
  protected $primaryKey = "codProvincia";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['nombre', 'codDepartamento'];

  public function getDepartamento()
  {
    return Departamento::findOrFail($this->codDepartamento);
  }

  public function getDistritos()
  {
    return Distrito::where('codProvincia', $this->codProvincia)->get();
  }
}
