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

class PPM_ActividadEconomica extends MaracModel
{
    public $table = "ppm-actividad_economica";
    protected $primaryKey ="codActividadEconomica";

    public $timestamps = false;
    protected $fillable = [''];

  }