<?php

namespace App\Models\CITE;

use Illuminate\Database\Eloquent\Model;

class TipoPersoneria extends Model
{
    public $table = "cite-tipo_personeria";
    protected $primaryKey ="codTipoPersoneria";

    public $timestamps = false;
    protected $fillable = [''];


    /* Nombres de los tipo personeria que se copiaran al modulo de PPM como organizacion */
    const NombresTiposCopiarPPM = [
      "ASOCIACION",
      "COOPERATIVA"
    ];


}
