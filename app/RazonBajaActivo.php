<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RazonBajaActivo extends Model
{
    
    public $timestamps = false;
    public $table = 'inv-razon_baja_activo';

    protected $primaryKey = 'codRazonBaja';






}
