<?php

namespace App\Models\CITE;

use Illuminate\Database\Eloquent\Model;

class TipoAcceso extends Model
{
    public $table = "cite-tipo_acceso";
    protected $primaryKey ="codTipoAcceso";

    public $timestamps = false;
    protected $fillable = [''];




}
