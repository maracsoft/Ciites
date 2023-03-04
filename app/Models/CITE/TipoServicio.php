<?php

namespace App\Models\CITE;

use Illuminate\Database\Eloquent\Model;

class TipoServicio extends Model
{
    public $table = "cite-tipo_servicio";
    protected $primaryKey ="codTipoServicio";

    public $timestamps = false;
    protected $fillable = [''];


    function getActividades(){
        return ActividadCite::where('codTipoServicio',$this->getId())->get();
    }

}
