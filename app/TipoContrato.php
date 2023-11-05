<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoContrato extends MaracModel
{


    public $timestamps = false;
    public $table = 'tipo_contrato';

    protected $primaryKey = 'codTipoContrato';
    protected $fillable = [''];

}
