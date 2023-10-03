<?php

namespace App\Models\PPM;

use App\ArchivoGeneral;
use App\Distrito;
use App\MaracModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PPM_TipoOrganizacion extends MaracModel
{
    public $table = "ppm-tipo_organizacion";
    protected $primaryKey ="codTipoOrganizacion";

    public $timestamps = false;
    protected $fillable = [''];
    
    

}
