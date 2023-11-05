<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moneda extends MaracModel
{
    public $timestamps = false;

    public $table = 'moneda';

    protected $primaryKey = 'codMoneda';

    protected $fillable = [
        'nombre','abreviatura','simbolo'
    ];






}
