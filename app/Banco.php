<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER
/**
 * @property int $codBanco int(11)     
 * @property string $nombreBanco varchar(200)     
 * @method static Banco findOrFail($primary_key)
 * @method static Banco | null find($primary_key)
 * @method static BancoCollection all()
 * @method static \App\Builders\BancoBuilder query()
 * @method static \App\Builders\BancoBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\BancoBuilder where(string $column,string $value)
 * @method static \App\Builders\BancoBuilder whereNotNull(string $column) 
 * @method static \App\Builders\BancoBuilder whereNull(string $column) 
 * @method static \App\Builders\BancoBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\BancoBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class Banco extends MaracModel
{
  public $table = "banco";
  protected $primaryKey = "codBanco";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['nombreBanco'];
}
