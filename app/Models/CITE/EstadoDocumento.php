<?php

namespace App\Models\CITE;

use Illuminate\Database\Eloquent\Model;

class EstadoDocumento extends Model
{
    public $table = "cite-estado_documento";
    protected $primaryKey ="codEstadoDocumento";

    public $timestamps = false;
    protected $fillable = [''];




}
