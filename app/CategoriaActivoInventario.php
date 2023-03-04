<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaActivoInventario extends Model
{
    public $timestamps = false;

    public $table = 'inv-categoria_activo_inventario';

    protected $primaryKey = 'codCategoriaActivo';

    protected $fillable = [
        'nombre'
    ];

    
}
