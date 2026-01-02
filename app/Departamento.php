<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
//START MODEL_HELPER
/**
 * @property int $codDepartamento int(11)     
 * @property string $nombre varchar(50)     
 * @method static Departamento findOrFail($primary_key)
 * @method static Departamento | null find($primary_key)
 * @method static DepartamentoCollection all()
 * @method static \App\Builders\DepartamentoBuilder query()
 * @method static \App\Builders\DepartamentoBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\DepartamentoBuilder where(string $column,string $value)
 * @method static \App\Builders\DepartamentoBuilder whereNotNull(string $column) 
 * @method static \App\Builders\DepartamentoBuilder whereNull(string $column) 
 * @method static \App\Builders\DepartamentoBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\DepartamentoBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class Departamento extends MaracModel
{
  public $table = "departamento";
  protected $primaryKey = "codDepartamento";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['nombre'];


  public function getProvincias()
  {
    return Provincia::where('codDepartamento', $this->codDepartamento)->get();
  }


  /* Obtiene en un array todos los cod distritos del departamento */
  public function getArrayCodDistritos()
  {

    $codDepartamento = $this->getId();
    //  -- Consulta para obtener todos los codDistrito de un departamento
    $listaDistritos = DB::select(
      "
        select DI.codDistrito as 'codDistrito' from distrito DI
            inner join provincia P on P.codProvincia = DI.codProvincia
            inner join departamento DEP on DEP.codDepartamento = P.codDepartamento
            where DEP.codDepartamento = $codDepartamento"
    );

    return array_column($listaDistritos, 'codDistrito');
  }

  public static function getDepartamentosParaPat()
  {

    $lista = new Collection();
    $lista->push(Departamento::where('nombre', 'PIURA')->first());
    $lista->push(Departamento::where('nombre', 'CAJAMARCA')->first());
    $lista->push(Departamento::where('nombre', 'LA LIBERTAD')->first());
    $lista->push(Departamento::where('nombre', 'ANCASH')->first());
    $lista->push(Departamento::where('nombre', 'LIMA')->first());

    return $lista;
  }
}
