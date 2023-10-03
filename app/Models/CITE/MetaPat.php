<?php

namespace App\Models\CITE;

use App\ArchivoGeneral;
use App\Distrito;
use App\Fecha;
use App\MaracModel;
use App\Mes;
use Illuminate\Database\Eloquent\Model;

class MetaPat extends MaracModel {
    
    public $table = "cite-meta_pat";
    protected $primaryKey ="codMeta";

    public $timestamps = false;
    protected $fillable = [''];


}