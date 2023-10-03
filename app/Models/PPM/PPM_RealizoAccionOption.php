<?php

namespace App\Models\PPM;

use App\ArchivoGeneral;
use App\Distrito;
use App\MaracModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PPM_RealizoAccionOption extends MaracModel
{
    public $table = "ppm-realizo_accion_option";
    protected $primaryKey ="id";

    public $timestamps = false;
    protected $fillable = [''];


     


}
