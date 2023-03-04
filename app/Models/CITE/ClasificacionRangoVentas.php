<?php

namespace App\Models\CITE;

use App\Distrito;
use Illuminate\Database\Eloquent\Model;

class ClasificacionRangoVentas extends Model
{
    public $table = "cite-clasificacion_rango_ventas";
    protected $primaryKey ="codClasificacion";

    public $timestamps = false;
    protected $fillable = [''];




}
