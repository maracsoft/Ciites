<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    public $timestamps = false;

    public $table = 'moneda';

    protected $primaryKey = 'codMoneda';

    protected $fillable = [
        'nombre','abreviatura','simbolo'
    ];






}
