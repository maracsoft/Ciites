<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndicadorObjEspecifico extends Model
{
    public $timestamps = false;

    public $table = 'indicador_objespecifico';

    protected $primaryKey = 'codIndicadorObj';

    protected $fillable = [
        'descripcion','codObjEspecifico'
    ];
}
