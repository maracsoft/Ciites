<?php

namespace App\Models\PPM;

use App\ArchivoGeneral;
use App\Distrito;
use App\Empleado;
use App\Fecha;
use App\MaracModel;
use App\MesAño;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PPM_TipoDocumento extends MaracModel
{
    public $table = "ppm-tipo_documento";
    protected $primaryKey ="codTipoDocumento";

    public $timestamps = false;
    protected $fillable = [''];

    const RUC = 1;
    const NoRuc = 2;
    
     

}
