<?php

namespace App\Models\CITE;

use App\ArchivoGeneral;
use App\Distrito;
use App\Fecha;
use App\Mes;
use Illuminate\Database\Eloquent\Model;

class Cadena extends Model
{
    public $table = "cite-cadena";
    protected $primaryKey ="codCadena";

    public $timestamps = false;
    protected $fillable = [''];

    

}