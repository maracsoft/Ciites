<?php

namespace App;

use App\Utils\Fecha;
use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codAvance int(11)     
 * @property string $descripcion varchar(300)     
 * @property string $fechaEntrega date     
 * @property float $porcentaje float     
 * @property float $monto float     
 * @property int $codContratoLocacion int(11)     
 * @method static AvanceEntregable findOrFail($primary_key)
 * @method static AvanceEntregable | null find($primary_key)
 * @method static AvanceEntregableCollection all()
 * @method static \App\Builders\AvanceEntregableBuilder query()
 * @method static \App\Builders\AvanceEntregableBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\AvanceEntregableBuilder where(string $column,string $value)
 * @method static \App\Builders\AvanceEntregableBuilder whereNotNull(string $column) 
 * @method static \App\Builders\AvanceEntregableBuilder whereNull(string $column) 
 * @method static \App\Builders\AvanceEntregableBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\AvanceEntregableBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class AvanceEntregable extends MaracModel
{
  public $timestamps = false;
  public $table = 'avance_entregable';

  protected $primaryKey = 'codAvance';
  protected $fillable = [''];


  public function getFechaEntrega()
  {
    return Fecha::formatoParaVistas($this->fechaEntrega);
  }

  function getMonto()
  {
    return number_format($this->monto, 2);
  }


  function getFechaEntregaEscrita()
  {
    return Fecha::escribirEnTexto($this->fechaEntrega);
  }
}
