<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoParametroSistema extends Model
{
     

    public $timestamps = false;
    public $table = 'tipo_parametro_sistema';

    protected $primaryKey = 'codTipoParametro';
    protected $fillable = [''];

    

}
