<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codPuesto int(11)     
 * @property string $nombre varchar(200)     
 * @property int $estado int(11)     
 * @property string $nombreAparente varchar(100)     
 * @property string $descripcion varchar(250)     
 * @property int $ordenListado int(11)     
 * @method static Puesto findOrFail($primary_key)
 * @method static Puesto | null find($primary_key)
 * @method static PuestoCollection all()
 * @method static \App\Builders\PuestoBuilder query()
 * @method static \App\Builders\PuestoBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\PuestoBuilder where(string $column,string $value)
 * @method static \App\Builders\PuestoBuilder whereNotNull(string $column) 
 * @method static \App\Builders\PuestoBuilder whereNull(string $column) 
 * @method static \App\Builders\PuestoBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\PuestoBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class Puesto extends MaracModel
{
  public $timestamps = false;

  public $table = 'puesto';

  protected $primaryKey = 'codPuesto';

  protected $fillable = [
    'nombre',
    'estado'
  ];

  const Empleado = "Empleado/a";
  const Gerente = "Gerente";
  const Contador = "Contador/a";
  const Administrador = "Administrador";
  const UGE = "UGE";

  const Observador = "Observador/a";
  const ReportadorHoras = "Reportador Horas";
  const Conductor = "Conductor/a";

  const AprobadorViajes = "Aprobador/a de Viajes";


  public function getActivo()
  {
    if ($this->estado == '1')
      return "SÍ";

    return "NO";
  }
  public static function getCodigo($nombrePuesto)
  {
    $lista = Puesto::where('nombre', '=', $nombrePuesto)->get();
    if (count($lista) == 0)
      return "";
    return $lista[0]->codPuesto;
  }


  private static function getPuestoPorNombre($nombrePuesto)
  {
    return Puesto::where('nombre', '=', $nombrePuesto)->get()[0];
  }

  public static function getCodPuesto_Empleado()
  {
    return static::getPuestoPorNombre('Empleado')->codPuesto;
  }
  public static function getCodPuesto_Gerente()
  {
    return static::getPuestoPorNombre('Gerente')->codPuesto;
  }
  public static function getCodPuesto_Contador()
  {
    return static::getPuestoPorNombre('Contador')->codPuesto;
  }
  public static function getCodPuesto_Administrador()
  {
    return static::getPuestoPorNombre('Administrador')->codPuesto;
  }
  public static function getCodPuesto_UGE()
  {
    return static::getPuestoPorNombre('UGE')->codPuesto;
  }


  public static function getCodPuesto_Observador()
  {
    return static::getPuestoPorNombre('Observador')->codPuesto;
  }

  public static function getCodPuesto_AprobadorViajes()
  {
    return static::getPuestoPorNombre('aprobador_viajes')->codPuesto;
  }
  public static function getCodPuesto_Conductor()
  {
    return static::getPuestoPorNombre('Conductor')->codPuesto;
  }
}
