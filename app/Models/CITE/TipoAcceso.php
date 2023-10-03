<?php

namespace App\Models\CITE;

use Illuminate\Database\Eloquent\Model;

class TipoAcceso extends Model
{
    public $table = "cite-tipo_acceso";
    protected $primaryKey ="codTipoAcceso";

    public $timestamps = false;
    protected $fillable = [''];

    public static function getCodGratuito(){
      $lista = TipoAcceso::where('nombre',"Gratuito")->get();
      return $lista[0]->getId();
    }

    public static function getCodPagado(){
      $lista = TipoAcceso::where('nombre',"Pagado")->get();
      return $lista[0]->getId();
    }
}
