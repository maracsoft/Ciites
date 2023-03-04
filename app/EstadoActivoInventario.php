<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoActivoInventario extends Model
{
    public $timestamps = false;

    public $table = 'inv-estado_activo_inventario';

    protected $primaryKey = 'codEstado';

    protected $fillable = [
        'nombre'
    ];

}
